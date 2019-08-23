<?php
// require "inc/gcal.php";
// require "inc/crm_connector.php";

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

function updateCartCookie() {
	global $cookieLengthInDays;
	
	$expire=time()+60*60*24*$cookieLengthInDays;
	setcookie("cart", json_encode($_SESSION["cart"]), $expire);
}

/* Handle cart change messages */
if(isset($_REQUEST["action"])) {
	
	switch($_REQUEST["action"]) {
	
		// ADD TOUR
		case "addTourToCart" :
			// If we are not actively checking out, reset checkout step
			$_SESSION["checkout_step"] = 1;
	
			$c_id  = "1-" . $_POST["product_id"] . "-1"; // Cart entry id (unique for this particular product/option combination)
			$newItem["type"] = 1; // Used to signify different classes of products. Tours will be "1", but flights and future additions will be different
			$newItem["id"] = intval($_POST["product_id"]); // Id within the type that is the primary index of the table entry describing that item
			$newItem["link"] = $_POST["tour_link"];
			$newItem["name"] = $_POST["product_name"];
			$newItem["sku"] = $_POST["product_sku"];
			$newItem["price"] = floatval($_POST["product_price"]);
			$newItem["list_price"] = floatval($_POST["product_list_price"]);
			$newItem["quantity"] = intval($_POST["product_quantity"]);
			
			$newItem["date"] = $_POST["product_date"];
			if(isset($_POST["product_time"])) {
				$newItem["time"] = $_POST["product_time"];
			}
			else {
				$newItem["time"] = "";
			}
			$newItem["hotel"] = $_POST["product_hotel"];
			
			// Add extra hotel cost
			$h_id = $newItem["hotel"];
			$p_id = $newItem["id"];
			$sql = "SELECT * FROM hotels_products WHERE (h_id = '$h_id' AND p_id = '$p_id')";
			$res = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($res);
			$newItem["price"] += floatval($row["hotel_extra_cost"]);
			$newItem["extra_price"] = floatval($row["hotel_extra_cost"]);
			
			if(isset($_SESSION["cart"][$c_id])) { //Update quantity of existing item
				$_SESSION["cart"][$c_id]["quantity"] += $newItem["quantity"];
			}
			else { // New cart item
				$_SESSION["cart"][$c_id] = $newItem;
			}
				
			updateCartCookie();
			break;
			
		// ADD AIRPORT PICKUP
		case "addPickupToCart":
			// If we are not actively checking out, reset checkout step
			$_SESSION["checkout_step"] = 1;
	
			$c_id = "2-" . $_POST["airport"] . $_POST["hotel"] . "-" . $_POST["transfer"];
			$newItem["type"] = 2; // All airport pickups are type 2
			$newItem["quantity"] = 1;
			$newItem["passenger_count"] = intval($_POST["passenger_count"]);
			$newItem["passenger_hotel"] = $_POST["hotel"];
			$newItem["passenger_airport"] = $_POST["airport"];
			$newItem["transfer_type"] = intval($_POST["transfer"]);
			
			switch($newItem["transfer_type"]) {
				case 1:
					$newItem["transfer_type_str"] = "Round Trip";
					$newItem["name"] = "Round-trip " . strtoupper($_POST["airport"]) . " to " . $_POST["hotel"];
					$newItem["price"] = $newItem["list_price"] = floatval($_POST["roundtrip"]);
										
					$adatecomponents = explode("-", $_POST["adate"]);
					$adateval = $adatecomponents[2] . "-" . $adatecomponents[0] . "-" . $adatecomponents[1];
					$ahourval = intval($_POST["ahour"]) % 12;
					if($_POST["atod"] == "pm") {
						$ahourval += 12;
					}
					$newItem["arrival_date"] = $adateval . " " . $ahourval . ":" . $_POST["amin"]  . ":00";
					$newItem["arrival_airline"] = $_POST["aairline"];
					$newItem["arrival_flight"] = $_POST["aflight"];
					
					$ddatecomponents = explode("-", $_POST["ddate"]);
					$ddateval = $ddatecomponents[2] . "-" . $ddatecomponents[0] . "-" . $ddatecomponents[1];
					$dhourval = intval($_POST["dhour"]) % 12;
					if($_POST["dtod"] == "pm") {
						$dhourval += 12;
					}
					$newItem["departure_date"] = $ddateval . " " . $dhourval . ":" . $_POST["dmin"]  . ":00";
					$newItem["departure_airline"] = $_POST["dairline"];
					$newItem["departure_flight"] = $_POST["dflight"];
					break;
				case 2:
					$newItem["transfer_type_str"] = "Arrival Only"; 
					$newItem["name"] = "Arrival-only " . strtoupper($_POST["airport"]) . " to " . $_POST["hotel"];
					$newItem["price"] = $newItem["list_price"] = floatval($_POST["oneway"]);
					
					$adatecomponents = explode("-", $_POST["adate"]);
					$adateval = $adatecomponents[2] . "-" . $adatecomponents[0] . "-" . $adatecomponents[1];
					$ahourval = intval($_POST["ahour"]) % 12;
					if($_POST["atod"] == "pm") {
						$ahourval += 12;
					}
					$newItem["arrival_date"] = $adateval . " " . $ahourval . ":" . $_POST["amin"]  . ":00";
					$newItem["arrival_airline"] = $_POST["aairline"];
					$newItem["arrival_flight"] = $_POST["aflight"];
					break;
				case 3:
					$newItem["transfer_type_str"] = "Departure Only";
					$newItem["name"] = "Departure-only " . strtoupper($_POST["airport"]) . " from " . $_POST["hotel"];
					$newItem["price"] = $newItem["list_price"] = floatval($_POST["oneway"]);

					$ddatecomponents = explode("-", $_POST["ddate"]);
					$ddateval = $ddatecomponents[2] . "-" . $ddatecomponents[0] . "-" . $ddatecomponents[1];
					$dhourval = intval($_POST["dhour"]) % 12;
					if($_POST["dtod"] == "pm") {
						$dhourval += 12;
					}
					$newItem["departure_date"] = $ddateval . " " . $dhourval . ":" . $_POST["dmin"]  . ":00";
					$newItem["departure_airline"] = $_POST["dairline"];
					$newItem["departure_flight"] = $_POST["dflight"];
					break;
			}
			
			if(isset($_POST["comments"]) && $_POST["comments"] != "") {
				$newItem["comments"] = $_POST["comments"];
			}
			else {
				$newItem["comments"] = "";
			}
			
			$_SESSION["cart"][$c_id] = $newItem;
			updateCartCookie();
			break;
			
		// UPDATE QUANTITY
		case "updateQuantity":
			// If we are not actively checking out, reset checkout step
			$_SESSION["checkout_step"] = 1;
			
			$item_id = $_POST["item_id"];
			$new_quantity = $_POST["item_quantity"];
			if($new_quantity == 0) {
				unset($_SESSION["cart"][$item_id]);
			}
			else {
				$_SESSION["cart"][$item_id]["quantity"] = $new_quantity;
			}
			updateCartCookie();
			break;
/*			
		// GO TO CHECKOUT STEP 2
		case "toStep2":
			// Verify they haven't changed item quantities in another tab
			if($_POST["current_total"] != number_format(getCartTotal(), 2)) {
				$_SESSION["checkout_step"] = 1;
			}
			else {
				$_SESSION["checkout_step"] = 2;
			}
			break;
			
		case "toStep3":
			// Verify they haven't changed item quantities in another tab
			if($_SESSION["checkout_step"] < 2) {
				$_SESSION["checkout_step"] = 1;
				return;
			}
			
			$_SESSION["checkout_first_name"] = $_POST["first_name"];
			$_SESSION["checkout_last_name"] = $_POST["last_name"];
			$_SESSION["checkout_email"] = $_POST["email"];
			$_SESSION["checkout_phone"] = $_POST["phone"];
// ALEX start
			$_SESSION["checkout_msg"] = $_POST["msg"];
// ALEX end
			$_SESSION["checkout_step"] = 3;
			break;
			
		case "toStep4":
		case "submit-order":
			// Verify they haven't changed item quantities in another tab
			if(($_SESSION["checkout_step"] < 3 ) || !isset($_SESSION["checkout_payer_id"]) ) {
				$_SESSION["checkout_step"] = 1;
				return;
			}
			$_SESSION["checkout_step"] = 4;
			
			break;
		
		case "toStep5":
		case "confirmation":
			// Verify they haven't changed item quantities in another tab
			if($_SESSION["checkout_step"] < 4) {
				$_SESSION["checkout_step"] = 1;
				return;
			}
			
			
			
			// First create a transaction
			$cust_first_name = mysql_real_escape_string($_SESSION["checkout_first_name"]);
			$cust_last_name = mysql_real_escape_string($_SESSION["checkout_last_name"]);
			$cust_email = mysql_real_escape_string($_SESSION["checkout_email"]);
			$cust_phone = mysql_real_escape_string($_SESSION["checkout_phone"]);
			$total_cost = getCartTotal();
// ALEX start
			$pp_fname = mysql_real_escape_string($_SESSION["pp_fname"]);
			$pp_lname = mysql_real_escape_string($_SESSION["pp_lname"]);
			$pp_email = mysql_real_escape_string($_SESSION["pp_email"]);
			$pp_country = mysql_real_escape_string($_SESSION["pp_country"]);
			$pp_ship = mysql_real_escape_string($_SESSION["pp_ship"]);
			$st_date = date('Y-m-d H:i:s');
			$st_site = strtolower($_SERVER['HTTP_HOST']);
			$st_msg = mysql_real_escape_string($_SESSION["checkout_msg"]);
			
			$cart_sql = "INSERT INTO sales_transactions (cust_first_name, cust_last_name, cust_email, cust_phone, total_cost,
			pp_fname, pp_lname, pp_email, pp_country, pp_ship, st_date, st_site, st_msg) " .
			"VALUES ('$cust_first_name', '$cust_last_name', '$cust_email', '$cust_phone', $total_cost,
			'$pp_fname', '$pp_lname', '$pp_email', '$pp_country', '$pp_ship', '$st_date', '$st_site','$st_msg')";			
// ALEX end
		
			$cart_res = mysql_query($cart_sql) or die(mysql_error());
			$transaction_id = mysql_insert_id();
			
			// Add user to the CRM if needed
			connectToCRMDB();
			
			$crm_dup_sql = "select * from crm_contacts where email = '$cust_email' and firstname='$cust_first_name' and lastname='$cust_last_name' and deleted <> 1";
			$crm_dup_res = mysql_query($crm_dup_sql) or die(mysql_error());
			$datetime = date('Y-m-d H:i:s');
			
			if(mysql_num_rows($crm_dup_res) == 0) {
				$crm_sql = "insert into crm_contacts 
					(cdate,
					firstname,
					lastname,
					title,
					company,
					phone,
					email,
					website,
					source,
					tags,
					address,
					city,
					state,
					zip,
					country,
					phones,
					emails
					)
					values
					('$datetime',
					'$cust_first_name',
					'$cust_last_name',
					'',
					'',
					'$cust_phone',
					'$cust_email',
					'',
					'Webform',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'')";
				
				$crm_res = mysql_query($crm_sql) or die(mysql_error());
				$crm_cust_id = mysql_insert_id();
				
			}
			else {
				$row = MYSQL_FETCH_ARRAY($crm_dup_res);
				$crm_cust_id = $row["id"];
			}
			
			connectToSiteDB();
		
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
	
						$cart_sql = "INSERT INTO sales_excursions (st_id, p_id, date, time, hotel, price, quantity, name) " .
						"VALUES ($transaction_id, $p_id, STR_TO_DATE('$date', '%m-%d-%Y'), '$time', '$hotel', $price, $quantity, '$name')";
						$cart_res = mysql_query($cart_sql) or die(mysql_error());
						
						// Put on GCal
						$cal_title = $name;
						$cal_desc = "$cust_first_name $cust_last_name - $quantity people | Hotel Pickup - $hotel";
						$cal_date = rearrangeDateForCal($date);
						switch($time) {
							case "morning":
								$cal_start = "08:00";
								$cal_end = "12:00";
								break;
								
							case "afternoon":
								$cal_start = "13:00";
								$cal_end = "17:00";
								break;
								
							default:
							case "": // all-day
								$cal_start = "08:00";
								$cal_end = "18:00";
								break;
						}
						
						postGCalEvent($cal_date, $cal_start, $cal_end, $cal_title, $cal_desc);
						
						// Put on CRM
						
						connectToCRMDB();
			
						// Mark new tours with green
						$crm_sql = "UPDATE crm_contacts " .
							"SET action_needed = 1 " .
							"WHERE id = $crm_cust_id";
						$crm_res = mysql_query($crm_sql) or die(mysql_error());
						
						$crm_sql = "insert into crm_tours(cdate, contactid, tour, price, people, tdate, hotel, deleted) " .
							"VALUES ('$datetime', $crm_cust_id, '$name', '$price', '$quantity', STR_TO_DATE('$date', '%m-%d-%Y'), '$hotel', 0)";						
						$crm_res = mysql_query($crm_sql) or die(mysql_error());

						connectToSiteDB();
						
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
								
								$cart_sql = "INSERT INTO sales_airport_pickups (st_id, passenger_hotel, passenger_airport, passenger_count, price, transfer_type, arrival_date, arrival_airline, arrival_flight, departure_date, departure_airline, departure_flight, comments) " .
								"VALUES ($transaction_id, '$passenger_hotel', '$passenger_airport', $passenger_count, $price, $transfer_type, '$arrival_date', '$arrival_airline', '$arrival_flight', '$departure_date', '$departure_airline', '$departure_flight', '$comments')";
								$cart_res = mysql_query($cart_sql) or die(mysql_error());
								
								// Put on GCal
								
								// Arrival
								$cal_title = "Transportation";
								$cal_desc = "$cust_first_name $cust_last_name - $passenger_count people | " .
												"$passenger_airport to $passenger_hotel | " .
												"$arrival_airline flight #$arrival_flight ($arrival_time)";
								$cal_date = $asplit[0];
								$cal_start = "08:00";
								$cal_end = "18:00";

								postGCalEvent($cal_date, $cal_start, $cal_end, $cal_title, $cal_desc);
								
								// Departure
								$cal_title = "Transportation";
								$cal_desc = "$cust_first_name $cust_last_name - $passenger_count people | " .
												"$passenger_hotel to $passenger_airport | " .
												"$departure_airline flight #$departure_flight ($departure_time)";
								$cal_date = $dsplit[0];
								$cal_start = "08:00";
								$cal_end = "18:00";

								postGCalEvent($cal_date, $cal_start, $cal_end, $cal_title, $cal_desc);
								
								// Put on CRM
						
								connectToCRMDB();
					
								$crm_sql = "insert into crm_transportation(cdate, airport, hotel, pax, price, aairline, aflight, adate, dairline, dflight, ddate, deleted, firstname, lastname, email, type, contactid) ". 
									"VALUES('$datetime', '$crm_airport', '$passenger_hotel', '$passenger_count', '$price', '$arrival_airline', '$arrival_flight', '$arrival_date', '$departure_airline', '$departure_flight', '$departure_date', '0', '$cust_first_name', '$cust_last_name', '$cust_email', '$transfer_type', $crm_cust_id)";
								$crm_res = mysql_query($crm_sql) or die(mysql_error());

								connectToSiteDB();

								
								break;
								
							// Arrival Only
							case 2:
								$arrival_date = mysql_real_escape_string($item["arrival_date"]);
								$asplit = explode(" ", $arrival_date);
								$arrival_time = substr($asplit[1], 0, -3);
								$arrival_airline = mysql_real_escape_string($item["arrival_airline"]);
								$arrival_flight = mysql_real_escape_string($item["arrival_flight"]);
								
								$cart_sql = "INSERT INTO sales_airport_pickups (st_id, passenger_hotel, passenger_airport, passenger_count, price, transfer_type, arrival_date, arrival_airline, arrival_flight, comments) " .
								"VALUES ($transaction_id, '$passenger_hotel', '$passenger_airport', $passenger_count, $price, $transfer_type, '$arrival_date', '$arrival_airline', '$arrival_flight', '$comments')";
								$cart_res = mysql_query($cart_sql) or die(mysql_error());
								
								// Put on GCal
								$cal_title = "Transportation";
								$cal_desc = "$cust_first_name $cust_last_name - $passenger_count people | " .
												"$passenger_airport to $passenger_hotel | " .
												"$arrival_airline flight #$arrival_flight ($arrival_time)";
								$cal_date = $asplit[0];
								$cal_start = "08:00";
								$cal_end = "18:00";

								postGCalEvent($cal_date, $cal_start, $cal_end, $cal_title, $cal_desc);
								
								
								// Put on CRM
						
								connectToCRMDB();
					
								$crm_sql = "insert into crm_transportation(cdate, airport, hotel, pax, price, aairline, aflight, adate, deleted, firstname, lastname, email, type, contactid) ". 
									"VALUES('$datetime', '$crm_airport', '$passenger_hotel', '$passenger_count', '$price', '$arrival_airline', '$arrival_flight', '$arrival_date', '0', '$cust_first_name', '$cust_last_name', '$cust_email', '$transfer_type', $crm_cust_id)";
								$crm_res = mysql_query($crm_sql) or die(mysql_error());

								connectToSiteDB();

								break;
							
							// Departure Only
							case 3:
								$departure_date = mysql_real_escape_string($item["departure_date"]);
								$dsplit = explode(" ", $departure_date);
								$departure_time = substr($dsplit[1], 0, -3);
								$departure_airline = mysql_real_escape_string($item["departure_airline"]);
								$departure_flight = mysql_real_escape_string($item["departure_flight"]);
								
								$cart_sql = "INSERT INTO sales_airport_pickups (st_id, passenger_hotel, passenger_airport, passenger_count, price, transfer_type, departure_date, departure_airline, departure_flight, comments) " .
								"VALUES ($transaction_id, '$passenger_hotel', '$passenger_airport', $passenger_count, $price, $transfer_type,  '$departure_date', '$departure_airline', '$departure_flight', '$comments')";
								$cart_res = mysql_query($cart_sql) or die(mysql_error());
								
								// Put on GCal
								$cal_title = "Transportation";
								$cal_desc = "$cust_first_name $cust_last_name - $passenger_count people | " .
												"$passenger_hotel to $passenger_airport | " .
												"$departure_airline flight #$departure_flight ($departure_time)";
								$cal_date = $dsplit[0];
								$cal_start = "08:00";
								$cal_end = "18:00";

								postGCalEvent($cal_date, $cal_start, $cal_end, $cal_title, $cal_desc);
								
								// Put on CRM
						
								connectToCRMDB();
					
								
								$crm_sql = "insert into crm_transportation(cdate, airport, hotel, pax, price, dairline, dflight, ddate, deleted, firstname, lastname, email, type, contactid) ". 
									"VALUES('$datetime', '$crm_airport', '$passenger_hotel', '$passenger_count', '$price', '$departure_airline', '$departure_flight', '$departure_date', '0', '$cust_first_name', '$cust_last_name', '$cust_email', '$transfer_type', $crm_cust_id)";
								$crm_res = mysql_query($crm_sql) or die(mysql_error());

								connectToSiteDB();
								
								break;
						}
						break;
					
					// Add new product types here in the future
				}
			}
			
			// Clear cart data
			unset($_SESSION["checkout_first_name"]);
			unset($_SESSION["checkout_last_name"]);
			unset($_SESSION["checkout_email"]);
			unset($_SESSION["checkout_token"]);
			unset($_SESSION["checkout_payer_id"]);
// ALEX start
			unset($_SESSION["pp_fname"]);
			unset($_SESSION["pp_lname"]);
			unset($_SESSION["pp_email"]);
			unset($_SESSION["pp_country"]);
			unset($_SESSION["pp_ship"]);
            unset($_SESSION["checkout_msg"]);			
// ALEX end
			
			$_SESSION["cart"] = array();
			setcookie("cart", "", time()-3600);
			
			// Navigate
			$_SESSION["checkout_step"] = 5;
			break;
*/
			
		default:
		
			// If we are not actively checking out, reset checkout step
			$_SESSION["checkout_step"] = 1;
			break;
	}
}
else {
	// If we are not actively checking out, reset checkout step
	$_SESSION["checkout_step"] = 1;
}

?>