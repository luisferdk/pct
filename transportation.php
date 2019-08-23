<?php require_once 'inc/config.php'; 
require_once 'inc/cart-manager.php';
require_once 'inc/meta.php';
require_once 'inc/header.php'; ?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/">Home</a> <span class="divider">></span></li>
    <li class="active">Transportation</li>
  </ul>
  <div class="row">
    <div class="span8">
      
      <!-- Main Content
      ================================================== -->
      <section class="main_body">
        <h1>Transportation</h1>
        <div style="margin-bottom:30px">
          <p>Caribbean Dream provides airport transfer services from Punta Cana International Airport to and from all Punta Cana resorts. We also offer transfer options to major airport and cruise ports throughout the Dominican Republic. We provide tour operators, travel agents and individuals with a comprehensive range of transfers at reasonable rates</p>

          <p>If you are a tour operator or travel agent, have a party of 7 or more, or do not see your required transport on our drop down menu please contact us directly. Otherwise, you may book your transportation by simply filling out the form below.</p>
          <h2>Free Airport Transfer Quote</h2>
          <p>&nbsp;</p>
          <p class="muted">Step 1 of 2</p>
          <div class="progress progress-striped active">
            <div class="bar" style="width: 50%;"></div>
          </div>
          <form method="post" action="/airport-transfer-quote.php">
          <label>Type of Transfer</label>
          <label class="radio">
            <input type="radio" name="transfer" value="1" checked>
            Round Trip
          </label>
          
          <label class="radio">
            <input type="radio" name="transfer" value="2">
            One Way (Arrival)
          </label>
          
          <label class="radio">
            <input type="radio" name="transfer" value="3">
            One Way (Departure)
          </label>
          
          <label>Passengers</label>
          <select name="pax" data-placeholder="Passengers"  class="input-xlarge chosen-select" data-required="true">
            <option value=""></option>
            <option value="1">1</option>
            <option value="2" selected>2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          
          <label>Airport</label>
          <select name="airport" data-placeholder="What Airport"  class="input-xlarge chosen-select" data-required="true">
            <option value=""></option>
            <option value="puj" selected>Punta Cana (PUJ)</option>
            <option value="lrm">La Romana (LRM)</option>
            <option value="sdq">Santo Domingo (SDQ)</option>
          </select>
          
          <label>Hotel</label>
			<?php
				showHotelPicker("hotel");
			?>

          <br /><br />
          <button type="submit" class="pull-left btn btn-success">Next</button>
        </form>
        
        </div>
      </section><!-- /main_body -->
    </div> <!-- /span8 (left column) -->

<?php require_once 'inc/sidebar_tour.php'; ?>
  </div><!-- /row -->
</div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>
