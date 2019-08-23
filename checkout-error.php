<?php 
require_once 'inc/config.php'; 
require_once 'inc/cart-manager-pp.php';
checkout_error();
?>

<?php require_once 'inc/meta.php'; ?>
<?php require_once 'inc/header.php'; ?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/">Home</a> <span class="divider">></span></li>
    <li class="active">Error</li>
  </ul>
  <div class="row">
    <div class="span8">
      
      <!-- Main Content
      ================================================== -->
      <section class="main_body">

	  <h1>Oops... Something went wrong!</h1>
<?
if($_SESSION["checkout_error"] == 'paypal')
   {
   unset($_SESSION["checkout_error"]);
?>		
		<h4>Sorry, PayPal failed. Please try paying directly with your Credit Card</h4>
<?
   }
else
   {
   unset($_SESSION["checkout_error"]);
?>		
		<h4>We are sorry, but your current Credit Card could not be processed. </h4>
		<p>This is normally due to high card activity over a short time period, limitations due to online or international orders, or a temporary issue somewhere in the processing network.</p>

        To solve this problem you can:
        <ol>
        <li>Contact your financial institution and try your card again.</li>
        <li>Try a different Credit Card issued from a different bank.</li>
        <li>Or, try an alternative payment method such as PayPal.</li>
        </ol>

        <p>For your convenience, we have reserved your items for the next few minutes and look forward to you trying agin.</p>.
<?
   }   
?>		
<!--  
        <h1>Oops... Something went wrong!</h1>
-->		
        <p>&nbsp;</p>
        
        <b>Error message:</b> <?= $_SESSION["checkout"]["ppresponse"]["RESPMSG"] ?>

		<p>&nbsp;</p>
		<a href="/checkout3.php" class="btn btn-success">Try Again</a>
        
      </section><!-- /main_body -->
    </div> <!-- /span8 (left column) -->

    <?php require_once 'inc/sidebar_tour.php'; ?>
      </div><!-- /row -->
    </div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>
