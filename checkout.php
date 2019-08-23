<?php require_once 'inc/config.php'; ?>
<?php require_once 'inc/cart-manager.php'; ?>
<?php require_once 'inc/meta-checkout.php'; ?>
<?php require_once 'inc/header.php'; ?>

<?php
	$totalSteps = 3;
	
	if(!isset($_SESSION["checkout_step"])) {
		$_SESSION["checkout_step"] = 1;
	}
?>
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="/">Home</a> <span class="divider">></span></li>
      <li class="active"><a href="checkout.php">Checkout</a></li>
    </ul>
    <div class="row">
      <div class="span8">

        <!-- Main Content
        ================================================== -->
        <section class="main_body">
		  <?php 
		  //echo "Step " . $_SESSION["checkout_step"] . " of " . $totalSteps . ": ";
		  switch($_SESSION["checkout_step"]) {
				case 1:
					echo "<h2>Shopping Cart</h2><p>&nbsp;</p>";
					break;
				case 2:
					echo "<h2>Checkout</h2><p>&nbsp;</p><h4 class='muted'>Customer Info (Step 1 of 3)</h4>";
					break;
				case 3:
					echo "<h2>Payment</h2><p>&nbsp;</p><h4 class='muted'>Payment (Step 2 of 3)</h4>";
					break;
				case 4:
					echo "<h2>Confirmation</h2><p>&nbsp;</p><h4 class='muted'>Confirmation (Step 3 of 3)</h4>";
					break;
				case 5:
					echo "<h2>Thank You</h2><p>&nbsp;</p>";
					break;
			}
		  ?>
		  
		<!--
          <div class="progress progress-striped active">
            <div class="bar" style="width: <?php echo ((100.0 / $totalSteps) * $_SESSION["checkout_step"]);?>%;"></div>
          </div>
		-->
		 
		  
		  
		  <!-- Stage 1 Content -->
		  <?php if($_SESSION["checkout_step"] == 1) { ?>
			  <div class="container-fluid">
				<?php
				$cartTotal = getCartTotal();
				if($cartTotal != 0) {
				?>
					<table class="table table-striped">
					<tr>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Cost</th>
					</tr>
					<?php 
					$alldiff = 0;
					foreach($_SESSION["cart"] as $item_id => $item) { 
					
					$diff = 0;
					?> 
					<tr>
						
							<td>
								<?php if($item["type"] == 1) { ?>
									<a href="/<?php echo $item["link"]; ?>"><?php echo $item["name"]; ?></a>
								<?php 
if(isset($item["date"]))
   {
   $diff = _formdate_diff($item["date"]);
   if($diff < 0)
      {
	  $alldiff = $diff;
      echo '<br /><span class="text-error">'._formdate_full($item["date"]).'</span>';
	  }
   else   
      echo '<br /><span class="muted">'._formdate_full($item["date"]).'</span>';
   }
   
   
								} 
								
								else if($item["type"] == 2){ ?>
									<a href="/transportation.php"><?php echo $item["name"]; ?></a>
								<?php } else { ?>
									<?php echo $item["name"]; ?>
								<?php } ?>
							</td>
							<td>$<?php echo number_format($item["price"], 2); ?></td>
							<td>
								<form id="refresh<?php echo $item_id; ?>" style="margin:0;" action="/checkout.php" method="POST">
									<div class="input-append">
										<select name="item_quantity" id="item_quantity" class="input-mini" required>
										<?php
										if($item["type"] == 2) {
											echo "<option value=\"0\">0</option>";
											echo "<option value=\"1\" selected>1</option>";
										} else {
											for($i = 0; $i <= 10; $i++) {
												if($i == $item["quantity"]) {
													$activeText = " selected";
												}
												else {
													$activeText = "";
												}
												echo "<option value=\"$i\"$activeText>$i</option>";
											}
										}
										?>
										</select>
										
										<button onlick="$('#refresh<?php echo $item_id; ?>').submit();" class="btn btn-danger"><i class="icon-refresh icon-white"></i></button>
									</div>
									<input type="hidden" name="action" value="updateQuantity">
									<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
								</form>
							</td>
							<td>$<?php echo number_format($item["price"] * $item["quantity"], 2); ?></td>
							
							
						
					</tr>
					<?php } ?>
					<tr>
						<td><strong>Total</strong></td>
						<td></td>
						<td></td>
						<td><strong>$<?php echo number_format($cartTotal, 2);?></strong></td>
					</tr>
					</table>
					
					<a class="btn pull-right pull-left" href="/excursions/all-tours/"><i class="icon-chevron-left"></i> Continue Shopping</a>
<!--
					<form class="pull-right" action="/checkout.php" method="POST">
						<input type="hidden" name="current_total" value="<?php echo number_format($cartTotal, 2);?>">
						<input type="hidden" name="action" value="toStep2">
						<button type="submit" class="btn btn-success pull-right">
                          <i class="icon-lock icon-white"></i> Proceed to Checkout
                        </button><br /><br />
						<div class="clearfix"></div>
-->						


						<a class="btn btn-warning pull-right" href="checkout2.php"><i class="icon-lock icon-white"></i> Proceed to Secure Checkout <i class="icon-chevron-right icon-white"></i></a>
						
<!--						
					</form>
-->					
					<div class="clearfix"></div>
					<p>&nbsp;</p> 
					<p class="muted">If you need to remove an item from your cart, just change the quantity to zero, and press the blue refresh button.</p>

					</div>
				<?php } else { //no items in cart ?>
					<h3> Your cart is empty. Let's add some stuff! </h3>
                    <p class="muted">(This situation can easily be resolved by clicking on one of the links below)</p>

                    <div class="alert alert-info">
                        <h3>Excursions</h3>
                        <p>Deals for yourself, your family, and more! Pickup at all Local Hotels included.<br /><br />
                        <a class="btn btn-success span6" href="/excursions/all-tours/"> Shop Excursions</a></p>
                        <div class="clearfix"></div>
                    </div>

                    <div class="alert alert-info">
                        <h3>Transportation</h3>
                        <p>On-time, Fast, and Efficient transportation between your resort and the airport<br /><br />
                        <a class="btn btn-success span6" href="/transportation/"> Shop Transportation</a></p>
                        <div class="clearfix"></div>
                    </div>
					
					<div class="clearfix"></div>
				<?php } ?>
		  <?php } ?>
		  
		  
		  <!-- Stage 2 Content -->
		  <?php if($_SESSION["checkout_step"] == 2) { ?>
			<div class="progress progress-striped active">
	            <div class="bar" style="width: <?php echo ((100.0 / $totalSteps) * 1);?>%;"></div>
	        </div>
			  <div class="container-fluid">
				<form action="/checkout.php" method="POST">
					<div class="row-fluid">
					  <div class="span6">
						<label>First Name</label>
						<input type="text" name="first_name" value="" required>
					  </div>
					  <div class="span6">
						<label>Last Name</label>
						<input type="text" name="last_name" value="" required>
					  </div>
					</div>
					<div class="row-fluid">  
						<div class="span6">
						  <label>Email</label>
						  <input type="email" name="email" value="" required>
						</div>
						<div class="span6">
						  <label>Phone (Strongly recommended)</label>
						  <input type="text" name="phone" value="">
						</div>
					</div><!--/row--> 
				  
			        <label>If you have any Comments, Requests, Special Needs, let us know</label>
                    <div class="control-group">
                        <div class="controls">
                          <textarea class="span7" rows="3" name="msg"></textarea>
                        </div>
                    </div>
                    
					<input type="hidden" name="action" value="toStep3">
					<input type="submit" value="Continue" class="pull-right btn btn-success"/>
					<div class="clearfix"></div>
				</form>
			  </div>
		  <?php } ?>
		  
		  
		  <!-- Stage 3 Content -->
		  <?php if($_SESSION["checkout_step"] == 3) { ?>
			<div class="progress progress-striped active">
	            <div class="bar" style="width: <?php echo ((100.0 / $totalSteps) * 2);?>%;"></div>
	        </div>
			  <div class="container-fluid pagination-centered text-center">
				<p>Thank you! We have received your order.</p>
				<p>Now we need you to pay for your order by clicking on the PayPal button below. <span class='muted'>Depending on your country of origin, you will be able to pay with your PayPal account, your Credit Card, or a check from you Bank.</span></p>
				<p>&nbsp;</p>
				<a href="/paypal-begin.php">
					<img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif">
				</a>
			  </div>		  
		  <?php } ?>
		  
		  
		  <!-- Stage 4 Content -->
		  <?php if($_SESSION["checkout_step"] == 4) { ?>
			<div class="progress progress-striped active">
	            <div class="bar" style="width: <?php echo ((100.0 / $totalSteps) * 3);?>%;"></div>
	        </div>
			<div class="container-fluid">
				<h2>My Order</h2>
				<?php
				$cartTotal = getCartTotal();
				?>
					<table class="table table-striped">
					<tr>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Cost</th>
					</tr>
					<?php foreach($_SESSION["cart"] as $item_id => $item) { ?> 
					<tr>
						<td><?php echo $item["name"]; ?></td>
						<td>$<?php echo number_format($item["price"], 2); ?></td>
						<td><?php echo $item["quantity"]; ?></td>
						<td>$<?php echo number_format($item["price"] * $item["quantity"], 2); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td><strong>Total</strong></td>
						<td></td>
						<td></td>
						<td><strong>$<?php echo number_format($cartTotal, 2);?></strong></td>
					</tr>
					</table>
					
					<a href="/paypal-finalize.php" class="pull-right btn btn-success">Submit Order</a>
					<div class="clearfix"></div>
				  </div>  
		  <?php } ?>
		  
		  <!-- Stage 4 Content -->
		  <?php if($_SESSION["checkout_step"] == 5) { ?>
			  <div class="container-fluid">
				<h4> Your Order has been Received </h4>
				<p>Thank you for your order. You will receive a receipt of your payment from PayPal very shortly.<p> 
				<p>We will also be contacting you if we need any more information from you and to give you your tour and/or transportation vouchers.<p>
				<p>Please make sure that any email from Caribbean Dream does not end up in your SPAM folder by white-listing any email from @CaribbeamDreamTO.com to your Safe Senders list of your email program.</p>
				<p>If you need to contact for any reason, you can either phone us at 829-548-2386, or email us using the form on <a href="/contact.php">this page</a>.  Thanks again for your business, and we look forward to seeing you soon!</p>
				<p>Best Regards,<br /><br />
					Caribbean Dream</p>
				<p>&nbsp;</p>
				<a href="/" class="pull-right btn btn-success">Back to Homepage</a>
				<div class="clearfix"></div>
			  </div>		  
		  <?php } ?>
		  
        </section><!-- /main_body -->
      </div> <!-- /span8 (left column) -->

  <?php require_once 'inc/sidebar_tour.php'; ?>
    </div><!-- /row -->
  </div><!-- /container -->

  <?php require_once 'inc/footer.php'; ?>
