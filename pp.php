<?php 
require_once 'inc/config.php'; 

$sql = "select sales_excursions.st_id, sales_excursions.date, sales_transactions.cust_http 
from sales_excursions left join sales_transactions on 
sales_excursions.st_id = sales_transactions.st_id where sales_excursions.date = NULL OR sales_excursions.date = '0000-00-00'";


/*
$sql = "select sales_excursions.st_id, sales_excursions.date, sales_transactions.cust_http 
from sales_excursions left join sales_transactions on 
sales_excursions.st_id = sales_transactions.st_id where sales_excursions.date <> '0000-00-00'";
*/

$res = mysql_query($sql) or die(mysql_error());
$c = 1;
$cnt = 0;
$cnts = 0;

while($row = MYSQL_FETCH_ARRAY($res))
{
$pieces = explode("<br>", $row['cust_http']);

foreach($pieces as $p)
   {
   if(substr($p,0,16) == 'HTTP_USER_AGENT:')
      {   
      echo $c.' - '.$p.'<br>';
	  $pos = stripos($p, 'Safari');
	  if($pos !== false )
		 $cnts++;
	  else
		 $cnt++;
	  }
   }
$c++;
} 

echo '<br><br>SAFARI: '.$cnts;
echo '<br><br>NO SAFARI: '.$cnt;
?>
