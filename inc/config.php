<?php
session_start();

// set timezone
date_default_timezone_set('America/Santo_Domingo');

// database connection config
$dev_test = false; // Turn false for live site
if($dev_test) {
	$dbHost = 'localhost';
	$dbUser = 'root';
	$dbPass = 'malibu';
	$dbName = 'pctours_web';
}
else {
	$dbHost = 'localhost';
	$dbUser = 'pctours_web';
	$dbPass = 'DokTUocQWeAJ';
	$dbName = 'pctours_web';
}

// Database table name config: Simplifies changing the new organization's table names from their temporary ones
$toursTable = 'tours_v2';
$productsTable = 'products_v2';
$productsToursTable = 'products_tours';
$show_products_new = 0;
if(isset($_GET["prodnew"]))
   $show_products_new = $_GET["prodnew"];

$dbConn = mysql_connect ($dbHost, $dbUser, $dbPass) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db($dbName) or die('Cannot select database. ' . mysql_error());

// setting up the web root and server root for
// this shopping cart application
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);

// these are the directories where we will store all
// category and product images
//define('CATEGORY_IMAGE_DIR', '//caribbeandreamto.com/assets/');
////define('PRODUCT_IMAGE_DIR',  '//caribbeandreamto.com/assets/gallery/');
//define('PRODUCT_IMAGE_DIR',  '//cdtoen-caribbeandream.netdna-ssl.com/assets/gallery/'); //for MaxCDN

define('CATEGORY_IMAGE_DIR', '//cdto.net/assets/');
define('PRODUCT_IMAGE_DIR',  '//cdto.net/assets/gallery/'); //for MaxCDN

// Phone Numbers
define('phone_tollfree_alpha', '844-DR-TOURS');
define('phone_tollfree_numberic', '844-378-6877');
define('phone_office', '809-552-6862');


// functions

// Populate Drop Down List

function createDropdown($arr) 
{
  foreach ($arr as $key => $value) 
  {
    echo '<option value="'.$value.'">'.$value.'</option>';
  }
}

