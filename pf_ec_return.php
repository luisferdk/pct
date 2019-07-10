<?php
require_once 'inc/config.php';
require_once('paypal/Class.PayFlow.php');
$paypal_checkout_link = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";

// SET TO '1' FOR REAL TRANSACTIONS !!!!!!!!
$paypal_live_account = 1;

/*
echo('<h2>GET - DATA From Paypal AFTER SET:</h2>');
echo('<pre>');
print_r($_GET);
echo('</pre>');
echo('<hr>');
echo('<h2>POST - DATA From Paypal AFTER SET:</h2>');
echo('<pre>');
print_r($_POST);
echo('</pre>');
exit();
*/

$protocol = 'http://';
$site = strtolower($_SERVER['HTTP_HOST']);
//if(isset($_SERVER["HTTPS"]))
//   $protocol = 'https://';
$url = $protocol.$site;

if($_GET['token'])
   {
// after Set checkout
// do GET checkout
$checkout_id = $_SESSION["checkout"]["id"];
$_SESSION["checkout_payer_id"] = $_GET["PayerID"];

$PayFlow = new PayFlow('caribbeandream', 'PayPal', 'caribbeandream', 'jersey824', 'single');

$PayFlow->setEnvironment('live');                           // test or live
$PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
$PayFlow->setPaymentMethod('P');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
//$PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
$PayFlow->setProfileAction('G');							// Get Express Details
//$PayFlow->setToken('EC-0HM39304DX416460M');				// INVALID TOKEN
$PayFlow->setToken($_GET['token']);							// TOKEN

$result = $PayFlow->processTransaction();
$response = $PayFlow->getResponse();

$debug_data = $PayFlow->debugNVP('array');
unset($debug_data['USER']);
unset($debug_data['PWD']);

$rr = mysql_real_escape_string(json_encode($response));
$dd = mysql_real_escape_string(json_encode($debug_data));

	$cart_sql = "update sales_transactions_pre set
	ppdebug = '$dd',
	ppresponse = '$rr'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

if(!$result)
   {

	$_SESSION["checkout_error"] = 'paypal';
	$_SESSION["checkout"]["ppresponse"]["RESPMSG"] = $response["RESPMSG"];
	header( 'Location: '.$url.'/checkout-error.php' ) ;
	return;
   }

// Get transaction OK
//  echo('Transaction GET OK.');
unset($PayFlow);

    $ship = mysql_real_escape_string($response['SHIPTOSTREET'].', '.$response['SHIPTOCITY'].', '.$response['SHIPTOZIP'].', '.$response['SHIPTOCOUNTRY']);
	$fname = mysql_real_escape_string($response['FIRSTNAME']);
	$lname = mysql_real_escape_string($response['LASTNAME']);
	
	$cart_sql = "update sales_transactions_pre set
    pp_fname = '$fname', 
	pp_lname = '$lname', 
	pp_email = '$response[EMAIL]', 
	pp_country = '$response[COUNTRYCODE]', 
	pp_ship = '$ship',
	step = '4'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

// ---------------------------------------------------------------------
// Finish paypal

$PayFlow = new PayFlow('caribbeandream', 'PayPal', 'caribbeandream', 'jersey824', 'single');

$PayFlow->setEnvironment('live');                           // test or live
$PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
$PayFlow->setPaymentMethod('P');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
$PayFlow->setProfileAction('D');							// Do Express Transaction
$PayFlow->setToken($response['TOKEN']);							// TOKEN
$PayFlow->setPayerID($response['PAYERID']);							// PAYERID

$total = getCartTotal();
$PayFlow->setAmount($total.'.00', FALSE);
$PayFlow->setPaymentComment('Payment to '.ucfirst(strtolower($_SERVER['HTTP_HOST'])));
$PayFlow->setPaymentComment2('Express Checkout via PayFlow');
//$PayFlow->setCustomField('CustomerFeild', date("Y-m-d H:i:s"));


$result = $PayFlow->processTransaction();
$response = $PayFlow->getResponse();

$debug_data = $PayFlow->debugNVP('array');
unset($debug_data['USER']);
unset($debug_data['PWD']);

$rr = mysql_real_escape_string(json_encode($response));
$dd = mysql_real_escape_string(json_encode($debug_data));

	$cart_sql = "update sales_transactions_pre set
	ppdebug = '$dd',
	ppfinal = '$rr'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

unset($PayFlow);
	
	if(!$result) {

	$_SESSION["checkout_error"] = 'paypal';
	$_SESSION["checkout"]["ppresponse"]["RESPMSG"] = $response["RESPMSG"];
	    header( 'Location: '.$url.'/checkout-error.php' ) ;
	    return;
	}

// move the transaction data to main table

$s = "DROP TABLE IF EXISTS tmp";
$res = mysql_query($s) or die(mysql_error());

// copy transaction record to temp table
$s = "CREATE TEMPORARY TABLE tmp SELECT * from sales_transactions_pre WHERE st_id = '$checkout_id'";

$res = mysql_query($s);
if(!$res)
   {
//   echo '<pre>';
//   print_r($_SESSION);
//   echo '</pre>';
//   echo $s.'<br>';
   die(mysql_error());
   }

// drop 'st_id' column
$s = "ALTER TABLE tmp drop st_id";
$res = mysql_query($s) or die(mysql_error());
// set 'TEST' field
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// should be removed !!!
if(!$paypal_live_account)
   {
   $s = "update tmp set test = '1'";
   $res = mysql_query($s) or die(mysql_error());
   }
// insert 
$s = "INSERT INTO sales_transactions SELECT 0,tmp.* FROM tmp";
$res = mysql_query($s) or die(mysql_error());
$transaction_id = mysql_insert_id();
// delete record
$s = "delete from sales_transactions_pre WHERE st_id = '$checkout_id'";
$res = mysql_query($s) or die(mysql_error());
// drop temp table
$s = "DROP TABLE tmp";
$res = mysql_query($s) or die(mysql_error());

// copy tours record to temp table
$s = "CREATE TEMPORARY TABLE tmp SELECT * from sales_excursions_pre WHERE st_id = '$checkout_id'";
$res = mysql_query($s) or die(mysql_error());
// drop 'se_id' column
$s = "ALTER TABLE tmp drop se_id";
$res = mysql_query($s) or die(mysql_error());
// set 'st_id' field
$s = "update tmp set st_id = '$transaction_id'";
$res = mysql_query($s) or die(mysql_error());
// insert 
$s = "INSERT INTO sales_excursions SELECT 0,tmp.* FROM tmp";
$res = mysql_query($s) or die(mysql_error());
// delete record
$s = "delete from sales_excursions_pre WHERE st_id = '$checkout_id'";
$res = mysql_query($s) or die(mysql_error());
// drop temp table
$s = "DROP TABLE tmp";
$res = mysql_query($s) or die(mysql_error());

// copy transfers record to temp table
$s = "CREATE TEMPORARY TABLE tmp SELECT * from sales_airport_pickups_pre WHERE st_id = $checkout_id";
$res = mysql_query($s) or die(mysql_error());
// drop 'sap_id' column
$s = "ALTER TABLE tmp drop sap_id";
$res = mysql_query($s) or die(mysql_error());
// set 'st_id' field
$s = "update tmp set st_id = '$transaction_id'";
$res = mysql_query($s) or die(mysql_error());
// insert 
$s = "INSERT INTO sales_airport_pickups SELECT 0,tmp.* FROM tmp";
$res = mysql_query($s) or die(mysql_error());
// delete record
$s = "delete from sales_airport_pickups_pre WHERE st_id = '$checkout_id'";
$res = mysql_query($s) or die(mysql_error());
// drop temp table
$s = "DROP TABLE tmp";
$res = mysql_query($s) or die(mysql_error());


/*
  CREATE TEMPORARY TABLE tmp SELECT * from invoices WHERE ...;
    ALTER TABLE tmp drop ID; # drop autoincrement field
    # UPDATE tmp SET ...; # just needed to change other unique keys
    INSERT INTO invoices SELECT 0,tmp.* FROM tmp;
    DROP TABLE tmp;
*/

if($paypal_live_account)
   {

$idevaffstr='';
$itemsbought=array();

foreach($_SESSION["cart"] as $item) {
 $temp_str=trim(str_replace(' ','-',$item["name"]));
 $itemsbought["$temp_str"]=$item["quantity"];
}

foreach($itemsbought as $ikey=> $iboutitem) {
	for($ik=0;$ik<$iboutitem;$ik++){
        $idevaffstr = $idevaffstr.$ikey.'|';
		}
	}
$idev_option_3='';
$idev_option_1=$_SESSION["checkout"]["first_name"].' '.$_SESSION["checkout"]["last_name"];

foreach($_SESSION["cart"] as $item) {

if($idev_option_3=='')
	$idev_option_3 = $item["quantity"].'  '.trim($item["name"]);
else
	$idev_option_3 = $idev_option_3.'---'.$item["quantity"].'  '.trim($item["name"]);

	}

$atemp="&idev_option_1=$idev_option_1&idev_option_3=$idev_option_3";

$idevtpxl='//affiliates.CaribbeanDreamTO.com/sale.php?profile=72198&idev_saleamt='.number_format(getCartTotal(), 2).'&idev_ordernum='.$response["PNREF"].'&products_purchased='.rtrim($idevaffstr, '|'); ;

$idevtpxl=$idevtpxl.$atemp;

$_SESSION['idevsdone']="<img border='0' src='$idevtpxl' width='1' height='1'>";
   }
   
// unset checkout session 
    $_SESSION["checkout_closed"] = $_SESSION["checkout"];
	$_SESSION['checkout_closed']['id'] = $transaction_id;
	$_SESSION["cart_closed"] = $_SESSION["cart"];
	
	unset($_SESSION["checkout"]);
	setcookie("checkout", "", time()-3600);
	
	$_SESSION["cart"] = array();
	setcookie("cart", "", time()-3600);
	unset($_SESSION["checkout_step"]);

if($paypal_live_account)
   {
	$_SESSION["google_ecommerce"] = 1;
   }
   
	header( 'Location: '.$url.'/checkout-ok.php' ) ;
	return;
	
	
	
/*
REQUEST
Array
(
    [token] => EC-3HM39304DX416460M
    [PayerID] => RZXQ8JFVNUM96
    [_ga] => GA1.2.1334066474.1466962385
    [hblid] => jJEqZsX2m2nBzTQd3k3Bo132CL30PITM
    [olfsk] => olfsk20625547636841757
    [cart] => {"1-196-1":{"type":1,"id":196,"link":"zipline-hoyo-azul","name":"Zip Line and Hoyo Azul Adult","sku":"SP-HaZip-A","price":109,"list_price":118,"quantity":2,"date":"04-29-2017","time":"","hotel":"7","extra_price":0}}
    [checkout] => {"first_name":"Alex","last_name":"Karaguzin","email":"ealexnet@gmail.com","phone":"223344","msg":"TEST","id":13121}
    [PHPSESSID] => 15345ddb1a50ebf2d27d52c4c1eb7c27
    [wcsid] => ChGP3KTm9KpWQRsE3k3Bo0L8E0P0P21A
    [_oklv] => 1492629886823,ChGP3KTm9KpWQRsE3k3Bo0L8E0P0P21A
    [_okdetect] => {"token":"14926291167810","proto":"https:","host":"puntacanatours.com"}
    [_okbk] => cd5=available,cd4=true,vi5=0,vi4=1492629117028,vi3=active,vi2=false,vi1=false,cd8=chat,cd6=0,cd3=false,cd2=0,cd1=0,
    [_ok] => 5454-501-10-3463
    [_gat] => 1
)
RESPONSE
Array
(
    [RESULT] => 0
    [RESPMSG] => Approved
    [AVSADDR] => Y
    [AVSZIP] => Y
    [TOKEN] => EC-3HM39304DX416460M
    [PAYERID] => RZXQ8JFVNUM96
    [CORRELATIONID] => a628c30643475
    [EMAIL] => ealexnet@gmail.com
    [PAYERSTATUS] => verified
    [FIRSTNAME] => ааЛаЕаКбаЕаЙ
    [LASTNAME] => ааАбаАаГбаЗаИаН
    [SHIPTOSTREET] => ааИбаОаВаА, 38-3
    [SHIPTOCITY] => аЃаЛббаНаОаВбаК
    [SHIPTOZIP] => 432000
    [SHIPTOCOUNTRY] => RU
    [SHIPTONAME] => ааАбаАаГбаЗаИаН ааЛаЕаКбаЕаЙ
    [COUNTRYCODE] => RU
    [ADDRESSSTATUS] => Y
)

    [RESULT] => 0
    [RESPMSG] => Approved
    [AVSADDR] => Y
    [AVSZIP] => Y
    [TOKEN] => EC-97172107ML654073S
    [PAYERID] => RZXQ8JFVNUM96
    [CORRELATIONID] => 4bc7e79ca2fd3
    [EMAIL] => ealexnet@gmail.com
    [PAYERSTATUS] => verified
    [FIRSTNAME] => ааЛаЕаКбаЕаЙ
    [LASTNAME] => ааАбаАаГбаЗаИаН
    [SHIPTOSTREET] => Kirova, 38-3
    [SHIPTOCITY] => Ulyanovsk
    [SHIPTOSTATE] => ULYANOVSKAYA
    [SHIPTOZIP] => 432000
    [SHIPTOCOUNTRY] => RU
    [SHIPTONAME] => Alexei Karagouzine
    [COUNTRYCODE] => RU
    [ADDRESSSTATUS] => Y
*/  
  

  
/*  
echo('<h2>Name Value Pair String:</h2>');
echo('<pre>');
print_r($PayFlow->debugNVP('array'));
echo('</pre>');
echo ('<hr>');


echo('<h2>REQUEST - DATA From Paypal AFTER SET/DO:</h2>');
echo('<pre>');
print_r($_REQUEST);
echo('</pre>');
echo ('<hr>');
echo('<h2>RESPONSE- RESPONSE From Paypal after SET/DO:</h2>');
echo('<pre>');
print_r($response);
echo('</pre>');

exit();
*/
   }
else
   {
// after DO checkout
// show thank you page
  echo('Transaction GET TOKEN NOT RECEIVED.');
   
   }	
?>
