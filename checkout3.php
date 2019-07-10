<?php 
require_once 'inc/config.php'; 
require_once 'inc/cart-manager-pp.php';
checkout3();

$total_cost = getCartTotal();
?>

<?php require_once 'inc/meta-checkout3.php'; ?>
<?php require_once 'inc/header-checkout.php'; ?>

<?php
$totalSteps = 3;
$_SESSION["checkout_step"] = 3;

$error = 0;
$open_block = '';
if(isset($_SESSION["checkout_error"]))
   {
   $error = $_SESSION["checkout_error"];
   unset($_SESSION["checkout_error"]);
   $open_block = 'in';
   }

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

		  <h2>Payment</h2>
		  <p>&nbsp;</p>
		  <h4 class='muted'>Last Step: Payment Method</h4>

          <div class="progress progress-striped active">
              <div class="bar" style="width: <?php echo ((100.0 / $totalSteps) * $_SESSION["checkout_step"]);?>%;"></div>
            </div>

		 
		  
		  
		  <!-- Stage 1 Content -->

		  
		  
		  <!-- Stage 2 Content -->

		  
		  
		  <!-- Stage 3 Content -->
<?php if($_SESSION["checkout_step"] == 3) { ?>
<div class="container-fluid pagination-centered text-center">

<style style="text/css">
.accordion-group {align: left}

</style>



<h4>Choose a Payment Option</h4>


    <div class="accordion-group" style="text-align:left">
            <div class="accordion-heading">
                <a href="#collapseOne" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">1. Pay with PayPal</a>
            </div>
            <div class="accordion-body collapse" id="collapseOne">
                <div class="accordion-inner">
                    <p>What is PayPal?<br />
                    PayPal is the safer, easier way to pay online. Pay with your credit card without exposing your credit card number to the merchant. Plus, speed thru checkout whenever you shop online.</p>
<p>
<span class='muted'>Depending on your country of origin, you will be able to pay with your PayPal account, your Credit Card, or a check from you Bank.</span>
</p>
				<p>
<?
/*				
if($_SESSION["checkout"]["email"] == 'ealexnet@gmail.com')
   {
?>
<p>
Hey, Alex, this is a test EC transaction via PayFlow.
<br>
SESSION:
<br>
<pre>
<?
print_r($_SESSION);
echo '<br>
REQUEST:
<br>
';
print_r($_REQUEST);
?>
</pre>
</p>
<p>
					<form id="form" action="checkout4ppec.php" method="POST">
<?   
   }
*/   
?>
					<form id="form" action="checkout4ppec.php" method="POST">
<!--					<form id="form" action="checkout4pp.php" method="POST"> -->
					    <!-- 
                    <div class="control-group">
                      <label for="transtype"><b>Transaction Type</b></label>
					  <input type="radio" name="transtype" id="transtype" value="test" checked> TEST
                      <input type="radio" name="transtype" id="transtype" value="live"> LIVE
                    </div>
                    <div class="control-group">
                      <label for="override"><b>Override total cost: [<?= $total_cost ?>]</b></label>
					  <input type="text" name="override" class="span7" id="override" value="">
                    </div>
                    --> 
                    <input type="hidden" name="transtype" id="transtype" value="live">
                        <div id="loading2" style="display:none;"><img src="images/ajax-loader-7.gif" alt="" /><br />Please wait while we connect you to PayPal...</div>
					    <input id="submit" type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" alt="Submit Form" />
					</form>
<script type="text/javascript">
(function (d) {
  d.getElementById('form').onsubmit = function () {
    d.getElementById('submit').style.display = 'none';
    d.getElementById('loading2').style.display = 'block';
  };
}(document));

function getData(s)
{
if(s.value != 'US' && s.value != 'CA')     
   {
   document.getElementById('billstateother').style.display = 'inline';
   document.getElementById('billstate').style.display = 'none';
   }
else
   {
   document.getElementById('billstateother').style.display = 'none';
   document.getElementById('billstate').style.display = 'inline';
   }   
}
</script>					
				</p>
                </div>
                
            </div>
        </div> 
  
        <div class="accordion-group" style="text-align:left">
            <div class="accordion-heading">
                <a href="#collapseTwo" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">2. Pay with Credit Card</a>
            </div>
            <div class="accordion-body collapse <?= $open_block ?>" id="collapseTwo">
                <div class="accordion-inner">
<form action="checkout4.php" method="POST"> 

                    <!-- Start -->
                    <!-- Name -->
                    <div class="control-group">
<?
if($error == 1)
   echo '<font color="red">Invalid transaction type</font>'; 
?>	
<!--
					
                      <label for="transtype"><b>Transaction Type</b></label>
					  <input type="radio" name="transtype" id="transtype" value="test" checked> TEST
                      <input type="radio" name="transtype" id="transtype" value="live"> LIVE
                    </div>
                    <div class="control-group">
                      <label for="override"><b>Override total cost: [<?= $total_cost ?>]</b></label>
					  <input type="text" name="override" class="span7" id="override" value="">
                   
                    </div>
-->

                    <div class="control-group">
					<input type="hidden" name="transtype" id="transtype" value="live">
<?
if($error == 2)
   echo '<font color="red">Cardholder\'s Name on Card is required</font>'; 
?>	
                      <label for="name"><b>Name on Card</b></label>
                      <input type="text" name="ccname" placeholder="John Doe" class="span7" id="name" value="<?= $_POST['fullname'] ?>">
                    </div>
                    
                    <!-- Card Number -->
                    <div class="control-group">
<?
if($error == 3)
   echo '<font color="red">Card number is required</font>'; 
?>	
                      <label for="cardnumber" style="font-weight:900;">Card number</label>
                      <input type="text" name="ccnumber" placeholder="&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;&bull;" class="span7" id="cardnumber" value="<?= (isset($_POST['ccnumber']) ? $_POST['ccnumber'] : '') ?>">
                      <img src="/img/visa.png">&nbsp;<img src="/img/mastercard.png">&nbsp;<!-- <img src="/img/amex.png">&nbsp;<img src="/img/discover.png"> -->
                    </div>
                    
                    <!-- Expiry-->
                    <div class="control-group">
<?
if($error == 4 || $error == 5)
   echo '<font color="red">Card Expiration Date is required</font>'; 
?>	
                    <label class="control-label" for="expiration">Card Expiration Date</label>
                    <div class="controls">
                      <select class="span4" name="expiry_month" id="expiry_month">
					    <option value="00" <?= (!isset($_POST['expiry_month']) || $_POST['expiry_month'] == '00' ? 'selected' : '') ?>>Month</option>
                        <option value="01" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '01' ? 'selected' : '') ?>>01-Jan</option>
                        <option value="02" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '02' ? 'selected' : '') ?>>02-Feb</option>
                        <option value="03" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '03' ? 'selected' : '') ?>>03-Mar</option>
                        <option value="04" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '04' ? 'selected' : '') ?>>04-Apr</option>
                        <option value="05" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '05' ? 'selected' : '') ?>>05-May</option>
                        <option value="06" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '06' ? 'selected' : '') ?>>06-Jun</option>
                        <option value="07" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '07' ? 'selected' : '') ?>>07-Jul</option>
                        <option value="08" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '08' ? 'selected' : '') ?>>08-Aug</option>
                        <option value="09" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '09' ? 'selected' : '') ?>>09-Sep</option>
                        <option value="10" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '10' ? 'selected' : '') ?>>10-Oct</option>
                        <option value="11" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '11' ? 'selected' : '') ?>>11-Nov</option>
                        <option value="12" <?= (isset($_POST['expiry_month']) && $_POST['expiry_month'] == '12' ? 'selected' : '') ?>>12-Dec</option>
                      </select>
                      <select class="span3" placeholder="year" name="expiry_year">
					    <option value="00" <?= (!isset($_POST['expiry_year']) || $_POST['expiry_year'] == '00' ? 'selected' : '') ?>>Year</option>