function embedProducts($t_id, $link_url)
{
	global $productsTable;
	global $productsToursTable;
	
	$eProducts = array();
	
	$epsql = "SELECT * FROM $productsToursTable JOIN $productsTable ON $productsToursTable.p_id = $productsTable.p_id WHERE $productsToursTable.t_id = $t_id";
	$epres = mysql_query($epsql) or die(mysql_error());
	while($eprow = MYSQL_FETCH_ARRAY($epres))
	{
		$curProduct = array();
		$curProduct["product_id"] = $eprow['p_id'];
		$curProduct["product_name"] = $eprow['p_name'];
		$product_photo = $eprow['p_photo'];
		$curProduct["product_photo"] = $product_photo;
		$curProduct["product_desc"] = $eprow['p_desc'];
		$curProduct["product_list_price"] = $eprow['p_list_price'];
		$curProduct["product_wholesale_price"] = $eprow['p_wholesale_price'];
		$curProduct["product_retail_price"] = $eprow['p_retail_price'];
		$curProduct["product_affiliate_price"] = $eprow['p_affiliate_price'];
		$curProduct["product_multiple_times"] = $eprow['p_multiple_times'];
		$curProduct["product_sku"] = $eprow['p_sku'];
		$curProduct["product_defq"] = $eprow['p_defq'];
	
		$product_image_tag = "";
		if( isset($product_photo) && $product_photo != "" ) {
			$product_image_tag = "<img src=\"" . constant("PRODUCT_IMAGE_DIR") . $product_photo . "\" ></img>";
		}
		$curProduct["product_image_tag"] = $product_image_tag;
		
		$eProducts[] = $curProduct;
	}
	
	foreach($eProducts as $p) {
		echo "<p>$" . $p["product_list_price"] . " " . $p["product_name"] . "</p>";
	}
	
	echo <<< EOT
	<div class="accordion" id="accordionProducts">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle btn btn-success btn-block" data-toggle="collapse"  data-parent="#accordionProducts" href="#collapseProducts">
				<i class="icon-plus-sign icon-white"></i>
				View Online Pricing
				</a>
			</div>
			<div id="collapseProducts" class="accordion-body collapse">
				<div class="accordion-inner">
				<div style="text-align:center">
				<script type="text/javascript" data-pp-pubid="f0306fc16f" data-pp-placementtype="468x60"> (function (d, t) {
				"use strict";
				var s = d.getElementsByTagName(t)[0], n = d.createElement(t);
				n.src = "//paypal.adtag.where.com/merchant.js";
				s.parentNode.insertBefore(n, s);
				}(document, "script"));
				</script></div>
EOT;

	foreach($eProducts as $p) {
		$p_id = $p["product_id"];
		$product_name = $p["product_name"];
		$product_retail_price = $p["product_retail_price"];
		$product_multiple_times = $p["product_multiple_times"];
		$product_desc = $p["product_desc"];
		$product_image_tag = $p["product_image_tag"];
$product_list_price = $p["product_list_price"];
$product_sku = $p["product_sku"];
$product_defq = $p["product_defq"];

		echo <<< EOT
				<div class="container-fluid" style="margin: 10px 6px 20px; border: 1px solid #ccc;">
					<div class="row-fluid">
						<h4 class="span8">$product_name</h4>
						<h5 class="span4 pull-right">Online Price <span class="text-error">$$product_retail_price</span></h5>
					</div>
					
					<hr style="margin: 0 0 5px;"/>
					
					<form action="/checkout.php" method="POST" class="container-fluid">	
						<fieldset class="row-fluid">
							<div class="span8">
								<label>Hotel Pickup</label>
EOT;
								showHotelPicker("product_hotel", $p_id);
		echo <<< EOT
								<label>Date</label>
								<input type="text" readonly name="product_date" id="product_date" class="hasDatepicker datepicker" style="cursor:default;" required title="Please click here to select the date" rel=tooltip></input>
EOT;
								if($product_multiple_times ) {
									echo "<label>Preferred Time</label>";
									echo "<label class=\"radio inline\">";
										echo"<input type=\"radio\" name=\"product_time\" value=\"morning\" checked> Morning";
									echo "</label>";
									echo "<label class=\"radio inline\">";
										echo"<input type=\"radio\" name=\"product_time\" value=\"afternoon\"> Afternoon";
									echo "</label>";
									echo "<br/><br/>";
								}

	echo <<< EOT
								<label>Quantity</label>
								<select name="product_quantity" id="product_quantity" class="input-min" required>
EOT;
								for($i = 1; $i <= 20; $i++) {
									if($i == $product_defq) {
										echo "<option value=\"$i\" selected>$i</option>";
									}
									else {
										echo "<option value=\"$i\">$i</option>";
									}
								}
	echo <<< EOT
								</select>
							</div>
							<div class="span4">
								$product_image_tag
							</div>
						</fieldset>
						
						<input type="hidden" name="product_price" value="$product_retail_price">
<input type="hidden" name="product_list_price" value="$product_list_price">
<input type="hidden" name="product_sku" value="$product_sku">
						<input type="hidden" name="product_name" value="$product_name">
						<input type="hidden" name="product_id" value="$p_id">
						<input type="hidden" name="tour_link" value="$link_url">
						
						<input type="hidden" name="action" value="addTourToCart">
						<input type="submit" class="btn btn-success" value="Add to Cart" />
					</form>
					
					<div class="row-fluid">
						<p class="span12 text-error text-center pagination-centered">
EOT;
						echo str_replace("\n", "<br/>", $product_desc);
	echo <<< EOT
						</p>
					</div>
				</div>
EOT;
	}			
				
	echo <<< EOT
				</div>
				<p style="text-align:center;margin:10px 0 50px 0">For groups of 10 or more, please <a href="/contact/">contact us directly</a></p>
			</div>
		</div>
	</div>
EOT;
}

