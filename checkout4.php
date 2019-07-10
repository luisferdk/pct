<?php
require_once 'inc/config.php';
require_once 'inc/cart-manager-pp.php'; 

checkout4();

require_once('paypal/Class.PayFlow.php');

/*
Array
(
    [RESULT] => 0
    [PNREF] => B10P6F6DCD4F
    [RESPMSG] => Approved
    [AUTHCODE] => 111111
    [AVSADDR] => Y
    [AVSZIP] => Y
    [CVV2MATCH] => N
    [PPREF] => N5W4MDZP61BHTQ68Y
    [CORRELATIONID] => 2c9706997458s
    [PROCAVS] => Y
    [PROCCVV2] => N
    [IAVS] => N
)




SESSION:

Array
(
    [cart] => Array
        (
            [1-201-1] => Array
                (
                    [type] => 1
                    [id] => 201
                    [link] => macao-buggies
                    [name] => Macao Buggies Solo
                    [price] => 95
                    [quantity] => 2
                    [date] => 08-06-2014
                    [time] => morning
                    [hotel] => 2
                )

            [2-pujWestin Puntacana-1] => Array
                (
                    [type] => 2
                    [quantity] => 1
                    [passenger_count] => 2
                    [passenger_hotel] => Westin Puntacana
                    [passenger_airport] => puj
                    [transfer_type] => 1
                    [transfer_type_str] => Round Trip
                    [name] => Round-trip PUJ to Westin Puntacana
                    [price] => 70
                    [arrival_date] => 2014-08-15 0:mm:00
                    [arrival_airline] => Air Antilles
                    [arrival_flight] => 2233
                    [departure_date] => 2014-08-23 0:mm:00
                    [departure_airline] => Air Antilles
                    [departure_flight] => 4455
                    [comments] => 
                )

        )

    [checkout_step] => 3
    [checkout_first_name] => 
    [checkout_last_name] => 
    [checkout_email] => 
    [checkout_phone] => 
    [checkout_msg] => 
    [customer_data] => Array
        (
            [custname] => Alex Kar
            [custemail] => ealexnet@mail.ru
            [custphone] => 222-333-4445
            [message] => Some comments
            [action] => toStep3
        )

)

POST:

Array
(
    [transtype] => test
    [ccname] => Alex Kar
    [ccnumber] => 4111111111111111
    [expiry_month] => 12
    [expiry_year] => 14
    [cvv] => 468
    [billstreet] => 
    [billcity] => 
    [billstate] => State/Province
    [billzip] => 
    [billcountry] => 0
)

*/
// Save billing info
$billstreet = mysql_real_escape_string($_POST['billstreet']);
$billcity = mysql_real_escape_string($_POST['billcity']);
$billcountry = mysql_real_escape_string($_POST['billcountry']);
if($billcountry == 'US' || $billcountry == 'CA')
   $billstate = mysql_real_escape_string($_POST['billstate']);
else
   $billstate = mysql_real_escape_string($_POST['billstateother']);
$billzip = mysql_real_escape_string($_POST['billzip']);

$checkout_id = $_SESSION["checkout"]["id"];

	$cart_sql = "update sales_transactions_pre set
	billstreet = '$billstreet',
	billcity = '$billcity',
	billstate = '$billstate',
	billzip = '$billzip',
	billcountry = '$billcountry'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());


// Single Transaction
$PayFlow = new PayFlow('caribbeandream', 'PayPal', 'caribbeandream', 'jersey824', 'single');

$PayFlow->setEnvironment($_POST['transtype']);                           // test or live
$PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
$PayFlow->setPaymentMethod('C');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
$PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.

//$total = getCartTotal();
if($_POST['override'])
   $PayFlow->setAmount(number_format($_POST['override'], 2), FALSE);
else
   $PayFlow->setAmount(number_format(getCartTotal(), 2), FALSE);
$PayFlow->setCCNumber($_POST['ccnumber']);
$PayFlow->setCVV($_POST['cvv']);
$PayFlow->setExpiration($_POST['expiry_month'].$_POST['expiry_year']);
$PayFlow->setCreditCardName($_POST['ccname']);

