<?php
//require "inc/gcal.php";
//require "inc/crm_connector.php";

/* Cart control logic */
$cookieLengthInDays = 30;

/* Array of cart items stored in session. Perhaps move this to cookie eventually */
if(!isset($_SESSION["cart"])) {
	if(isset($_COOKIE["cart"])) {
		$_SESSION["cart"] = json_decode(stripcslashes($_COOKIE["cart"]), true);
	}
	else {
		$_SESSION["cart"] = array();
	}
}

if(!isset($_SESSION["checkout"])) {
	if(isset($_COOKIE["checkout"])) {
		$_SESSION["checkout"] = json_decode(stripcslashes($_COOKIE["checkout"]), true);
	}
	else {
		$_SESSION["checkout"] = array();
	}
}

function updateCartCookie() {
	global $cookieLengthInDays;
	
	$expire=time()+60*60*24*$cookieLengthInDays;
	setcookie("cart", json_encode($_SESSION["cart"]), $expire);
}

function updateCheckoutCookie() {
	global $cookieLengthInDays;
	
	$expire=time()+60*60*24*$cookieLengthInDays;
	setcookie("checkout", json_encode($_SESSION["checkout"]), $expire);
}

function checkout3() {
	if(!isset($_SESSION["checkout_step"]) || $_SESSION["checkout_step"] < 2) 
		{
		$_SESSION["checkout_step"] = 1;
		header( 'Location: checkout.php' ) ;
		exit;
		}
		
// if we came from checkout2.php, we have only name,
// if we came back from checkout4.php we have all fields

if(isset($_SESSION["form_post_data"]))
   {
   $_POST = $_SESSION["form_post_data"];
   $_POST['fullname'] = $_POST['ccname'];
   unset($_SESSION["form_post_data"]);
   return;
   }

	if(isset($_POST["fullname"]))
        {	
        $nname_arr = explode(' ', trim($_POST["fullname"]));
	    $_SESSION["checkout"]["first_name"] = $nname_arr[0];
	    array_shift($nname_arr);
	    $_SESSION["checkout"]["last_name"] = implode(' ', $nname_arr);
	    $_SESSION["checkout"]["email"] = $_POST["email"];
	    $_SESSION["checkout"]["phone"] = $_POST["phone"];
	    $_SESSION["checkout"]["msg"] = $_POST["msg"];
	    $_SESSION["checkout"]["salesrep"] = $_POST["salesrep"];
		}
		
	if(!$_POST["fullname"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 1;
		header( 'Location: checkout2.php' ) ;
		exit;
		}
	if(!$_POST["email"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 2;
		header( 'Location: checkout2.php' ) ;
		exit;
		}
	if (!eregi("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6}$",$_POST["email"]))
	   {
	    $_SESSION["checkout_error"] = 3;
		header( 'Location: checkout2.php' ) ;
		exit;
       }	
	$total_cost = getCartTotal();
	if($total_cost <= 0)
		{
	//	$_SESSION["checkout_step"] = 1;
		$_SESSION["checkout_step"] = 1;
		header( 'Location: checkout.php' ) ;
		exit;
		}

	
	   
		/*
    $nname_arr = explode(' ', $_POST["fullname"]);
	$_SESSION["checkout"]["first_name"] = $nname_arr[0];
	array_shift($nname_arr);
	$_SESSION["checkout"]["last_name"] = implode(' ', $nname_arr);
	$_SESSION["checkout"]["email"] = $_POST["email"];
	$_SESSION["checkout"]["phone"] = $_POST["phone"];
	$_SESSION["checkout"]["msg"] = $_POST["msg"];
	*/
	
	$st_site = strtolower($_SERVER['HTTP_HOST']);
	
	/* ADD INFO TO DATABASE */
	// Check if this transaction exists
	if(isset($_SESSION["checkout"]["id"]))
	    {
		$checkout_id = $_SESSION["checkout"]["id"];
		// delete old transaction and add new one
		$sql = "delete from sales_transactions_pre where st_id='$checkout_id'";			
	    mysql_query($sql);
		$sql = "delete from sales_excursions_pre where st_id='$checkout_id'";			
	    mysql_query($sql);
		$sql = "delete from sales_airport_pickups_pre where st_id='$checkout_id'";			
	    mysql_query($sql);
		}
	
	// First create a transaction
	$cust_first_name = mysql_real_escape_string($_SESSION["checkout"]["first_name"]);
	$cust_last_name = mysql_real_escape_string($_SESSION["checkout"]["last_name"]);
	$cust_email = mysql_real_escape_string($_SESSION["checkout"]["email"]);
	$cust_phone = mysql_real_escape_string($_SESSION["checkout"]["phone"]);
	$total_cost = getCartTotal();
	$st_date = date('Y-m-d H:i:s');
	$st_site = strtolower($_SERVER['HTTP_HOST']);
	$st_msg = mysql_real_escape_string($_SESSION["checkout"]["msg"]);
	$st_salesrep = mysql_real_escape_string($_SESSION["checkout"]["salesrep"]);
/*
	$pp_fname = mysql_real_escape_string($_SESSION["pp_fname"]);
	$pp_lname = mysql_real_escape_string($_SESSION["pp_lname"]);
	$pp_email = mysql_real_escape_string($_SESSION["pp_email"]);
	$pp_country = mysql_real_escape_string($_SESSION["pp_country"]);
	$pp_ship = mysql_real_escape_string($_SESSION["pp_ship"]);
*/
	
	$cust_ip = $_SERVER['REMOTE_ADDR'];
	$cust_http = mysql_real_escape_string(get_all_http());
	
	$cart_sql = "INSERT INTO sales_transactions_pre (cust_first_name, cust_last_name, cust_email, cust_phone, total_cost,
	st_date, st_site, st_msg, step, cust_ip, cust_http, salesrep) " .
	"VALUES ('$cust_first_name', '$cust_last_name', '$cust_email', '$cust_phone', $total_cost,
	'$st_date', '$st_site','$st_msg', '2', '$cust_ip', '$cust_http', '$st_salesrep')";			

	$cart_res = mysql_query($cart_sql) or die(mysql_error());
	$transaction_id = mysql_insert_id();
	$_SESSION["checkout"]["id"] = $transaction_id;
	
updateCheckoutCookie();

			// Now add each purchased item
			foreach($_SESSION["cart"] as $item) {
				switch($item["type"]) {
					// Adding an excursion
					case 1:
						$p_id = $item["id"];
						$price = $item["price"];
						$date = mysql_real_escape_string($item["date"]);
						$time = mysql_real_escape_string($item["time"]);
						$h_id = mysql_real_escape_string($item["hotel"]);
						$quantity = mysql_real_escape_string($item["quantity"]);
						$name = mysql_real_escape_string($item["name"]);
						
						$cart_sql = "SELECT hotels.hotel_name FROM hotels WHERE hotels.hotel_id = $h_id";
						$cart_res = mysql_query($cart_sql) or die(mysql_error());
						while($row = MYSQL_FETCH_ARRAY($cart_res))
						{
							$hotel=$row['hotel_name'];
						}
	
						$cart_sql = "INSERT INTO sales_excursions_pre (st_id, p_id, date, rawdate, time, hotel, price, quantity, name) " .
						"VALUES ($transaction_id, $p_id, STR_TO_DATE('$date', '%m-%d-%Y'), '$date', '$time', '$hotel', $price, $quantity, '$name')";
						$cart_res = mysql_query($cart_sql) or die(mysql_error());
						
						break;
					
					// Adding airport pickup
					case 2:
						$passenger_count = $item["passenger_count"];
						$passenger_hotel = mysql_real_escape_string($item["passenger_hotel"]);
						$passenger_airport = mysql_real_escape_string($item["passenger_airport"]);
						$price = mysql_real_escape_string($item["price"]);
						$transfer_type = mysql_real_escape_string($item["transfer_type"]);
						$comments = mysql_real_escape_string($item["comments"]);
						
						$crm_airport = strtoupper($passenger_airport);
						switch($transfer_type) {
							// Round Trip
							case 1:
								$arrival_date = mysql_real_escape_string($item["arrival_date"]);
								$asplit = explode(" ", $arrival_date);
								$arrival_time = substr($asplit[1], 0, -3);
								$arrival_airline = mysql_real_escape_string($item["arrival_airline"]);
								$arrival_flight = mysql_real_escape_string($item["arrival_flight"]);
								
								$departure_date = mysql_real_escape_string($item["departure_date"]);
								$dsplit = explode(" ", $departure_date);
								$departure_time = substr($dsplit[1], 0, -3);
								$departure_airline = mysql_real_escape_string($item["departure_airline"]);
								$departure_flight = mysql_real_escape_string($item["departure_flight"]);
								
								$cart_sql = "INSERT INTO sales_airport_pickups_pre (st_id, passenger_hotel, passenger_airport, passenger_count, price, transfer_type, arrival_date, arrival_airline, arrival_flight, departure_date, departure_airline, departure_flight, comments) " .
								"VALUES ($transaction_id, '$passenger_hotel', '$passenger_airport', $passenger_count, $price, $transfer_type, '$arrival_date', '$arrival_airline', '$arrival_flight', '$departure_date', '$departure_airline', '$departure_flight', '$comments')";
								$cart_res = mysql_query($cart_sql) or die(mysql_error());
								
								break;
								
							// Arrival Only
							case 2:
								$arrival_date = mysql_real_escape_string($item["arrival_date"]);
								$asplit = explode(" ", $arrival_date);
								$arrival_time = substr($asplit[1], 0, -3);
								$arrival_airline = mysql_real_escape_string($item["arrival_airline"]);
								$arrival_flight = mysql_real_escape_string($item["arrival_flight"]);
								
								$cart_sql = "INSERT INTO sales_airport_pickups_pre (st_id, passenger_hotel, passenger_airport, passenger_count, price, transfer_type, arrival_date, arrival_airline, arrival_flight, comments) " .
								"VALUES ($transaction_id, '$passenger_hotel', '$passenger_airport', $passenger_count, $price, $transfer_type, '$arrival_date', '$arrival_airline', '$arrival_flight', '$comments')";
								$cart_res = mysql_query($cart_sql) or die(mysql_error());

								break;
							
							// Departure Only
							case 3:
								$departure_date = mysql_real_escape_string($item["departure_date"]);
								$dsplit = explode(" ", $departure_date);
								$departure_time = substr($dsplit[1], 0, -3);
								$departure_airline = mysql_real_escape_string($item["departure_airline"]);
								$departure_flight = mysql_real_escape_string($item["departure_flight"]);
								
								$cart_sql = "INSERT INTO sales_airport_pickups_pre (st_id, passenger_hotel, passenger_airport, passenger_count, price, transfer_type, departure_date, departure_airline, departure_flight, comments) " .
								"VALUES ($transaction_id, '$passenger_hotel', '$passenger_airport', $passenger_count, $price, $transfer_type,  '$departure_date', '$departure_airline', '$departure_flight', '$comments')";
								$cart_res = mysql_query($cart_sql) or die(mysql_error());
								
								break;
						}
						break;
					
					// Add new product types here in the future
				}
			}
	
}