function embedProductsNew($t_id, $link_url)
{
	global $productsTable;
	global $productsToursTable;
	
	$eProducts = array();
	
	$epsql = "SELECT * FROM $productsToursTable JOIN $productsTable ON $productsToursTable.p_id = $productsTable.p_id WHERE $productsToursTable.t_id = $t_id";
	$epres = mysql_query($epsql) or die(mysql_error());
	$cdashed = array("#000099", "#000099");
	$icdeshed = 0;

	while($eprow = MYSQL_FETCH_ARRAY($epres))
	{
		$curProduct = array();
		$curProduct["product_id"] = $eprow['p_id'];
		$curProduct["product_name"] = $eprow['p_name'];
		$product_photo = $eprow['p_photo'];
		$curProduct["product_photo"] = $product_photo;
		$curProduct["product_desc"] = $eprow['p_desc'];
		$curProduct["product_list_price"] = $eprow['p_list_price'];
		$curProduct["product_wholesale_price"] = $eprow['p_wholesale_price'];
		$curProduct["product_retail_price"] = $eprow['p_retail_price'];
		$curProduct["product_affiliate_price"] = $eprow['p_affiliate_price'];
		$curProduct["product_multiple_times"] = $eprow['p_multiple_times'];
		$curProduct["product_sku"] = $eprow['p_sku'];
		$curProduct["product_defq"] = $eprow['p_defq'];
	
		$product_image_tag = "";
		if( isset($product_photo) && $product_photo != "" ) {
			$product_image_tag = "<img width='300' height='300' style='border-radius: 10px; overflow: hidden; background:white;' 
			src=\"" . constant("PRODUCT_IMAGE_DIR") . $product_photo . "\" class=\"thumbnail text-center\" 
			alt=\"$p[product_name]\" title=\"$p[product_name]\" /></img>";
			
//			<img src=\"" . constant("PRODUCT_IMAGE_DIR") . $product_photo . "\" ></img>";
		}
		$curProduct["product_image_tag"] = $product_image_tag;
		$curProduct["cdashed"] = $cdashed[$icdeshed];
		$icdeshed++; if($icdeshed > 1) $icdeshed = 0;
		$eProducts[] = $curProduct;
	}
	
$prod_cnt = 1;	
	foreach($eProducts as $p) {
		$p_id = $p["product_id"];
		$product_name = $p["product_name"];
		$product_retail_price = $p["product_retail_price"];
		$product_multiple_times = $p["product_multiple_times"];
		$product_desc = $p["product_desc"];
		$product_image_tag = $p["product_image_tag"];
$product_list_price = $p["product_list_price"];
$product_sku = $p["product_sku"];
$product_defq = $p["product_defq"];
	
//		echo "<p>$" . $p["product_list_price"] . " " . $p["product_name"] . "</p>";

//  onSubmit="return myValidateForm$prod_cnt()"
	
	echo <<< EOT
<!-- BEGIN PRODUCT -->
<div class="well" style="background: rgba(217, 237, 247, 0.9); border-radius: 10px; overflow: hidden; border: 5px dashed $p[cdashed]" ;>
<div class="row-fluid">
    <div class="span3">
        $p[product_image_tag]
    </div><!--/span4-->
                    
    <div class="span9">
        <h3>$p[product_name]</h3>
        <span class="product-price"><p style="font-size:160%"><s>&dollar;$p[product_list_price]</s>&nbsp;<span style="font-size:80%;color:red">&dollar;$p[product_retail_price] Online Price</span></p></span>
        <form name="productForm$prod_cnt" class="form-horizontal" method="post" action="/checkout.php">
                            <label class="control-label" for="product_hotel">Hotel Pickup</label>
        <div class="controls">							
EOT;
								showHotelPicker("product_hotel", $p_id);
		echo <<< EOT
          </div>
      
          <div class="control-group">
              <label class="control-label" for="product_date">Date</label>
              <div class="controls">
                  <input type="text" required name="product_date" id="product_date" class="hasDatepicker datepicker readonly" style="cursor:default;"  readonly="readonly"  title="Please click here to select the date" rel=tooltip>
              </div>
          </div>
          
EOT;
								if($product_multiple_times ) {
          echo '<div class="control-group">';
									echo "<label class=\"control-label\" for=\"product_time\">Preferred Time</label>";
									echo "<div class=\"controls\">";
										echo"<label class=\"radio inline\"><input type=\"radio\" name=\"product_time\" value=\"morning\" checked> Morning";
									echo "</label>";
										echo"<label class=\"radio inline\"><input type=\"radio\" name=\"product_time\" value=\"afternoon\"> Afternoon";
									echo "</label>";
									echo "</div>";

          echo '</div>';
								}
	echo <<< EOT
      
        <div class="control-group">
          <label class="control-label" for="product_quantity">Quantity</label>
          <div class="controls">
<select name="product_quantity" id="product_quantity" class="input-min" required>
EOT;
								for($i = 1; $i <= 20; $i++) {
									if($i == $product_defq) {
										echo "<option value=\"$i\" selected>$i</option>";
									}
									else {
										echo "<option value=\"$i\">$i</option>";
									}
								}
	echo <<< EOT
								</select>
		  
<!--            <input type="number" step="1" min="1" max="9" name="product_quantity" value="$product_defq" title="Qty" class="" size="4" /> -->
          </div>
        </div>
        <p style="color:#b94a48;">$product_desc</p>

						<input type="hidden" name="product_price" value="$product_retail_price">
<input type="hidden" name="product_list_price" value="$product_list_price">
<input type="hidden" name="product_sku" value="$product_sku">
						<input type="hidden" name="product_name" value="$product_name">
						<input type="hidden" name="product_id" value="$p_id">
						<input type="hidden" name="tour_link" value="$link_url">
						
						<input type="hidden" name="action" value="addTourToCart">
		
        <input type="submit" class="cta btn btn-success pull-right :focus" value="Add $p[product_name] to Your Cart" />
        </form>
    </div><!--/span6-->
</div><!--/row-fluid-->
</div><!--/well-->
<!--/ END PRODUCT -->	
EOT;
$prod_cnt++;	
  }

/*
	foreach($eProducts as $p) {
		$p_id = $p["product_id"];
		$product_name = $p["product_name"];
		$product_retail_price = $p["product_retail_price"];
		$product_multiple_times = $p["product_multiple_times"];
		$product_desc = $p["product_desc"];
		$product_image_tag = $p["product_image_tag"];
$product_list_price = $p["product_list_price"];
$product_sku = $p["product_sku"];

		echo <<< EOT
				<div class="container-fluid" style="margin: 10px 6px 20px; border: 1px solid #ccc;">
					<div class="row-fluid">
						<h4 class="span8">$product_name</h4>
						<h5 class="span4 pull-right">Online Price <span class="text-error">$$product_retail_price</span></h5>
					</div>
					
					<hr style="margin: 0 0 5px;"/>
					
					<form action="/checkout.php" method="POST" class="container-fluid">	
						<fieldset class="row-fluid">
							<div class="span8">
								<label>Hotel Pickup</label>
EOT;
								showHotelPicker("product_hotel", $p_id);
		echo <<< EOT
								<label>Date</label>
								<input type="text" readonly name="product_date" id="product_date" class="hasDatepicker datepicker" style="cursor:default;" required title="Please click here to select the date" rel=tooltip></input>
EOT;
								if($product_multiple_times ) {
									echo "<label>Preferred Time</label>";
									echo "<label class=\"radio inline\">";
										echo"<input type=\"radio\" name=\"product_time\" value=\"morning\" checked> Morning";
									echo "</label>";
									echo "<label class=\"radio inline\">";
										echo"<input type=\"radio\" name=\"product_time\" value=\"afternoon\"> Afternoon";
									echo "</label>";
									echo "<br/><br/>";
								}

	echo <<< EOT
								<label>Quantity</label>
								<select name="product_quantity" id="product_quantity" class="input-min" required>
EOT;
								for($i = 1; $i <= 10; $i++) {
									if($i == 2) {
										echo "<option value=\"$i\" selected>$i</option>";
									}
									else {
										echo "<option value=\"$i\">$i</option>";
									}
								}
	echo <<< EOT
								</select>
							</div>
							<div class="span4">
								$product_image_tag
							</div>
						</fieldset>
						
						<input type="hidden" name="product_price" value="$product_retail_price">
<input type="hidden" name="product_list_price" value="$product_list_price">
<input type="hidden" name="product_sku" value="$product_sku">
						<input type="hidden" name="product_name" value="$product_name">
						<input type="hidden" name="product_id" value="$p_id">
						<input type="hidden" name="tour_link" value="$link_url">
						
						<input type="hidden" name="action" value="addTourToCart">
						<input type="submit" class="btn btn-success" value="Add to Cart" />
					</form>
					
					<div class="row-fluid">
						<p class="span12 text-error text-center pagination-centered">
EOT;
						echo str_replace("\n", "<br/>", $product_desc);
	echo <<< EOT
						</p>
					</div>
				</div>
EOT;
	}			
*/				
	echo <<< EOT
				
				<p style="text-align:center;margin:10px 0 50px 0">For groups of 10 or more, please <a href="/contact/">contact us directly</a></p>
			
	
EOT;
}

