<?php
require_once 'inc/config.php';
require_once 'inc/cart-manager-pp.php'; 

checkout_pp_ok();

$paypal_live_account = $_SESSION["checkout_paypal_account"];   
require_once 'inc/config-pp.php';
	
$_SESSION["checkout_payer_id"] = $_GET["PayerID"];
//$_SESSION["checkout_token"]	= $_GET["token"];

$checkout_id = $_SESSION["checkout"]["id"];

$protocol = 'http://';
$site = strtolower($_SERVER['HTTP_HOST']);
//if(isset($_SERVER["HTTPS"]))
//   $protocol = 'https://';
$url = $protocol.$site;

// ---------------------------------------------------------------------
// Start paypal info	

	$curl = curl_init();
//	'METHOD' => "DoExpressCheckoutPayment",

	$requestParams = array(
	'METHOD' => "GetExpressCheckoutDetails",
		'VERSION' => "106.0" ,
		'USER' => $paypal_user,
		'PWD' => $paypal_pwd,
		'SIGNATURE' => $paypal_signature,
		'TOKEN' => $_SESSION["checkout_token"]
	);
	
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $paypal_endpoint,
		CURLOPT_POST => 1,
	));
	curl_setopt($curl, CURLOPT_POSTFIELDS , http_build_query($requestParams));

	// Send the request & save response to $resp
	$resp = curl_exec($curl);

	// Close request to clear up some resources
	curl_close($curl);

	$results = array();
	$resultPairs = explode("&", $resp);
	foreach ($resultPairs as $pair) {
		list($key, $val) = explode("=", $pair);
		$results[$key] = urldecode($val);
	}

    $rr = mysql_real_escape_string(json_encode($results));
	
	if($results["ACK"] != "Success") {
	$cart_sql = "update sales_transactions_pre set
	ppresponse = '$rr'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

	$_SESSION["checkout_error"] = 'paypal';
	$_SESSION["checkout"]["ppresponse"]["RESPMSG"] = $results["ACK"];
	    header( 'Location: '.$url.'/checkout-error.php' ) ;
	    return;
	}

    $ship = mysql_real_escape_string($results['SHIPTOSTREET'].', '.$results['SHIPTOCITY'].', '.$results['SHIPTOSTATE'].', '.$results['SHIPTOZIP'].', '.$results['SHIPTOCOUNTRYNAME']);
	
	$fname = mysql_real_escape_string($results['FIRSTNAME']);
	$lname = mysql_real_escape_string($results['LASTNAME']);
	
	$cart_sql = "update sales_transactions_pre set
    pp_fname = '$fname', 
	pp_lname = '$lname', 
	pp_email = '$results[EMAIL]', 
	pp_country = '$results[COUNTRYCODE]', 
	pp_ship = '$ship',
	ppresponse = '$rr',
	step = '4'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

// ---------------------------------------------------------------------
// Finish paypal

	$curl = curl_init();

	$requestParams = array(
	'METHOD' => "DoExpressCheckoutPayment",
		'TOKEN' => $_SESSION["checkout_token"],
		'PAYERID' => $results['PAYERID'],
		'PAYMENTACTION' => 'Sale',
		'AMT' => $results['AMT'],
		'VERSION' => "106.0" ,
		'USER' => $paypal_user,
		'PWD' => $paypal_pwd,
		'SIGNATURE' => $paypal_signature,
	);
	
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $paypal_endpoint,
		CURLOPT_POST => 1,
	));
	curl_setopt($curl, CURLOPT_POSTFIELDS , http_build_query($requestParams));

	// Send the request & save response to $resp
	$resp = curl_exec($curl);

	// Close request to clear up some resources
	curl_close($curl);

	$results = array();
	$resultPairs = explode("&", $resp);
	foreach ($resultPairs as $pair) {
		list($key, $val) = explode("=", $pair);
		$results[$key] = urldecode($val);
	}

//    $rr = json_encode($results);
    $rr = mysql_real_escape_string(json_encode($results));

	$cart_sql = "update sales_transactions_pre set
	ppfinal = '$rr'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());
	
	if($results["ACK"] != "Success") {

	$_SESSION["checkout_error"] = 'paypal';
	$_SESSION["checkout"]["ppresponse"]["RESPMSG"] = $results["ACK"];
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
	
	header( 'Location: '.$url.'/checkout-ok.php' ) ;
	return;
		
	
//echo '<pre>';
//print_r($results);
//echo '</pre>';
?>