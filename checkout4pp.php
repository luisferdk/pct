<?php
require_once 'inc/config.php';
require_once 'inc/cart-manager-pp.php'; 

checkout4pp();

$checkout_id = $_SESSION["checkout"]["id"];

$monthDisplay = array();
$monthDisplay["01"] = "Jan";
$monthDisplay["02"] = "Feb";
$monthDisplay["03"] = "Mar";
$monthDisplay["04"] = "Apr";
$monthDisplay["05"] = "May";
$monthDisplay["06"] = "Jun";
$monthDisplay["07"] = "Jul";
$monthDisplay["08"] = "Aug";
$monthDisplay["09"] = "Sep";
$monthDisplay["10"] = "Oct";
$monthDisplay["11"] = "Nov";
$monthDisplay["12"] = "Dec";

/* SetExpressCheckout call */

$protocol = 'http://';
$site = strtolower($_SERVER['HTTP_HOST']);
//if(isset($_SERVER["HTTPS"]))
//   $protocol = 'https://';
$url = $protocol.$site;

// -------------------------------------------------------------------------
//$_POST['transtype'] = 'live';
// -------------------------------------------------------------------------

$paypal_live_account = false;
if(isset($_POST['transtype']))
   {
   $paypal_live_account = ($_POST['transtype'] == 'live' ? 1 : 0);
   }
$_SESSION["checkout_paypal_account"] = $paypal_live_account;   
require_once 'inc/config-pp.php';

$total_amount = getCartTotal();

if(isset($_POST['override']) && $_POST['override'])
   {
   $total_amount = $_POST['override'];
   }

   
$curl = curl_init();
$requestParams = array(
    'METHOD' => "SetExpressCheckout",
	'VERSION' => "106.0" ,
	'USER' => $paypal_user,
	'PWD' => $paypal_pwd,
	'SIGNATURE' => $paypal_signature,
	'PAYMENTREQUEST_0_AMT' => number_format($total_amount, 2),
	'PAYMENTREQUEST_0_ITEMAMT' => number_format($total_amount, 2),
	'PAYMENTREQUEST_0_DESC' => 'Payment to '.ucfirst($site),
	'RETURNURL' => $url."/checkout-pp-ok.php" ,
	'CANCELURL' => $url."/checkout-pp-cancel.php" ,
	'PAYMENTREQUEST_0_PAYMENTACTION' => "Sale"
);
$itemNum = 0;
foreach($_SESSION["cart"] as $item) {
	$curFullName = $item["name"];
	if($item["type"] == 1) {
		$dateSplit = explode("-", $item["date"]);
		$curFullName .= " (" . $monthDisplay[$dateSplit[0]] . " " . ltrim($dateSplit[1], '0') . ")";
	}
	else if($item["type"] == 2) {
		switch($item["transfer_type"]) {
			case 1:
				$adateSplit = explode("-", $item["arrival_date"]);
				$ddateSplit = explode("-", $item["departure_date"]);
				$curFullName .= " (" . $monthDisplay[$adateSplit[1]] . " " . ltrim(substr($adateSplit[2],0,2), '0') . " and " . $monthDisplay[$ddateSplit[1]] . " " . ltrim(substr($ddateSplit[2],0,2), '0') . ")";
				break;
			case 2:
				$adateSplit = explode("-", $item["arrival_date"]);
				$curFullName .= " (" . $monthDisplay[$adateSplit[1]] . " " . ltrim(substr($adateSplit[2],0,2), '0') . ")";
				break;
			case 3:
				$ddateSplit = explode("-", $item["departure_date"]);
				$curFullName .= " (" . $monthDisplay[$ddateSplit[1]] . " " . ltrim(substr($ddateSplit[2],0,2), '0') . ")";
				break;
		}
		$curFullName .= " (" . $item["passenger_count"] . "pax)";
	}
	if(isset($_POST['override']) && $_POST['override'])
	   {
	   if($itemNum == 0)
	      $itemprice = $total_amount;
       else		  
	      $itemprice = '0';
	   }
	else   
	   {
	   $itemprice = $item["price"];
	   }
	$detailsArray = array(
		"L_PAYMENTREQUEST_0_NAME$itemNum" => $curFullName,
		"L_PAYMENTREQUEST_0_QTY$itemNum" => $item["quantity"],
		"L_PAYMENTREQUEST_0_AMT$itemNum" => $itemprice
	);
	$requestParams = array_merge($requestParams, $detailsArray);
	$itemNum++;
}

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
	$results[$key] = $val;
}
/*
echo 'SESSION<br>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

echo 'result<br>';
echo '<pre>';
print_r($results);
echo '</pre>';
exit();
*/
/*
SESSION
Array
(
    [cart] => Array
        (
            [1-105-1] => Array
                (
                    [type] => 1
                    [id] => 105
                    [link] => macao-surfing-lessons
                    [name] => Group Surf Lessons
                    [price] => 95
                    [list_price] => 100
                    [quantity] => 2
                    [date] => 08-24-2014
                    [time] => 
                    [hotel] => 36
                )

        )

    [checkout_step] => 3
    [checkout] => Array
        (
            [first_name] => Alex
            [last_name] => K Jay
            [email] => ealexnet@mail.ru
            [phone] => 222-333-4444
            [msg] => 
            [id] => 72
        )

    [checkout_paypal_account] => 
    [checkout_token] => EC%2d6XR093519H923392H
)
result
Array
(
    [TOKEN] => EC%2d97X02348TX968854T
    [TIMESTAMP] => 2014%2d08%2d25T10%3a22%3a31Z
    [CORRELATIONID] => d1c3e4d2c5658
    [ACK] => Success
    [VERSION] => 106%2e0
    [BUILD] => 12513933
)
*/
if($results["ACK"] != "Success") {

$rr = json_encode($results);

	$cart_sql = "update sales_transactions_pre set
	ppresponse = '$rr'
	where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

    $msg = 'There was an error communicating with PayPal';
    if(isset($results["L_SHORTMESSAGE0"]))
	   $msg .= '<br><br>'.urldecode($results["L_SHORTMESSAGE0"]);
    if(isset($results["L_LONGMESSAGE0"]))
	   $msg .= '<br><br>'.urldecode($results["L_LONGMESSAGE0"]);
	
    $_SESSION["checkout"]["ppresponse"]["RESPMSG"] = $msg;
	
	$_SESSION["checkout_error"] = 'paypal';
	header( 'Location: '.$url.'/checkout-error.php' ) ;
	return;
}

$_SESSION["checkout_token"] = urldecode($results["TOKEN"]);
header( 'Location: ' . $paypal_checkout_link . $results["TOKEN"] ) ;
return;

?>