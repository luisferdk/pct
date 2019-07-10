<?php
require_once 'inc/config.php';
//require_once 'inc/cart-manager-pp.php'; 
require_once('paypal/Class.PayFlow.php');

$protocol = 'http://';
$site = strtolower($_SERVER['HTTP_HOST']);
//if(isset($_SERVER["HTTPS"]))
//   $protocol = 'https://';
$url = $protocol.$site;
 
//$paypal_checkout_link = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
$paypal_checkout_link = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=commit&token=";
                        

// Save billing info
/*
$billstreet = mysql_real_escape_string($_POST['billstreet']);
$billcity = mysql_real_escape_string($_POST['billcity']);
$billcountry = mysql_real_escape_string($_POST['billcountry']);
if($billcountry == 'US' || $billcountry == 'CA')
   $billstate = mysql_real_escape_string($_POST['billstate']);
else
   $billstate = mysql_real_escape_string($_POST['billstateother']);
$billzip = mysql_real_escape_string($_POST['billzip']);
*/
$checkout_id = $_SESSION["checkout"]["id"];
/*
	$cart_sql = "update sales_transactions_pre set
	billstreet = '$billstreet',
	billcity = '$billcity',
	billstate = '$billstate',
	billzip = '$billzip',
	billcountry = '$billcountry'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());
*/
/*
TRXTYPE=S 
&ACTION=S 
AMT=35.00 
//&CANCELURL=http://www.order_page.com 
&CUSTOM=TRVV14459 
&EMAIL=buyer_name@abc.com 
//&PARTNER=partner 
//&PWD=password 
//&RETURNURL=http://www.confirmation_page.com 
//&TENDER=P 
//&USER=user 
//&VENDOR=vendor
*/
// Single Transaction
$PayFlow = new PayFlow('caribbeandream', 'PayPal', 'caribbeandream', 'jersey824', 'single');

$PayFlow->setEnvironment('live');                           // (test or live)
$PayFlow->setTransactionType('S');                          // 'TRXTYPE': S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
$PayFlow->setPaymentMethod('P');                            // 'TENDER: 'A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
$PayFlow->setPaymentCurrency('USD');                        // 'CURRENCY': 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
$PayFlow->setProfileAction('S');							// 'ACTION' Set Express Checkout

$total = getCartTotal();
$PayFlow->setAmount($total.'.00', FALSE);

$PayFlow->setCustomerFirstName($_SESSION["checkout"]["first_name"]);
$PayFlow->setCustomerLastName($_SESSION["checkout"]["last_name"]);

$PayFlow->setCustomerPhone($_SESSION["checkout"]["phone"]);
$PayFlow->setCustomerEmail($_SESSION["checkout"]["email"]);

$PayFlow->setReturnURL('https://puntacanatours.com/pf_ec_return.php'); // 'RETURNURL'
$PayFlow->setCancelURL('https://puntacanatours.com/pf_ec_cancel.php'); // 'CANCELURL'

//$PayFlow->setPaymentComment('TEST Payment to '.ucfirst(strtolower($_SERVER['HTTP_HOST'])).' (LIVE mode)');
//$PayFlow->setPaymentComment2('TEST TRANSACTION: '.date("Y-m-d H:i:s"));
//$PayFlow->setCustomField('CustomerFeild', date("Y-m-d H:i:s"));

//$PayFlow->setPaymentComment('Payment to '.ucfirst(strtolower($_SERVER['HTTP_HOST'])));
//$PayFlow->setPaymentComment2('TEST TRANSACTION: '.date("Y-m-d H:i:s");
//$PayFlow->setCustomField('CustFld', 'Aug 11, product 222');

$result = $PayFlow->processTransaction();
$response = $PayFlow->getResponse();

$debug_data = $PayFlow->debugNVP('array');
unset($debug_data['USER']);
unset($debug_data['PWD']);

/*
echo('<h2>Name Value Pair String:</h2>');
echo('<pre>');
print_r($PayFlow->debugNVP('array'));
echo('</pre>');
*/
unset($PayFlow);

$rr = mysql_real_escape_string(json_encode($response));
$dd = mysql_real_escape_string(json_encode($debug_data));

	$cart_sql = "update sales_transactions_pre set
	ppdebug = '$dd',
	ppresponse = '$rr'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

if(!$result)
   {
   // FAIL
//
    $msg = 'There was an error communicating with PayPal.';
	if(isset($response["RESPMSG"]))
	   $msg .= '<br><br>'.urldecode($response["RESPMSG"]);
		
/*
    if(isset($results["L_SHORTMESSAGE0"]))
	   $msg .= '<br><br>'.urldecode($results["L_SHORTMESSAGE0"]);
    if(isset($results["L_LONGMESSAGE0"]))
	   $msg .= '<br><br>'.urldecode($results["L_LONGMESSAGE0"]);
*/	
    $_SESSION["checkout"]["ppresponse"]["RESPMSG"] = $msg;
	
	$_SESSION["checkout_error"] = 'paypal';
	header( 'Location: '.$url.'/checkout-error.php' ) ;
	return;   
   }

$_SESSION["checkout_token"] = urldecode($response["TOKEN"]);
header( 'Location: ' . $paypal_checkout_link . urldecode($response["TOKEN"]) ) ;
return;
 
?>
