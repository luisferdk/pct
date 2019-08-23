<?php 
require_once 'inc/config.php'; 
require_once 'inc/cart-manager-pp.php';
checkout_ok();
$add_google_ecommerce = 0;
if(isset($_SESSION["google_ecommerce"]))
   {
   unset($_SESSION["google_ecommerce"]);
   $add_google_ecommerce = 1;
   }

   if($add_google_ecommerce)
      {
// AUTOMATED EMAIL
//-----------------------------------------------------------------
require_once 'inc/confirmation_email.php';
//-----------------------------------------------------------------
       }    
?>

<?php require_once 'inc/meta-checkout-ok.php'; ?>
<?php require_once 'inc/header.php'; ?>

<?
// add Google eCommerce code here
// --------------------------------------------------------------   
   if($add_google_ecommerce)
      {
?>	  
<script>
ga('require', 'ecommerce', 'ecommerce.js');

<?php
echo google_ecommerce_data();
?>

ga('ecommerce:send');
</script>	  
<?
	  }
// --------------------------------------------------------------   
?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/">Home</a> <span class="divider">></span></li>
    <li class="active">Thanks</li>
  </ul>
  <div class="row">
    <div class="span8">

  <?php /* iDevAffiliate Program Tracking */
  echo $_SESSION['idevsdone'];
  $_SESSION['idevsdone']='';
  ?>
	
      <!-- Main Content
      ================================================== -->
      <section class="main_body">
        <h1>Thank You <?= $_SESSION["checkout_closed"]["first_name"].' '.$_SESSION["checkout_closed"]["last_name"] ?></h1>
        <p>Your order has been <strong>submitted</strong>.  Here are your order details:</p>
        <p>&nbsp;</p>
        
<table class="table table-condensed table-hover">
<thead>
<tr>
    <th>Item</th>
    <th>Date</th>
    <th>Qty</th>
    <th>Price</th>
</tr>
</thead>
<tbody>
<?php 
$carttotal = getCartTotal("cart_closed");
$listtotal = getCartListTotal("cart_closed");
$extratotal = getCartExtraTotal("cart_closed");

foreach($_SESSION["cart_closed"] as $item_id => $item) { 
?>	
<tr>
    <td class="muted"><?php echo $item["name"]; ?></td>
    <td class="muted">
<? 
if(isset($item["date"]))
   echo _formdate($item["date"]);
if(isset($item["arrival_date"]))
   echo _formdate_a($item["arrival_date"]);

if(isset($item["departure_date"]))
   {
   if(isset($item["arrival_date"]))
      echo ' - ';
   echo _formdate_a($item["departure_date"]);
   }
   
?>
    </td>
    <td class="muted"><?= $item["quantity"] ?></td>
    <td class="muted">$<?php echo number_format($item["price"], 2); ?></td>
</tr>
<?
}
?>
<tr>
    <td class="muted">Order Total</td>
    <td></td>
    <td></td>
    <td style="font-size:110%;color:green">$<?= number_format($carttotal,2) ?></td>
</tr>
<?
$saved = ($listtotal+$extratotal)-$carttotal;
if($saved > 0)
  {
?>
<tr>
    <td class="muted">You SAVED  <span style="color:orange">$<?= number_format($saved, 2) ?></span></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<?
  }
?>
</tbody>
</table>
            
        
        
		<p>We will be contacting you very shortly to give you your tour and/or transportation vouchers complete with your pickup times and location.<p>
		<p>Please make sure that any email from Caribbean Dream does not end up in your SPAM folder. If you don't hear from us, please check your SPAM folder and make sure our emails to you did not end up there.</p>
		<p>If you need help, or wish to contact us for any reason, you can either call us at 809-552-6862, or email us using the form on <a href="/contact/">this page</a>.  Thanks again for your business, and we look forward to seeing you soon!</p>
		<p>Best Regards,<br /><br />
			Caribbean Dream</p>
		<p>&nbsp;</p>
		<a href="/" class="btn btn-success">Back to Homepage</a>
        
      </section><!-- /main_body -->
    </div> <!-- /span8 (left column) -->

    <?php require_once 'inc/sidebar_tour.php'; ?>
      </div><!-- /row -->
    </div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>
