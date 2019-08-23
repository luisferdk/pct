<?php
//require_once 'inc/config.php';
//require_once 'inc/cart-manager-pp.php'; 
require_once('paypal/Class.PayFlow.php');

// https://puntacanatours.com/pf_ec_1.php
 
//$paypal_checkout_link = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
$paypal_checkout_link = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
                        

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

$checkout_id = $_SESSION["checkout"]["id"];

	$cart_sql = "update sales_transactions_pre set
	billstreet = '$billstreet',
	billcity = '$billcity',
	billstate = '$billstate',
	billzip = '$billzip',
	billcountry = '$billcountry'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());
*/

// Single Transaction
$PayFlow = new PayFlow('caribbeandream', 'PayPal', 'caribbeandream', 'jersey824', 'single');

$PayFlow->setEnvironment('live');                           // test or live
$PayFlow->setTransactionType('S');                          // S = Sale transaction, R = Recurring, C = Credit, A = Authorization, D = Delayed Capture, V = Void, F = Voice Authorization, I = Inquiry, N = Duplicate transaction
$PayFlow->setPaymentMethod('P');                            // A = Automated clearinghouse, C = Credit card, D = Pinless debit, K = Telecheck, P = PayPal.
$PayFlow->setPaymentCurrency('USD');                        // 'USD', 'EUR', 'GBP', 'CAD', 'JPY', 'AUD'.
$PayFlow->setProfileAction('S');							// Set Express Checkout

//$total = getCartTotal();
$PayFlow->setAmount('12.00', FALSE);

//$PayFlow->setCustomerFirstName('Alex');
//$PayFlow->setCustomerLastName('Kar');

//$PayFlow->setCustomerPhone('222-333-444');
//$PayFlow->setCustomerEmail('toursinpuntacanatest@test.com');

$PayFlow->setReturnURL('http://puntacanatours.com/pf_ec_return.php');
$PayFlow->setCancelURL('http://puntacanatours.com/pf_ec_cancel.php');

$PayFlow->setPaymentComment('Payment to '.ucfirst(strtolower($_SERVER['HTTP_HOST'])));
//$PayFlow->setPaymentComment2('TRANSACTION ID: 34567');
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
	
if($result)
   {
//   $_SESSION["checkout_token"] = urldecode($results["TOKEN"]);
//echo 'Location: ' . $paypal_checkout_link . $response["TOKEN"];

header( 'Location: ' . $paypal_checkout_link . urldecode($response["TOKEN"]) ) ;
//header( 'Location: https://pilot-payflowpro.paypal.com') ;


exit();
   }	
else
  echo('Transaction could not be processed at this time.');


echo('<h2>Response From Paypal:</h2>');
echo('<pre>');
print_r($response);
echo('</pre>');
 
?>