$PayFlow->setCustomerFirstName($_SESSION["checkout"]["first_name"]);
$PayFlow->setCustomerLastName($_SESSION["checkout"]["last_name"]);
if($_POST['billstreet'])
   $PayFlow->setCustomerAddress($_POST['billstreet']);
if($_POST['billcity'])
   $PayFlow->setCustomerCity($_POST['billcity']);
if($_POST['billcountry'] && $_POST['billcountry'] != '00')
   {
   $PayFlow->setCustomerCountry($_POST['billcountry']);
   if($_POST['billcountry'] == 'US' || $_POST['billcountry'] == 'CA')
      {
      if($_POST['billstate'] && $_POST['billstate'] != '00' && $_POST['billstate'] != '--')
         $PayFlow->setCustomerState($_POST['billstate']);
	  }
    else
      {
      if($_POST['billstateother'])
         $PayFlow->setCustomerState($_POST['billstateother']);
      }	  
   } 
if($_POST['billzip'])
   $PayFlow->setCustomerZip($_POST['billzip']);
if($_SESSION["checkout_phone"])
   $PayFlow->setCustomerPhone($_SESSION["checkout"]["phone"]);
$PayFlow->setCustomerEmail($_SESSION["checkout"]["email"]);
$PayFlow->setPaymentComment('Payment to '.ucfirst(strtolower($_SERVER['HTTP_HOST'])));
$PayFlow->setPaymentComment2('Credit Card Checkout via PayFlow');

//$PayFlow->setCustomField('CustFld', 'Aug 11, product 222');

$result = $PayFlow->processTransaction();
$response = $PayFlow->getResponse();

$debug_data = $PayFlow->debugNVP('array');

/* 
echo('<h2>Name Value Pair String:</h2>');
echo('<pre>');
print_r($PayFlow->debugNVP('array'));
echo('</pre>');
*/
unset($PayFlow);

unset($debug_data['USER']);
unset($debug_data['PWD']);
unset($debug_data['ACCT']);
unset($debug_data['CVV2']);
unset($debug_data['EXPDATE']);

$dd = mysql_real_escape_string(json_encode($debug_data));
$rr = mysql_real_escape_string(json_encode($response));
/*
	$cart_sql = "update sales_transactions_pre set
	billstreet = '$billstreet',
	billcity = '$billcity',
	billstate = '$billstate',
	billzip = '$billzip',
	billcountry = '$billcountry',
	ppresponse = '$rr',
	ppdebug = '$dd',
	step = '4'
	where st_id='$checkout_id'";			
*/
	$cart_sql = "update sales_transactions_pre set
	ppresponse = '$rr',
	ppdebug = '$dd',
	step = '4'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

if($result)
{
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
if($_POST['transtype'] == 'test')
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

$idevtpxl='//affiliates.CaribbeanDreamTO.com/sale.php?profile=72198&idev_saleamt='.number_format(getCartTotal(), 2).'&idev_ordernum='.$results["PAYMENTINFO_0_TRANSACTIONID"].'&products_purchased='.rtrim($idevaffstr, '|'); ;

$idevtpxl=$idevtpxl.$atemp;

$_SESSION['idevsdone']="<img border='0' src='$idevtpxl' width='1' height='1'>";


// unset checkout session 
    $_SESSION["checkout_closed"] = $_SESSION["checkout"];
	$_SESSION['checkout_closed']['id'] = $transaction_id;
	$_SESSION["cart_closed"] = $_SESSION["cart"];
	
	unset($_SESSION["checkout"]);
	setcookie("checkout", "", time()-3600);
	
	$_SESSION["cart"] = array();
	setcookie("cart", "", time()-3600);
	unset($_SESSION["checkout_step"]);

	$_SESSION["google_ecommerce"] = 1;
	
	header( 'Location: checkout-ok.php' ) ;
	return;
	
}
else
{
	$_SESSION["checkout_error"] = 'cc';
	$_SESSION["checkout"]["ppresponse"] = $response;
	header( 'Location: checkout-error.php' ) ;
	return;

}
	
/*
if($result)
  echo('Transaction Processed Successfully!');
else
  echo('Transaction could not be processed at this time.');


echo('<h2>Response From Paypal:</h2>');
echo('<pre>');
print_r($response);
echo('</pre>');
 
*/	
?>
