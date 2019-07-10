<!-- Sidebar
================================================== -->
<aside class="span4">
    <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<?

?>    
    <div class="well-small">
    <div class="thumbnail" style="padding: 0">
    <div class="caption">
      <h4 class="muted">Order Summary</h4>
      <table class="table table-condensed table-hover">
      <thead>
      	<tr>
      		<th>Item</th>
      		<th>Qty</th>
      		<th>Price</th>
      	</tr>
      </thead>
      <tbody>
<?php 
$carttotal = getCartTotal();
$listtotal = getCartListTotal();
$extratotal = getCartExtraTotal();

foreach($_SESSION["cart"] as $item_id => $item) { 
?>	  
      	<tr>
      		<td class="muted"><?php echo $item["name"]; ?></td>
      		<td class="muted"><?= $item["quantity"] ?></td>
      		<td class="muted">$<?php echo number_format($item["price"], 2); ?></td>
      	</tr>
<?php } ?>
      	<tr>
      		<td class="muted">Total Cost</td>
      		<td></td>
      		<td style="font-size:110%;color:green">$<?= number_format($carttotal,2) ?></td>
      	</tr>
<?
$saved = ($listtotal+$extratotal)-$carttotal;
if($saved > 0)
   {
?>		
      	<tr>
      		<td class="muted">Total savings</td>
      		<td></td>
      		<td style="font-size:90%;color:orange">$<?= number_format($saved, 2) ?></td>
      	</tr>
<?
   }
?>		
      </tbody>
      </table>
    </div>
    <div class="modal-footer" style="text-align: left">


    </div>
    </div>
</div><!--/well-small-->

<div class="well-small">
    <a href=""><img style="display:block; margin-left:auto; margin-right:auto" src="//puntacanatours-caribbeandream.netdna-ssl.com/img/secure-payment.png" alt="SSL Secure Payment" /></a>
  </div>
  <div class="well-small">
    <span itemprop="telephone"><a href="tel:+18095526862"><img style="display:block; margin-left:auto; margin-right:auto" src="//cdtoen-caribbeandream.netdna-ssl.com/assets/call-dr-tours.png" alt="Call 1-829 961-4829 Today" /></a></span>
  </div> 
  <div class="well-small" style="text-align:center">
      <img src="//puntacanatours-caribbeandream.netdna-ssl.com/img/truste-verified.png" alt="Privacy and Trust Verified" />
    </div>
<?

?>	
</aside>