<?
$year = date("Y");
?>
                        <option value="<?= substr($year, 2) ?>" <?= (isset($_POST['expiry_year']) && $_POST['expiry_year'] == substr($year, 2) ? 'selected' : '') ?>><?= $year ?></option>

<?
for ($x=1; $x<=10; $x++) {
  $nyear = $year + $x;
?>
                        <option value="<?= substr($nyear, 2) ?>" <?= (isset($_POST['expiry_year']) && $_POST['expiry_year'] == substr($nyear, 2) ? 'selected' : '') ?>><?= $nyear ?></option>

<?  
}
?>					  
                      </select>
                    </div>
                    </div>
                              
                    <!-- CVV -->
                      <div class="control-group">
<?
if($error == 6)
   echo '<font color="red">Card security code (CVV) is required</font>'; 
?>	
                        <label for="cvv">Security Code</label>
                        <div class="controls">
                          <input type="text" name="cvv" placeholder="&bull;&nbsp;&bull;&nbsp;&bull;&nbsp;" id="cvv" class="span7" value="<?= (isset($_POST['cvv']) ? $_POST['cvv'] : '') ?>">
                          <img src="/img/cvv.png">
                        </div>
                      </div>
                              
                    <hr />

            <h4>Enter You Billing Details Below </h4>
                    <div class="control-group">
                      <label for="name">Street Address</label>
                      <input type="text" name="billstreet" placeholder="123 E Main Street" class="span7" id="address1" value="<?= (isset($_POST['billstreet']) ? $_POST['billstreet'] : '') ?>">
                    </div>
                    
                    
                    <!-- City State -->
                    <div class="control-group">
                    <label class="control-label" for="password">City / State</label>
                        <div class="controls">
                          <input type="text" name="billcity" placeholder="Anytown" class="span4" id="city" value="<?= (isset($_POST['billcity']) ? $_POST['billcity'] : '') ?>">