function get_all_http() {
//  $ip_pattern="#(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)#";
  $ret="";
  foreach ($_SERVER as $k => $v) {
    if (substr($k,0,5)=="HTTP_") 
	   $ret.=$k.": ".$v."<br>";
  }
  return $ret;
}

function checkout4() {
	if(!isset($_SESSION["checkout_step"]) || $_SESSION["checkout_step"] < 3) 
		{
		$_SESSION["checkout_step"] = 1;
		header( 'Location: checkout.php' ) ;
		exit;
		}
	if(!isset($_SESSION["checkout"]["id"]))
		{
		$_SESSION["checkout_step"] = 1;
		header( 'Location: checkout.php' ) ;
		exit;
		}
/*		
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
*/

$_SESSION["form_post_data"] = $_POST;
	
	if(!$_POST["transtype"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 1;
		header( 'Location: checkout3.php' ) ;
		exit;
		}
	if(!$_POST["ccname"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 2;
		header( 'Location: checkout3.php' ) ;
		exit;
		}
	if(!$_POST["ccnumber"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 3;
		header( 'Location: checkout3.php' ) ;
		exit;
		}
	if(!$_POST["expiry_month"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 4;
		header( 'Location: checkout3.php' ) ;
		exit;
		}
	if(!$_POST["expiry_year"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 5;
		header( 'Location: checkout3.php' ) ;
		exit;
		}
	if(!$_POST["cvv"])
		{
	//	$_SESSION["checkout_step"] = 1;
	    $_SESSION["checkout_error"] = 6;
		header( 'Location: checkout3.php' ) ;
		exit;
		}
    $checkout_id = $_SESSION["checkout"]["id"];
	$cart_sql = "update sales_transactions_pre set step = '3' where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

}

function checkout4pp() {
	if(!isset($_SESSION["checkout_step"]) || $_SESSION["checkout_step"] < 3) 
		{
		$_SESSION["checkout_step"] = 1;
		header( 'Location: checkout.php' ) ;
		exit;
		}
	if(!isset($_SESSION["checkout"]["id"]))
		{
		$_SESSION["checkout_step"] = 1;
		header( 'Location: checkout.php' ) ;
		exit;
		}
/*		
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
*/
    $checkout_id = $_SESSION["checkout"]["id"];
	$cart_sql = "update sales_transactions_pre set step = '3' where st_id='$checkout_id'";			
	$cart_res = mysql_query($cart_sql) or die(mysql_error());

}

function checkout_ok() {
if(!isset($_SESSION["checkout_closed"]))
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }
}
function checkout_error() {
if(!isset($_SESSION["checkout"]["ppresponse"]))
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }
}

function checkout_pp_ok() {
/*
echo 'SESSION<br>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

echo 'GET<br>';
echo '<pre>';
print_r($_GET);
echo '</pre>';
exit();
*/
if(!isset($_GET["PayerID"]))
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }
if(!isset($_GET["token"]))
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }
if(!isset($_SESSION["checkout_token"]))
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }
if($_GET["token"] != $_SESSION["checkout_token"])
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }
if(!isset($_SESSION["checkout_paypal_account"]))
   {
   $_SESSION["checkout_step"] = 1;
   header( 'Location: checkout.php' ) ;
   exit;
   }

}

function google_ecommerce_data()
{
$html = "
ga('ecommerce:addTransaction', {
  'id': '".$_SESSION['checkout_closed']['id']."',
  'affiliation': '".strtolower($_SERVER['HTTP_HOST'])."',
  'revenue': '".number_format(getCartTotal("cart_closed"), 2)."'
});
";

foreach($_SESSION["cart_closed"] as $item_id => $item) 
   { 
   $html .= "
ga('ecommerce:addItem', {
  'id': '".$_SESSION['checkout_closed']['id']."',
  'name': '".$item["name"]."',
  'sku': '".$item["sku"]."',
  'price': '".number_format($item["price"], 2)."',
  'quantity': '".$item["quantity"]."'
});   
   ";
   }
return $html;
}

?>