function showHotelPicker($name, $p_id = 0) {
	// Find Modified Values
	$sql = "SELECT * FROM hotels_products WHERE p_id = '$p_id'";
	$res = mysql_query($sql) or die(mysql_error());
	$mods = array();
	while ($row = mysql_fetch_assoc($res))
    {
		$mods[$row["h_id"]] = $row;
	}
	
	echo "<select id=\"$name\" name=\"$name\" data-placeholder=\"Hotel for Pickup\"  class=\"input-large chosen-select\" data-required=\"true\">";
            echo "<option value=\"\"></option>";
			
    $sql = "select * FROM hotels ORDER BY hotel_position ASC";
    $res = mysql_query($sql) or die(mysql_error());
    $group = array();
    $str = "";
    while ($row = mysql_fetch_assoc($res))
    {
      $group[$row['hotel_location']][] = $row;
    }
    foreach ($group as $key => $values_mbr)
    {
      $str.= '          <optgroup label="'.$key.'">';
      $str.="\n";
      foreach ($values_mbr as $value_mbr) 
      {
			// Check for mods
			if(isset($mods[$value_mbr['hotel_id']])) {
				// If not available, say so
				if($mods[$value_mbr['hotel_id']]['hotel_available'] == 0 || $mods[$value_mbr['hotel_id']]['hotel_available'] == false) {
					$str.= '              <option disabled value="'.$value_mbr['hotel_id'].'">'.$value_mbr['hotel_name'].' - N/A </option>';
					$str.="\n";
					
					continue;
				}
			
if($mods[$value_mbr['hotel_id']]['hotel_extra_cost'])
{			
				// Otherwise we have a cost modification
				$str.= '              <option value="'.$value_mbr['hotel_id'].'">'.$value_mbr['hotel_name'].' - $' . $mods[$value_mbr['hotel_id']]['hotel_extra_cost'] . ' Extra </option>';
}
else
{
				$str.= '              <option value="'.$value_mbr['hotel_id'].'">'.$value_mbr['hotel_name'].'</option>';
}				
				$str.="\n";
			}
			else {
				$str.= '              <option value="'.$value_mbr['hotel_id'].'">'.$value_mbr['hotel_name'].'</option>';
				$str.="\n";
			}
      }
      $str.= '          </optgroup>';
      $str.="\n";
    }
    $str.="</select>";
    echo $str;
    
}

