<?
// should be removed
require_once 'inc/config.php'; 

$bus_name = "Caribbean Dream";
$bus_phone = "829-548-2386";
$bus_email = "support@CaribbeanDreamTO.com";
$bus_addr = "Bavaro, Punta Cana";
$bus_lic = "RNC # 130385505";

$transaction_id = $_SESSION['checkout_closed']['id'];
//$transaction_id = '7921';

// get customer details
$sql = "select * from sales_transactions where st_id='$transaction_id'";	
$res = mysql_query($sql);
$row = MYSQL_FETCH_ARRAY($res);

$firstname = $row['cust_first_name'];
$lastname = $row['cust_last_name'];
$email = $row['cust_email'];

// -----------------------------------
//$email = 'kharr212@gmail.com';
// -----------------------------------


/*
$firstname = 'Ken';
$lastname = 'Harrington';
$email = 'ealexnet@yandex.ru';
*/

$id = '7';
// Get email template
$sql = "select * from autoemails where id='$id'";	
$res = mysql_query($sql);
$row = MYSQL_FETCH_ARRAY($res);

if($row['active'])
   {
//echo 'Start sending email to '.$email.'<br>';   
  // Replace variables  

//echo 'SUBJ1: '.$row['subject'].'<br>';   

  $subj = str_replace("%firstname%", $firstname,  $row['subject']);   
   $subj = str_replace("%lastname%", $lastname,  $subj);   

//echo 'SUBJ2: '.$subj.'<br>';   
   
   $text = str_replace("%firstname%", $firstname, $row['text']);   
   $text = str_replace("%lastname%", $lastname, $text);   
   $text = str_replace("%email%", $email, $text);  

// Extract cart template
$arr_email = explode('<!-- CART -->', $text);

// Extract transportation template
$arr_cart = explode('<!-- CART_TRANSPORT -->', $arr_email[1]);


// get cart items
$sql = "select sales_excursions.*, products_v2.p_photo as photo from sales_excursions, products_v2
 where sales_excursions.p_id = products_v2.p_id and sales_excursions.st_id='$transaction_id'";	
$res = mysql_query($sql);
$cart = array();
while($row2 = MYSQL_FETCH_ARRAY($res))
   {
   $cart[] = $row2;
   }

// get cart items
$sql = "select * from sales_airport_pickups where st_id='$transaction_id'";	
$res = mysql_query($sql);
$cart2 = array();
while($row2 = MYSQL_FETCH_ARRAY($res))
   {
   $cart2[] = $row2;
   }


// Populate cart
//------------------------------------------------------------------------
$carttable = '';   
foreach($cart as $c)
{ 
$cartrow = str_replace("%image%", 'http://cdtoen-caribbeandream.netdna-ssl.com/assets/gallery/'.$c['photo'], $arr_cart[0]);      
$cartrow = str_replace("%name%", $c['name'], $cartrow);      
$cartrow = str_replace("%qty%", $c['quantity'], $cartrow);   
// July 24, 2015
$ndate = date("M d, Y", strtotime($c['date']));
   
$cartrow = str_replace("%datetime%", $ndate, $cartrow);      
$cartrow = str_replace("%hotel%", $c['hotel'], $cartrow);      
$carttable .= $cartrow;   
}
$arr_cart[0] = $carttable;


$carttable = '';   
foreach($cart2 as $c)
{ 
$cartrow = str_replace("%hotel%", $c['passenger_hotel'], $arr_cart[1]);      
$cartrow = str_replace("%airport%", strtoupper($c['passenger_airport']), $cartrow);      
$cartrow = str_replace("%qty%", $c['passenger_count'], $cartrow);   

// July 24, 2015
if($c['transfer_type'] <= 2)
{
$ndate = date("M d, Y h:i A", strtotime($c['arrival_date']));
$cartrow = str_replace("%arrival_date%", $ndate, $cartrow);      
}

if($c['transfer_type'] == 1 || $c['transfer_type'] == 3)
{
$ndate = date("M d, Y h:i A", strtotime($c['departure_date']));
$cartrow = str_replace("%departure_date%", $ndate, $cartrow);      
}   

if($c['transfer_type'] == 2)
{
$cartrow = preg_replace("/<!-- DEPARTURE -->(.*?)<!-- DEPARTURE -->/s", "", $cartrow);
}

if($c['transfer_type'] == 3)
{
$cartrow = preg_replace("/<!-- ARRIVAL -->(.*?)<!-- ARRIVAL -->/s", "", $cartrow);
}

$carttable .= $cartrow;   
}
$arr_cart[1] = $carttable;
//------------------------------------------------------------------------

// Put it up
$arr_email[1] = implode('', $arr_cart);   
$text = implode('', $arr_email);   
  
      
$to = $firstname." ".$lastname.' <'.$email.'>';
$from = $bus_name.' <'.$bus_email.'>';
$subject = $subj;

//echo 'SUBJ3: '.$subject.'<br>';   


$headers = 'From: '.$from."\r\n" .
'Reply-To: '.$bus_email."\r\n" .
'X-Mailer: PHP/' . phpversion();


// 'Bcc: kharr212@gmail.com, ealexnet@yandex.ru'."\r\n" .

if($row['text_html'])
   {
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
   }

$rc = mail($to, $subject, $text, $headers);
   }
?>