<!--                          <input type="text" name="billstate" placeholder="State" class="span4" id="state" value="<?= (isset($_POST['billstate']) ? $_POST['billstate'] : '') ?>"> -->
						  <input type="text" <?= (!isset($_POST['billcountry']) || ($_POST['billcountry'] == "US" || $_POST['billcountry'] == "CA") ? 'style="display:none;"' : '') ?> name="billstateother" placeholder="Anystate" class="span3" id="billstateother" value="<?= (isset($_POST['billstateother']) ? $_POST['billstateother'] : '') ?>">
						  <select class="span3" <?= (isset($_POST['billcountry']) && ($_POST['billcountry'] != "US" && $_POST['billcountry'] != "CA") ? 'style="display:none;"' : '') ?> name="billstate" id="billstate">
                            <option value="--" <?= (!isset($_POST['billstate']) || $_POST['billstate'] == '--' ? 'selected' : '') ?>>-- Select State/Province --</option>
<option value="00" <?= (isset($_POST['billstate']) && $_POST['billstate'] == '00' ? 'selected' : '') ?>>Outside USA or Canada</option>
<option value="AB" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'AB' ? 'selected' : '') ?>>Alberta</option>
<option value="AL" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'AL' ? 'selected' : '') ?>>Alabama</option>
<option value="AK" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'AK' ? 'selected' : '') ?>>Alaska</option>
<option value="AZ" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'AZ' ? 'selected' : '') ?>>Arizona</option>
<option value="AR" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'AR' ? 'selected' : '') ?>>Arkansas</option>
<option value="BC" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'BC' ? 'selected' : '') ?>>British Columbia</option>
<option value="CA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'CA' ? 'selected' : '') ?>>California</option>
<option value="CO" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'CO' ? 'selected' : '') ?>>Colorado</option>
<option value="CT" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'CT' ? 'selected' : '') ?>>Connecticut</option>
<option value="DE" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'DE' ? 'selected' : '') ?>>Delaware</option>
<option value="DC" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'DC' ? 'selected' : '') ?>>District Of Columbia</option>
<option value="FL" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'FL' ? 'selected' : '') ?>>Florida</option>
<option value="GA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'GA' ? 'selected' : '') ?>>Georgia</option>
<option value="HI" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'HI' ? 'selected' : '') ?>>Hawaii</option>
<option value="ID" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'ID' ? 'selected' : '') ?>>Idaho</option>
<option value="IL" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'IL' ? 'selected' : '') ?>>Illinois</option>
<option value="IN" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'IN' ? 'selected' : '') ?>>Indiana</option>
<option value="IA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'IA' ? 'selected' : '') ?>>Iowa</option>
<option value="KS" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'KS' ? 'selected' : '') ?>>Kansas</option>
<option value="KY" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'KY' ? 'selected' : '') ?>>Kentucky</option>
<option value="LA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'LA' ? 'selected' : '') ?>>Louisiana</option>
<option value="ME" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'ME' ? 'selected' : '') ?>>Maine</option>
<option value="MD" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MD' ? 'selected' : '') ?>>Maryland</option>
<option value="MA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MA' ? 'selected' : '') ?>>Massachusetts</option>
<option value="MB" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MB' ? 'selected' : '') ?>>Manitoba</option>
<option value="MI" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MI' ? 'selected' : '') ?>>Michigan</option>
<option value="MN" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MN' ? 'selected' : '') ?>>Minnesota</option>
<option value="MS" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MS' ? 'selected' : '') ?>>Mississippi</option>
<option value="MO" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MO' ? 'selected' : '') ?>>Missouri</option>
<option value="MT" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'MT' ? 'selected' : '') ?>>Montana</option>
<option value="NB" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NB' ? 'selected' : '') ?>>New Brunswick</option>
<option value="NE" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NE' ? 'selected' : '') ?>>Nebraska</option>
<option value="NL" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NL' ? 'selected' : '') ?>>Newfoundland and Labrador</option>
<option value="NV" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NV' ? 'selected' : '') ?>>Nevada</option>
<option value="NH" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NH' ? 'selected' : '') ?>>New Hampshire</option>
<option value="NJ" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NJ' ? 'selected' : '') ?>>New Jersey</option>
<option value="NM" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NM' ? 'selected' : '') ?>>New Mexico</option>
<option value="NY" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NY' ? 'selected' : '') ?>>New York</option>
<option value="NC" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NC' ? 'selected' : '') ?>>North Carolina</option>
<option value="ND" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'ND' ? 'selected' : '') ?>>North Dakota</option>
<option value="NS" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NS' ? 'selected' : '') ?>>Nova Scotia</option>
<option value="NT" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NT' ? 'selected' : '') ?>>Northwest Territories</option>
<option value="NU" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'NU' ? 'selected' : '') ?>>Nunavut</option>
<option value="OH" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'OH' ? 'selected' : '') ?>>Ohio</option>
<option value="OK" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'OK' ? 'selected' : '') ?>>Oklahoma</option>
<option value="ON" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'ON' ? 'selected' : '') ?>>Ontario</option>
<option value="OR" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'OR' ? 'selected' : '') ?>>Oregon</option>
<option value="PA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'PA' ? 'selected' : '') ?>>Pennsylvania</option>
<option value="PE" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'PE' ? 'selected' : '') ?>>Prince Edward Island</option>
<option value="QC" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'QC' ? 'selected' : '') ?>>Quebec</option>
<option value="RI" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'RI' ? 'selected' : '') ?>>Rhode Island</option>
<option value="SC" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'SC' ? 'selected' : '') ?>>South Carolina</option>
<option value="SD" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'SD' ? 'selected' : '') ?>>South Dakota</option>
<option value="SK" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'SK' ? 'selected' : '') ?>>Saskatchewan</option>
<option value="TN" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'TN' ? 'selected' : '') ?>>Tennessee</option>
<option value="TX" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'TX' ? 'selected' : '') ?>>Texas</option>
<option value="UT" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'UT' ? 'selected' : '') ?>>Utah</option>
<option value="VT" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'VT' ? 'selected' : '') ?>>Vermont</option>
<option value="VA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'VA' ? 'selected' : '') ?>>Virginia</option>
<option value="WA" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'WA' ? 'selected' : '') ?>>Washington</option>
<option value="WV" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'WV' ? 'selected' : '') ?>>West Virginia</option>
<option value="WI" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'WI' ? 'selected' : '') ?>>Wisconsin</option>
<option value="WY" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'WY' ? 'selected' : '') ?>>Wyoming</option>
<option value="YT" <?= (isset($_POST['billstate']) && $_POST['billstate'] == 'YT' ? 'selected' : '') ?>>Yukon</option>							
                          </select>
						  
                        </div>
                    </div>
                    
                    <!-- Postal Code -->
                    <div class="control-group">
                      <label for="name">Postal Code</label>
                      <input type="text" name="billzip" placeholder="zip code" class="span7" id="zip" value="<?= (isset($_POST['billzip']) ? $_POST['billzip'] : '') ?>">
                    </div>
                    
                    <!-- Country -->
                    <div class="control-group">
                      <label for="name">Country</label>
                      <select class="span7" name="billcountry" id="inputCountry" onChange="getData(this);">
            				<option value="" disabled>-- Select Country --</option>