/* Easy way of retrieving cart total for menu display */
function getCartTotal($cart="cart") {
	$total = 0.0;
	if(isset($_SESSION[$cart] ))
	{
	foreach($_SESSION[$cart]  as $item) {
		$total += ($item["price"] * $item["quantity"]);
	}
	}
	return $total;
}

function getCartExtraTotal($cart="cart") {
	$total = 0.0;
	if(isset($_SESSION[$cart] ))
	{
	foreach($_SESSION[$cart]  as $item) {
		$total += ($item["extra_price"] * $item["quantity"]);
	}
    }
	return $total;
}

function getCartListTotal($cart="cart") {
	$total = 0.0;
	if(isset($_SESSION[$cart] ))
	{
	foreach($_SESSION[$cart]  as $item) {
		$total += ($item["list_price"] * $item["quantity"]);
	}
    } 
	return $total;
}

function getItemCount() {
	$total = 0;
	if(isset($_SESSION["cart"] ))
	{
	foreach($_SESSION["cart"]  as $item) {
		$total += $item["quantity"];
	}
	}
	return $total;
}
function _formdate($da)
{
$armonth = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
list($m,$d,$y)=explode('-',substr($da, 0, 10));
$im = (int)$m;
if($im)
   {
   $mm = $armonth[$im];
   return("$mm $d");
   }
return(' - ');
}
function _formdate_a($da)
{
$armonth = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
list($y,$m,$d)=explode('-',substr($da, 0, 10));
$im = (int)$m;
if($im)
   {
   $mm = $armonth[$im];
   return("$mm $d");
   }
return(' - ');
}
function _formdate_full($da)
{
$armonth = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
list($m,$d,$y)=explode('-',substr($da, 0, 10));
$im = (int)$m;
if($im)
   {
   $mm = $armonth[$im];
   return("$mm $d, $y");
   }
return(' - ');
}
function _formdate_diff($da)
{
list($m,$d,$y)=explode('-',substr($da, 0, 10));
$d1 = strtotime("$y-$m-$d");

$dnow = strtotime(date("Y-m-d"));
return($d1 - $dnow);
}

function clean($str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}

?>