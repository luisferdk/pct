<?php require_once 'inc/config.php'; ?>
<?php require_once 'inc/cart-manager.php'; ?>
<?php require_once 'inc/meta.php'; ?>
<?php require_once 'inc/header.php'; ?>
<?php
 $transfer = $_POST['transfer'];
 $pax = $_POST['pax'];
 $airport = $_POST['airport'];
 $hotel = $_POST['hotel'];
 
 $sql = "SELECT hotels.hotel_name, hotels.hotel_location,transfers.airport, transfers.oneway, transfers.roundtrip 
   FROM transfers, hotels 
   WHERE hotels.hotel_id = transfers.hotel_id 
   AND transfers.airport = '$airport' 
   AND transfers.hotel_id = '$hotel'";
 $res = mysql_query($sql) or die(mysql_error());
  while($row = MYSQL_FETCH_ARRAY($res))
  {
    $oneway=$row['oneway'];
    $roundtrip=$row['roundtrip'];
    $hotel_name=$row['hotel_name'];
  }
  
  $sql2 = "select * FROM airlines ORDER BY airline_name";
  $res2 = mysql_query($sql2) or die(mysql_error());
  while($row = MYSQL_FETCH_ARRAY($res2))
  {
    $airline[] = $row['airline_name'];
  } ?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="index.php">Home</a> <span class="divider">></span></li>
    <li><a href="transportation.php">Transportation</a> <span class="divider">></span></li>
    <li class="active">Free Quote</li>
  </ul>
  <div class="row">
    <div class="span8">
      
      <!-- Main Content
      ================================================== -->
      <section class="main_body">
        <h1>Airport Transfer Quote</h1>
        <div style="margin-bottom:30px">
          <h4>Total Price for <u>ALL</u> <?php echo $pax; ?> Passenger(s)
          <?php
          switch($transfer){
            case 1;
            echo "<b class=\"text-success\" style=\"font-size:1.4em\"> $".$roundtrip.".00</b></h4>";
            break;
            case 2;
            echo "<b class=\"text-success\" style=\"font-size:1.4em\"> $".$oneway.".00</b></h4>";
            break;
            case 3;
            echo "<b class=\"text-success\" style=\"font-size:1.4em\"> $".$oneway.".00</b></h4>";
            break;
          } ?>
          <p>&nbsp;</p>
          <p class="muted">Step 2 of 2</p>
          <div class="progress progress-striped active">
            <div class="bar" style="width: 100%;"></div>
          </div>
          <p><strong>To reserve your transfer please fill out the following details</strong></p>
          <p><em style="font-size:.9em">This is a private transfer in a non-shared late model vehicle. After you reserve your transfer, we will send you a voucher which you will present to your driver.</em></p>
          <p>&nbsp;</p>
          <form method="post" action="checkout.php">
			<input type="hidden" name="action" value="addPickupToCart">
            <input type="hidden" name="transfer" value="<?php echo $transfer; ?>">
            <input type="hidden" name="passenger_count" value="<?php echo $pax; ?>">
            <input type="hidden" name="airport" value="<?php echo $airport; ?>">
            <input type="hidden" name="hotel" value="<?php echo $hotel_name; ?>">
            <input type="hidden" name="roundtrip" value="<?php echo $roundtrip; ?>">
            <input type="hidden" name="oneway" value="<?php echo $oneway; ?>">
          
            <?php
            switch($transfer){
              case 1;
              ?>
              <div class="row">
                <div class="span4">
                  <p>----- Arrival Information -----</p>
                  <label>Date</label>
                  <input type="text" class="hasDatepicker datepicker readonly span3" style="cursor:default;" title="Please click here to select the date" rel=tooltip name="adate" value="" required>

				  <label>Arrival Time</label>
				  <input type="text" class="inline input-mini" name="ahour" value="HH" maxlength="2" required>:<input type="text" class="inline input-mini" name="amin" value="mm" maxlength="2" required>
				  <select id="atod" required class="inline input-mini" name="atod">
					<option value="am" selected>AM</option>
					<option value="pm">PM</option>
				  </select>
				  
                  <label>Airline</label>
                  <select id="aairline" name="aairline" data-placeholder="Choose your airline" class="chzn-select span3" data-required="true">
                    <option value=""></option>
                    <?php createDropdown($airline); ?>
                  </select>

                  <label>Flight #</label>
                  <input type="text" class="span3" name="aflight" value="" required>

                </div><!--/span4-->
                <div class="span4">
                  <p>----- Departure Information -----</p>
                  <label>Date</label>
                  <input type="text" class="hasDatepicker datepicker readonly span3" style="cursor:default;" title="Please click here to select the date" rel=tooltip name="ddate" value="" required>

				  <label>Departure Time</label>
				  <input type="text" class="inline input-mini" name="dhour" value="HH" maxlength="2" required>:<input type="text" class="inline input-mini" name="dmin" value="mm" maxlength="2" required>
				  <select id="dtod" required class="inline input-mini" name="dtod">
					<option value="am" selected>AM</option>
					<option value="pm">PM</option>
				  </select>
				  
                  <label>Airline</label>
                  <select id="dairline" name="dairline" data-placeholder="Choose your airline" class="chzn-select span3" data-required="true">
                    <option value=""></option>
                    <?php createDropdown($airline); ?>
                  </select>

                  <label>Flight #</label>
                  <input type="text" class=" span3" name="dflight" value="" required>
                </div><!--/span4-->
              </div><!--/row-->
              <?php
              break;
              case 2;
              ?>
              <div class="row">
                <div class="span4">
                  <p>----- Arrival Information -----</p>
                  <label>Date</label>
                  <input type="text" class="datepicker span3" name="adate" value="" required>
				  
				  <label>Time</label>
				  <input type="text" class="inline input-mini" name="ahour" value="HH" maxlength="2" required>:<input type="text" class="inline input-mini" name="amin" value="mm" maxlength="2" required>
				  <select id="atod" required class="inline input-mini" name="atod">
					<option value="am" selected>AM</option>
					<option value="pm">PM</option>
				  </select>
				  
                  <label>Airline</label>
                  <select id="aairline" name="aairline" data-placeholder="Choose your airline" class="chzn-select span3" data-required="true">
                    <option value=""></option>
                    <?php createDropdown($airline); ?>
                  </select>

                  <label>Flight #</label>
                  <input type="text" class="span3" name="aflight" value="" required>
                </div><!--/span4-->
               </div><!--/row-->
              <?php
              break;
              case 3;
              ?>
              <div class="row">
                <div class="span4">
                  <p>----- Departure Information -----</p>
                  <label>Date</label>
                  <input type="text" class="datepicker span3" name="ddate" value="" required>

				  <label>Time</label>
				  <input type="text" class="inline input-mini" name="dhour" value="HH" maxlength="2" required>:<input type="text" class="inline input-mini" name="dmin" value="mm" maxlength="2" required>
				  <select id="dtod" required class="inline input-mini" name="dtod">
					<option value="am" selected>AM</option>
					<option value="pm">PM</option>
				  </select>
				  
                  <label>Airline</label>
                  <select id="dairline" name="dairline" data-placeholder="Choose your airline" class="chzn-select span3" data-required="true">
                    <option value=""></option>
                    <?php createDropdown($airline); ?>
                  </select>

                  <label>Flight #</label>
                  <input type="text" class="span3" name="dflight" value="" required>
                </div><!--/span4-->
               </div><!--/row-->
              <?php
              break;
            } ?>
          <hr />
          
          <label>Comments or Questions</label>
          <textarea type="text" class="span7" rows="4" name="comments" value=""></textarea>
          <br />
		  <input type="submit" class="btn btn-success pull-left" value="Add to Cart" />
          
        </div>
      </section><!-- /main_body -->
    </div> <!-- /span8 (left column) -->

<?php require_once 'inc/sidebar_tour.php'; ?>
  </div><!-- /row -->
<div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>