<option value="AI" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "AI" ? 'selected' : '') ?>>Anguilla</option>
<option value="AG" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "AG" ? 'selected' : '') ?>>Antigua and Barbuda</option>
<option value="AR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "AR" ? 'selected' : '') ?>>Argentina</option>
<option value="AW" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "AW" ? 'selected' : '') ?>>Aruba</option>
<option value="AT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "AT" ? 'selected' : '') ?>>Austria</option>
<option value="BS" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BS" ? 'selected' : '') ?>>Bahamas</option>
<option value="BB" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BB" ? 'selected' : '') ?>>Barbados</option>
<option value="BE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BE" ? 'selected' : '') ?>>Belgium</option>
<option value="BZ" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BZ" ? 'selected' : '') ?>>Belize</option>
<option value="BO" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BO" ? 'selected' : '') ?>>Bolivia</option>
<option value="BR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BR" ? 'selected' : '') ?>>Brazil</option>
<option value="BG" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BG" ? 'selected' : '') ?>>Bulgaria</option>
<option value="CA" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CA" ? 'selected' : '') ?>>Canada</option>
<option value="KY" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "KY" ? 'selected' : '') ?>>Cayman Islands</option>
<option value="CL" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CL" ? 'selected' : '') ?>>Chile</option>
<option value="CO" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CO" ? 'selected' : '') ?>>Colombia</option>
<option value="CR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CR" ? 'selected' : '') ?>>Costa Rica</option>
<option value="HR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "HR" ? 'selected' : '') ?>>Croatia</option>
<option value="CU" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CU" ? 'selected' : '') ?>>Cuba</option>
<option value="CW" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CW" ? 'selected' : '') ?>>Curacao</option>
<option value="CY" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CY" ? 'selected' : '') ?>>Cyprus</option>
<option value="CZ" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CZ" ? 'selected' : '') ?>>Czech Republic</option>
<option value="DK" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "DK" ? 'selected' : '') ?>>Denmark</option>
<option value="DM" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "DM" ? 'selected' : '') ?>>Dominica</option>
<option value="DO" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "DO" ? 'selected' : '') ?>>Dominican Republic</option>
<option value="EC" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "EC" ? 'selected' : '') ?>>Ecuador</option>
<option value="SV" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "SV" ? 'selected' : '') ?>>El Salvador</option>
<option value="EE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "EE" ? 'selected' : '') ?>>Estonia</option>
<option value="FK" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "FK" ? 'selected' : '') ?>>Falkland Islands</option>
<option value="FI" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "FI" ? 'selected' : '') ?>>Finland</option>
<option value="FR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "FR" ? 'selected' : '') ?>>France</option>
<option value="GF" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GF" ? 'selected' : '') ?>>French Guiana</option>
<option value="DE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "DE" ? 'selected' : '') ?>>Germany</option>
<option value="GR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GR" ? 'selected' : '') ?>>Greece</option>
<option value="GD" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GD" ? 'selected' : '') ?>>Grenada</option>
<option value="GP" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GP" ? 'selected' : '') ?>>Guadeloupe</option>
<option value="GT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GT" ? 'selected' : '') ?>>Guatemala</option>
<option value="GY" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GY" ? 'selected' : '') ?>>Guyana</option>
<option value="HT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "HT" ? 'selected' : '') ?>>Haiti</option>
<option value="HN" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "HN" ? 'selected' : '') ?>>Honduras</option>
<option value="HU" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "HU" ? 'selected' : '') ?>>Hungary</option>
<option value="IS" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "IS" ? 'selected' : '') ?>>Iceland</option>
<option value="IE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "IE" ? 'selected' : '') ?>>Ireland</option>
<option value="IL" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "IL" ? 'selected' : '') ?>>Israel</option>
<option value="IT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "IT" ? 'selected' : '') ?>>Italy</option>
<option value="JM" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "JM" ? 'selected' : '') ?>>Jamaica</option>
<option value="JP" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "JP" ? 'selected' : '') ?>>Japan</option>
<option value="LV" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "LV" ? 'selected' : '') ?>>Latvia</option>
<option value="LI" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "LI" ? 'selected' : '') ?>>Liechtenstein</option>
<option value="LT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "LT" ? 'selected' : '') ?>>Lithuania</option>
<option value="LU" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "LU" ? 'selected' : '') ?>>Luxembourg</option>
<option value="MT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "MT" ? 'selected' : '') ?>>Malta</option>
<option value="MQ" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "MQ" ? 'selected' : '') ?>>Martinique</option>
<option value="MX" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "MX" ? 'selected' : '') ?>>Mexico</option>
<option value="MS" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "MS" ? 'selected' : '') ?>>Montserrat</option>
<option value="NL" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "NL" ? 'selected' : '') ?>>Netherlands</option>
<option value="NI" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "NI" ? 'selected' : '') ?>>Nicaragua</option>
<option value="NO" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "NO" ? 'selected' : '') ?>>Norway</option>
<option value="PA" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "PA" ? 'selected' : '') ?>>Panama</option>
<option value="PY" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "PY" ? 'selected' : '') ?>>Paraguay</option>
<option value="PE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "PE" ? 'selected' : '') ?>>Peru</option>
<option value="PL" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "PL" ? 'selected' : '') ?>>Poland</option>
<option value="PT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "PT" ? 'selected' : '') ?>>Portugal</option>
<option value="PR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "PR" ? 'selected' : '') ?>>Puerto Rico</option>
<option value="RO" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "RO" ? 'selected' : '') ?>>Romania</option>
<option value="RU" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "RU" ? 'selected' : '') ?>>Russian Federation</option>
<option value="BL" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "BL" ? 'selected' : '') ?>>Saint Barthelemy</option>
<option value="KN" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "KN" ? 'selected' : '') ?>>Saint Kitts and Nevis</option>
<option value="LC" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "LC" ? 'selected' : '') ?>>Saint Lucia</option>
<option value="MF" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "MF" ? 'selected' : '') ?>>Saint Martin</option>
<option value="VC" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "VC" ? 'selected' : '') ?>>Saint Vincent and the Grenadines</option>
<option value="SX" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "SX" ? 'selected' : '') ?>>Sint Maarten</option>
<option value="SK" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "SK" ? 'selected' : '') ?>>Slovakia</option>
<option value="SI" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "SI" ? 'selected' : '') ?>>Slovenia</option>
<option value="GS" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GS" ? 'selected' : '') ?>>South Georgia and the South Sandwich Islands</option>
<option value="ES" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "ES" ? 'selected' : '') ?>>Spain</option>
<option value="SR" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "SR" ? 'selected' : '') ?>>Suriname</option>
<option value="SE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "SE" ? 'selected' : '') ?>>Sweden</option>
<option value="CH" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "CH" ? 'selected' : '') ?>>Switzerland</option>
<option value="TT" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "TT" ? 'selected' : '') ?>>Trinidad and Tobago</option>
<option value="TC" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "TC" ? 'selected' : '') ?>>Turks and Caicos Islands</option>
<option value="UA" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "UA" ? 'selected' : '') ?>>Ukraine</option>
<option value="GB" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "GB" ? 'selected' : '') ?>>United Kingdom</option>
<option value="US" <?= (!isset($_POST['billcountry']) || $_POST['billcountry'] == "US" ? 'selected' : '') ?>>United States</option>
<option value="UY" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "UY" ? 'selected' : '') ?>>Uruguay</option>
<option value="VE" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "VE" ? 'selected' : '') ?>>Venezuela</option>
<option value="VG" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "VG" ? 'selected' : '') ?>>Virgin Islands, British</option>
<option value="VI" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == "VI" ? 'selected' : '') ?>>Virgin Islands, U.S.</option>
							
