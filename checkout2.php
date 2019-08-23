<?php require_once 'inc/config.php'; ?>
<?php require_once 'inc/cart-manager-pp.php'; ?>
<?php require_once 'inc/meta-checkout2.php'; ?>
<?php require_once 'inc/header-checkout.php'; ?>

<?php
	$totalSteps = 3;
	$_SESSION["checkout_step"] = 2;
    
	$name = "";
	$email = "";
	$phone = "";
	$msg = "";
$salesrep = 0;

    $error = 0;
    if(isset($_SESSION["checkout_error"]))
	   {
       $error = $_SESSION["checkout_error"];
	   unset($_SESSION["checkout_error"]);
	   }
	   
	if(isset($_SESSION["checkout"]["first_name"]))
	   $name = strip_tags($_SESSION["checkout"]["first_name"].' '.$_SESSION["checkout"]["last_name"]);
	elseif(isset($_SESSION["checkout_closed"]["first_name"]))   
	   $name = strip_tags($_SESSION["checkout_closed"]["first_name"].' '.$_SESSION["checkout_closed"]["last_name"]);
	if(isset($_SESSION["checkout"]["email"]))
	   $email = strip_tags($_SESSION["checkout"]["email"]);
	elseif(isset($_SESSION["checkout_closed"]["email"]))   
	   $email = strip_tags($_SESSION["checkout_closed"]["email"]);
	if(isset($_SESSION["checkout"]["phone"]))
	   $phone = strip_tags($_SESSION["checkout"]["phone"]);
	elseif(isset($_SESSION["checkout_closed"]["phone"]))
	   $phone = strip_tags($_SESSION["checkout_closed"]["phone"]);
	if(isset($_SESSION["checkout"]["msg"]))
	   $msg = strip_tags($_SESSION["checkout"]["msg"]);
	if(isset($_SESSION["checkout"]["salesrep"]))
	   $salesrep = strip_tags($_SESSION["checkout"]["salesrep"]);
	
?>
  <div class="container">
    <ul class="breadcrumb">
      <li></li>
    </ul>
    <div class="row">
      <div class="span8">

        <!-- Main Content
        ================================================== -->
        <section class="main_body">
          <h2>Shopping Cart</h2>
		  <p>&nbsp;</p>
		  <h4 class="muted">
		  <?php 
		  echo "Step 2 of 3: Tell Us About You";
		  ?>
		  </h4>
		
          <div class="progress progress-striped active">
            <div class="bar" style="width: <?php echo ((100.0 / $totalSteps) * $_SESSION["checkout_step"]);?>%;"></div>
          </div>
		  
		  <!-- Stage 1 Content -->
		  
		  <!-- Stage 2 Content -->
		  <?php if($_SESSION["checkout_step"] == 2) { ?>
			  <div class="container-fluid">
				<form action="checkout3.php" method="POST">

<div class="control-group">
    <label class="control-label" for="name"></label>
    <div class="controls">
<?
if($error == 1)
   echo '<font color="red">Please enter your full name</font>'; 
?>	
      <div class="input-prepend">
        <span class="add-on"><i class="icon-user"></i></span><input id="name" name="fullname" placeholder="firstname lastname" type="text" required="required" value="<?= $name ?>">
      </div>
      <p class="muted help-inline">we'd like to know your name</p>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="email"></label>
    <div class="controls">
<?
if($error == 2)
   echo '<font color="red">Please enter your email</font>'; 
if($error == 3)
   echo '<font color="red">This email looks invalid</font>'; 
?>	
      <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope"></i></span><input id="email" name="email" placeholder="email address" type="text" required="required" value="<?= $email ?>">
      </div>
      <p class="muted help-inline">in case we need to email you</p>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="phone"></label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-signal"></i></span><input id="phone" name="phone" placeholder="305-555-1212"  value="<?= $phone ?>" type="text">
      </div>
      <p class="muted help-inline">phone number (strongly suggested)</p>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="salesrep"></label>
    <div class="controls input-medium">
        <select class="span3" name="salesrep" id="salesrep">
			<option value="0" <?= ($salesrep == 0 ? 'selected' : '') ?>>-- No Sales Rep --</option>
<?
// select sales rep
$query = "SELECT * FROM users where salesrep > '0'";
$res = mysql_query($query) or die(mysql_error());
$NumRows = mysql_num_rows($res);
if($NumRows)
    {
      while($row = mysql_fetch_array($res))
	   {
?>
			<option value="<?= $row['uid'] ?>"  <?= ($salesrep == $row['uid'] ? 'selected' : '') ?>><?= $row['firstname'] ?></option>
<?
       }
    }
?>			
		</select>
      <p class="muted help-inline">who helped you?</p>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="message"></label>
    <textarea class="form-control span7" rows="3" name="msg" id="message" placeholder="Please enter your room number if applicable. Also, if you have any comments, requests, special needs, let us know"><?= $msg ?></textarea>
</div>
<!--
<a class="btn pull-left" href="checkout.php"><i class="icon-chevron-left"></i> Back to cart</a>
-->

		<input type="hidden" name="action" value="toStep3">
		
		<button type="submit" class="btn btn-warning pull-right">
         <i class="icon-lock icon-white"></i> Continue to Billing Details <i class="icon-chevron-right icon-white"></i> 
        </button><br /><br />
		
		<div class="clearfix"></div>
		<p>&nbsp;</p> 
        <p class="muted">We guarantee 100% privacy. Your information will not be shared.</p>
		
		
	</form>
  </div>
<?php } ?>

		  <!-- Stage 3 Content -->

		  <!-- Stage 4 Content -->

		  <!-- Stage 5 Content -->

        </section><!-- /main_body -->
      </div> <!-- /span8 (left column) -->

  <?php require_once 'inc/sidebar-checkout.php'; ?>
    </div><!-- /row -->
  <div><!-- /container -->

  <?php require_once 'inc/footer-checkout.php'; ?>
