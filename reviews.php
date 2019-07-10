<?php require_once 'inc/config.php'; ?>
<?php require_once 'inc/cart-manager.php'; ?>
<?php require_once 'inc/meta.php'; ?>
<?php require_once 'inc/header.php'; ?>

<?
$msg = '';
$msgform = '';
$show_form = "";
if(isset($_GET['thankyou']))
   {
   $msg = '<center><hr><strong>THANK YOU FOR SUBMITTING YOUR REVIEW!</strong><hr></center><br>';
   unset($_SESSION['c_error']);
   unset($_SESSION["review_form"]);
   }
elseif(isset($_GET['sorry']))
   {
   if($_SESSION['c_error'] == 1)
      $msgform = '<center><hr><strong><font color="red">Security code invalid</font></strong><br>Please try again<hr></center>';
   elseif($_SESSION['c_error'] == 2)
      $msgform = '<center><hr><strong><font color="red">All fields are required!</font></strong><br>Please try again<hr></center>';
   else
      $msgform = '<center><hr><strong><font color="red">Email looks invalid</font></strong><br>Please try again<hr></center>';
   unset($_SESSION['c_error']);
	$show_form = "in";
	}
?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/">Home</a> <span class="divider">></span></li>
    <li class="active">Reviews</li>
  </ul>
  <div class="row">
    <div class="span8">
      
      <!-- Main Content
      ================================================== -->
      <section class="main_body">
	  <?= $msg ?>
        <h1>Reviews of Punta Cana Tours</h1>
        <div class="row">
          <div class="span4">
            <div id="TA_cdswritereviewlg816" class="TA_cdswritereviewlg">
              <ul id="QzYTOxkTieXu" class="TA_links FU8Rig">
                <li id="T6T8AFR3Zvo" class="Wo0fzsa5DV">Review <a href="http://www.tripadvisor.com/Attraction_Review-g147293-d2073653-Reviews-Caribbean_Dream_Private_Tours-Punta_Cana_La_Altagracia_Province_Dominican_Republi.html">Caribbean Dream - Private Tours</a></li>
              </ul>
            </div>
<!--			<script src="http://www.tripadvisor.com/WidgetEmbed-cdswritereviewlg?amp;uniq=816&amp;lang=en_US&amp;border=true&amp;locationId=2073653"></script> -->
            <script src="http://www.jscache.com/wejs?wtype=cdswritereviewlg&amp;uniq=816&amp;locationId=2073653&amp;lang=en_US&amp;border=true"></script>
          </div> <!--/span4 -->
		<div class="row">
          <div class="span4">
            <h3>Leave us your review!</h3>
            <p>We don't invest a penny on advertising. Our business has grown from word of mouth and customer reviews. If you'd like to spare a few moments of your time to leave us quick review on TripAdvisor, it'd be greatly appreciated! It only takes a few minutes.</p>
            <p>Below, you can read what other customers have said about their experience with Caribbean Dream.  We hope you&#8217;ll be next.<br />
          </div>
		</div>


<div class="box span8">
<div class="box-content">
	<p>&nbsp;</p>
<table class="table" id="example">
	<thead>
		<tr>
			<th></th>
		</tr>
	</thead>   
	<tbody>
<?php
$sql = "select * FROM reviews_v2 
WHERE review_language = 1     /*Language is English*/
AND review_status = 1         /*Review has been approved*/
ORDER BY review_date DESC";
$res = mysql_query($sql) or die(mysql_error());
while($row = MYSQL_FETCH_ARRAY($res))
{
  $review_id = $row['review_id'];
  $review_title = $row['review_title'];
  $review_desc = $row['review_desc'];
  $review_author = $row['review_author'];
  $review_email = $row['review_email'];
  $review_language = $row['review_language'];
  $review_category = $row['review_category'];
  $review_rating = $row['review_rating'];
  $review_date = $row['review_date'];
  $review_status = $row['review_status'];  
?>
		<tr><td>
			<h3><?php echo $review_title; ?></h3>
			<small style="padding-left:10px"> by <?php echo $review_author; ?> <?php echo $review_date; ?></small>
			<div class="revstar pull-left" data-score="<?= $review_rating ?>"></div>
			<blockquote><em><?php echo $review_desc; ?></em></blockquote>
<?php };?>
		</td></tr>
	</tbody>
</table>            
</div><!-- box content -->
</div><!--/span box span8 -->


</div>

<a name="show_form"></a>
<p>&nbsp;</p>
        <button class="btn btn-success" data-toggle="collapse" data-target="#review">
          Click Here to Submit Your Review
        </button>
 
        <div id="review" class="collapse <?= $show_form ?>">
 <?= $msgform ?>		
          <form class="form-horizontal" action="/submitreview.php" method="POST" style="margin-top:20px">
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span><input id="name" name="name" type="text" value="<?= (isset($_SESSION["review_form"]["name"]) ? $_SESSION["review_form"]["name"] : "") ?>">
                  </div>
                  <br>Please enter your name
                </div>
              </div>
      
              <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span><input id="email" name="email" type="email" value="<?= (isset($_SESSION["review_form"]["email"]) ? $_SESSION["review_form"]["email"] : "") ?>">
                  </div>
                  <p class="help-inline">Your email address (never displayed)</p>
                </div>
              </div>
      
              <div class="control-group">
                <label class="control-label" for="title">Title</label>
                <div class="controls">
                  <div class="input-prepend">
                    <span class="add-on"><i class="icon-text-width"></i></span><input id="title" name="title" type="text" value="<?= (isset($_SESSION["review_form"]["title"]) ? $_SESSION["review_form"]["title"] : "") ?>">
                  </div>
                  <p class="help-inline">Please give your review a title</p>
                </div>
              </div>
      
              <div class="control-group span4">
                <label class="control-label" for="rating">Rating</label>
                <div class="star pull-right" data-score="<?= (isset($_SESSION["review_form"]["score"]) ? $_SESSION["review_form"]["score"] : "4") ?>"></div>
              </div>
      
              <div class="control-group span4">
                <label class="control-label" for="review">Review</label>
                <div class="controls">
                  <textarea  id="review" name="review" placeholder=""><?= (isset($_SESSION["review_form"]["review"]) ? $_SESSION["review_form"]["review"] : "") ?></textarea>
                </div>
              </div>
      
              <div class="control-group span4">
                <label class="control-label" for="captcha">Protection</label>
                <div class="controls" style="width: 220px;">
					   <img src="/captcha/server.php" onClick="javasript:this.src='/captcha/server.php?'+Math.random();" alt="CAPTCHA image">
						<br>
						<input id="captcha" name="captcha" type="text">
						<br>Please enter the four characters that appear in the image
                </div>
              </div>
	  
            </fieldset>
            <button class="btn btn-success">Submit your review</button>
          </form>
        </div>

</section><!-- /main_body -->
<!-- <img src="/img/variable_ad_footer.png" alt="Variable Advert Footer" /> -->
</div> <!-- /span8 (left column) -->

<?php require_once 'inc/sidebar_tour.php'; ?>
</div><!-- /row -->
</div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>
