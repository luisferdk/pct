<?php require_once 'inc/config.php'; ?>
<?php require_once 'inc/cart-manager.php'; ?>
<?php require_once 'inc/meta.php'; ?>
<?php require_once 'inc/header.php'; ?>
<?php $tour = (isset($_POST['tour']) ? $_POST['tour'] : '(undefined)'); ?>

<div class="container">
  <div class="row">
    <div class="span8">
      
        <!-- Main Content
           ================================================== -->
           <section class="main_body">
             <h1>Contact Us</h1>
    <p>We love to hear from our past clients and soon to be friends.  Whatever your question or concern may be, let us know.  We will get back to you in a very timely manner.</p> 

            <?php
            $fullpath = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
            if(isset($_POST['send'])) 
            { 
              $firstname = $_POST['first_name'];
              $lastname = $_POST['last_name'];
              $name = $firstname." ".$lastname;
              $email = $_POST['email'];
              $phone = $_POST['phone'];
              $msg = $_POST['msg'];
              $tour = $_POST['tour'];
$items = "Items in Cart:\r\n";
foreach($_SESSION["cart"] as $item_id => $item) { 
   $items .= "-- ".$item["name"]."\r\n";
}
			  
              $ToEmail = 'support@caribbeandreamto.com';
              //$ToEmail = 'kharr212@gmail.com'; 
              $EmailSubject = 'Punta Cana Tours Form'; 
              $mailheader = "From: ".$name." <".$email.">\r\n"; 
			  $mailheader .= 'Reply-To: '.$name.' <'.$email.'>'."\r\n";
              //$mailheader .= "Bcc: ealexnet@yandex.ru\r\n";
			  $mailheader .= 'Content-Type: text/plain'."\r\n";
			  $mailheader .= 'X-Mailer: PHP/' . phpversion()."\r\n";
              
              $message_body = "Name: ".$name."\r\n"; 
              $message_body .= "Email: ".$email."\r\n";
              $message_body .= "Phone: ".$phone."\r\n";

$message_body .= "\r\nTour: ".$tour."\r\n";
$message_body .= $items."\r\n";

              $message_body .= "Comment: ".nl2br($msg)."\r\n\r\n"; 
              $message_body .= "Sent from: http://".$fullpath."";
                
              mail($ToEmail, $EmailSubject, $message_body, $mailheader) or die ("Failure");
//              mail($ToEmail, $EmailSubject, $message_body, $mailheader, "-f $email") or die ("Failure");
             echo "<h2 style=\"margin-top:30px;\">Thanks ".$firstname."</h2>";
             echo "<p>We have received your request and we will
             be contacting you shortly. PLEASE check your SPAM folder if you do not see a response.</p>"; 
            } else { ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off">
 	<input type="hidden" name="tour" value="<?= $tour ?>">

    <fieldset>
        <legend>Personal Information</legend>
    	<div class="row-fluid">
    	  <div class="span6">
    		<label>First Name</label>
    		<input type="text" name="first_name" value="" required>
    	  </div>
    	  <div class="span6">
    		<label>Last Name</label>
    		<input type="text" name="last_name" value="">
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
    </fieldset>

    <fieldset>
    <legend>Questions or Comments</legend>
        <div class="control-group">
            <div class="controls">
              <textarea class="span7" rows="3" name="msg" required></textarea>
            </div>
        </div>

    	<input type="submit" name="send" value="Send Message" class="pull-left btn btn-success"/>
    	<div class="clearfix"></div>
    </fieldset>
    </form>
            <?php }?>

          </section><!-- /main_body -->
        </div> <!-- /span8 (left column) -->

    <?php require_once 'inc/sidebar_tour.php'; ?>
  </div><!-- /row -->
</div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>