<!--							<option value="00" <?= (isset($_POST['billcountry']) && $_POST['billcountry'] == '00' ? 'selected' : '') ?>>-- Other country --</option> -->
            			</select>
                    </div>


<!--
                    <hr />

                    <div class="form-group">
                    	<div class="">
                    		<div class="checkbox">
                    			<label>
                    				<input type="checkbox"> Accept Terms &amp; Conditions
                    			</label>
                    		</div>
                    	</div>
                    </div>
-->
                    <div class="form-group">
                    	<div class="">
                    		<button type="submit" class="btn btn-success"><i class="icon-lock icon-white"></i> Pay Securely Now</button>&nbsp;
                    	</div>
                    </div>
                    <p>&nbsp;</p>
                    <!-- END -->

</form>                    
                </div>
            </div>
        </div>
        <div class="accordion-group" style="text-align:left">
            <div class="accordion-heading">
                <a href="#collapseThree" data-parent="#myAccordion" data-toggle="collapse" class="accordion-toggle">3. Pay by Phone</a>
            </div>
            <div class="accordion-body collapse" id="collapseThree">
                <div class="accordion-inner">
                    <p>If you wish to call us, we can take your order over the phone. Available from Monday to Friday during normal business hours, 9:00 a.m. to 6:00 p.m.<p> 
                    <p>Please call <span itemprop="telephone"><a href="tel:+18443786877">+1 844-378-6877</a></span> in the USA &amp; Canada<br/>Please call <span itemprop="telephone"><a href="tel:+18298681353">+1829-868-1353</a></span> in the Dominican Republic and other countries</p>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
</div>
<?php } ?>

<div class="clearfix"></div>
<p>&nbsp;</p> 
<p class="muted">To ensure the highest level of security, we use 256-bit SSL/TLS encryption exclusively.</p>



		  
		  <!-- Stage 4 Content -->

		  
		  <!-- Stage 5 Content -->

		  
        </section><!-- /main_body -->
      </div> <!-- /span8 (left column) -->

  <?php include_once("inc/analyticstracking.php") ?>	
  <?php require_once 'inc/sidebar-checkout.php'; ?>
    </div><!-- /row -->
  </div><!-- /container -->

  <?php require_once 'inc/footer-checkout.php'; ?>
