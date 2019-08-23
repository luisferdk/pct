<a href="/">HOME</a> | 

<?php
$sql = "select * FROM `tour_category`";
$res = mysql_query($sql) or die(mysql_error());
while($row = MYSQL_FETCH_ARRAY($res))
{
  $cat_id = $row['cat_id'];
  $cat_name = $row['cat_name'];
  $cat_url = $row['cat_url'];
  $cat_description = $row['cat_description'];
  $cat_image = $row['cat_image'];
?>
<a href="/excursions.php/<?php echo $cat_url; ?>/"><?php echo $cat_name; ?></a> | 
<?php } ?>
