<?php
$start = microtime(true);
require_once 'inc/config.php';
require_once 'inc/cart-manager.php';

$uri = explode('/', $_SERVER['REQUEST_URI']);
if(sizeof($uri) > 1 && !empty($uri[1])) {
	$page = $uri[1];

$show_products_new = 1;
	
/*	
$test = explode('-', $page);
$ctest = count($test);
if($test[$ctest-1] == 'new')
    {
	$show_products_new = 1;
	array_pop($test);
	$page = implode('-', $test);
	}

$googletest = '';	
if($show_products_new != 1)
   {
   if($page == 'zipline-hoyo-azul')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-0',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   elseif($page == 'saona-island')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-1',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   elseif($page == 'catamaran-sailing')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-2',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   elseif($page == 'jeep-safari')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-3',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   elseif($page == 'santo-domingo-tour')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-4',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   elseif($page == 'marinarium-snorkeling-cruise')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-5',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   elseif($page == 'horseback-riding')
      {
$googletest = <<<EOD
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='45154285-6',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->

EOD;
	  }

   }
*/
   
// -------------------------------------------------
// GALLERY FIX from MalibuPartyBoat
// Clean up the $page variable here!!!
// Allow only a-z, A-Z, 0-9 and dash
$page = preg_replace ("/[^a-zA-Z0-9\-]/","",$page);
// -------------------------------------------------

// Get this website id
$ws_url = strtolower($_SERVER['HTTP_HOST']);
$sql = "select * FROM websites WHERE ws_url = '$ws_url'";
$res = mysql_query($sql) or die(mysql_error());
while($row = MYSQL_FETCH_ARRAY($res))
{
  $v_site = $row['id'];
} 

$error404 = true;
	
$sql = "select * FROM $toursTable 
  WHERE t_url = '$page' and v_site='$v_site'";
$res = mysql_query($sql) or die(mysql_error());
while($row = MYSQL_FETCH_ARRAY($res))
{
  $error404 = false;
  
  $tour_id = $row['t_id'];
  $tour_name = $row['t_name'];
  $tour_url = $row['t_url'];
  $tour_desc_meta = $row['t_desc_meta'];
  $tour_desc_excerpt = $row['t_desc_excerpt'];
  $tour_desc_mobile = $row['t_desc_mobile'];
  $tour_desc = $row['t_desc'];
  $tour_included = $row['t_included'];
  $tour_not_included = $row['t_not_included'];
  $tour_times = $row['t_times'];
  $tour_days = $row['t_days'];
  $tour_duration = $row['t_duration'];
  $tour_additional = $row['t_additional'];
  $tour_thumbnail = $row['t_thumbnail'];
  $tour_photo = $row['t_photo'];
  $tour_video = $row['t_video'];
  $tour_status = $row['t_status'];
// -------------------------------------------------
// GALLERY FIX
// Get gallery ID
  $tour_gallery = $row['t_gallery'];
// ------------------------------------------------- 
// AVAILABILITY FIX
  $t_wdays = str_split($row['t_wdays']);
  $arr_days = array();
  
  $i = 0;
  if($t_wdays[0] == '1')
	  { $arr_days[$i] = 'Mon'; $i++; } 
  if($t_wdays[1] == '1')
	  { $arr_days[$i] = 'Tue'; $i++; } 
  if($t_wdays[2] == '1')
	  { $arr_days[$i] = 'Wed'; $i++; } 
  if($t_wdays[3] == '1')
	  { $arr_days[$i] = 'Thu'; $i++; } 
  if($t_wdays[4] == '1')
	  { $arr_days[$i] = 'Fri'; $i++; } 
  if($t_wdays[5] == '1')
	  { $arr_days[$i] = 'Sat'; $i++; } 
  if($t_wdays[6] == '1')
	  { $arr_days[$i] = 'Sun'; $i++; } 

$arr_c = count($arr_days) - 1;	  
array_unshift($arr_days, $arr_days[$arr_c]);
$dummy = array_pop($arr_days);
	  
  $tour_days = implode(', ', $arr_days);

  
// Change datepicker settings
/*
echo '<!--';
print_r($t_wdays);
echo '-->';  
array_unshift($t_wdays, $t_wdays[6]);
$dummy = array_pop($t_wdays);
echo '<!--';
print_r($t_wdays);
echo '-->';  
*/
array_unshift($t_wdays, $t_wdays[6]);
$dummy = array_pop($t_wdays);

  $arr_days = array();
  
  $i = 0;
  if($t_wdays[0] == '0')
	  { $arr_days[$i] = '0'; $i++; } 
  if($t_wdays[1] == '0')
	  { $arr_days[$i] = '1'; $i++; } 
  if($t_wdays[2] == '0')
	  { $arr_days[$i] = '2'; $i++; } 
  if($t_wdays[3] == '0')
	  { $arr_days[$i] = '3'; $i++; } 
  if($t_wdays[4] == '0')
	  { $arr_days[$i] = '4'; $i++; } 
  if($t_wdays[5] == '0')
	  { $arr_days[$i] = '5'; $i++; } 
  if($t_wdays[6] == '0')
	  { $arr_days[$i] = '6'; $i++; } 
  
  $daysOfWeekDisabled = implode(',', $arr_days);

//$daysOfWeekDisabled = implode(',', $t_wdays);
// ------------------------------------------------- 
} 
  if($error404 == true) {
	// 404 Error Page Here
header( 'Location: /' );
return;
	
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
  <head>
<?
if($googletest)
   {
   echo $googletest;
//readfile($googletest);   
   }
?>  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php if(!$error404){echo $tour_desc_meta;}?>" />
  <meta name="keywords" content="excursions, tours, punta cana, dominican, vacation, tour operator" />
  <meta name="robots" content="index, follow" />
  <meta name="geo.region" content="DO-11" />
  <meta name="geo.placename" content="Punta Cana" />
  <meta property="og:title" content="<?php echo nl2br($tour_name);?>" />
  <meta property="og:type" content="product" />
  <meta property="og:price:amount" content="varies" />
  <meta property="og:price:currency" content="USD" />
  <title><?php if(!$error404){echo nl2br($tour_name);} ?> | Punta Cana Tours and Excursions</title>
  <link rel="canonical" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>">
  <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en" />
  <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en-us" />
  <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en-ca" />
  <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en-do" />
  <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="x-default" />
  <link href="/css/compress.min.css" rel="stylesheet">
   <!--[if lt IE 9]>
         <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
       <![endif]-->
   <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
   <!-- Facebook Pixel Code -->
   <script>
   !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
   n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
   n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
   t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
   document,'script','https://connect.facebook.net/en_US/fbevents.js');

   fbq('init', '276559712701569');
   fbq('track', "PageView");</script>
   <noscript><img height="1" width="1" style="display:none"
   src="https://www.facebook.com/tr?id=276559712701569&ev=PageView&noscript=1"
   /></noscript>
   <!-- End Facebook Pixel Code -->
  </head>
<body onload itemscope itemtype="http://schema.org/WebPage">
  <?php 
require_once 'inc/analyticstracking.php';
require_once 'inc/header.php'; 
  
  if($error404 == true) {
	// 404 Error Page Here
  ?>
  
	<div class="container">
		<h2>Error: Page Not Found</h2>
		<p>Click <a href="/">here</a> to return Home</p>
	</div>
</body>

  <?php
	return;
  }
  ?>
 
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="/">Home</a> <span class="divider">></span></li>
      <li><a href="/excursions/all-tours/">Excursions</a> <span class="divider">></span></li>
      <li class="active"><?php echo nl2br($tour_name); ?></li>
    </ul>
    <div class="row">
      <div class="span8">

        <!-- Main Content
        ================================================== -->
        <section class="main_body">
          <h1><?php echo nl2br($tour_name); ?></h1>
		<?php if($tour_video != "") { ?>
			<div class="video-container">
<div id="player" name="<?= nl2br($tour_name) ?>"></div>	
<!--		
				<iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $tour_video; ?>?rel=0&#038;autohide=1&#038;hd=1&#038;iv_load_policy=3&#038;wmode=transparent&#038;modestbranding=1&#038;autoplay=0"></iframe>
-->				
			</div>
		<?php } else { ?>
			<div class="gallery">
				<img src="<?php echo constant("CATEGORY_IMAGE_DIR"); echo nl2br($tour_photo); ?>" alt="<?php echo nl2br($tour_name); ?>">
			</div>
		<?php }?>
          

          <h2>Description</h2>
          <p><?php echo nl2br($tour_desc); ?></p>
          <div class="row">
            <div class="span4">

              <h3>Included</h3>
              <ul class="check_list">
              <?php echo '<li>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li>"),trim($tour_included,"\n\r")).'</li>';?>
              </ul>

              <h3>Not Included</h3>
              <ul class="check_list">
              <?php echo '<li>'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li>"),trim($tour_not_included,"\n\r")).'</li>';?>
              </ul>
            </div>

            <div class="span4">
              <h3>Duration</h3>
              <p><?php echo nl2br($tour_duration); ?></p>
              
              <h3>Hours</h3>
              <p><?php echo nl2br($tour_times); ?><br /><br /><em>"Pickup times and locations vary depending on the hotel you are staying at. We will be contacting you shortly with the exact time and pickup location"</em></p>
              
              <h3>Availability</h3>
              <p>This tour operates<br /><?php echo nl2br($tour_days); ?></p>
              
              <h3>Pickup Location</h3>
              <p>Hotel Lobby or specified meeting point<br />
              <em class="italics">"Pickup locations vary by hotel location<br />
              We'll be contacting you with the exact location"</em><br />
            </div>
          </div>

<?php
if(!empty($tour_additional)) {
?>
          <div class="alert alert-info">
            <i class="icon-thumbs-up"></i>
            <?php echo nl2br($tour_additional); ?>
          </div>
<?php 
} 
if(!$show_products_new)
{
?>

	<h2> Products </h2>
<?php
	if($tour_status != 0) {
		embedProducts($tour_id, $tour_url);
	}
	else {
	// Disabled Tour
		echo '<p>This Excursion is no longer available. Please <a href="/excursions/all-tours/">click here</a>, for other tour options.</p>';
	}
}
else
{
?>
<a name="purchase"></a> 
<h3>Order Now</h3>

<?php
	if($tour_status != 0) {
		embedProductsNew($tour_id, $tour_url);
	}
	else {
	// Disabled Tour
		echo '<p>This Excursion is no longer available. Please <a href="/excursions/all-tours/">click here</a>, for other tour options.</p>';
	}
}

?>


<?php
// -------------------------------------------------
// GALLERY FIX -- Start

if($tour_gallery)
{

$array[]="pin";
$array[]="clip";
$array[]="tape";
$array[]="pin transform";
$array[]="clip transform";
$array[]="tape transform";
$galleryType = array_rand($array);

if($show_products_new)
{
?>
<fieldset style="border-top:1px solid #b3c8e2;">
<legend style="border:1px solid #b3c8e2; width:140px;padding:0px; margin-left:50px;">&nbsp;&nbsp;Sneak Peak</legend>
</fieldset>
<?
}
?>
<ul class="gallery <?php echo $array[$galleryType]; ?>">
<?php
// -------------------------------------------------
// Select gallery 
// -------------------------------------------------
$sql = "select * FROM gallery WHERE gallery_id = '$tour_gallery'";
$res = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($res))
   {
   $row = MYSQL_FETCH_ARRAY($res);
   
$sql2 = "select * FROM photos 
  WHERE gallery_id = '$tour_gallery'
  ORDER BY picture_sortorder";
$res2 = mysql_query($sql2) or die(mysql_error());
while($row2 = MYSQL_FETCH_ARRAY($res2))
   {
  $picture_filename = $row2['picture_filename'];
  $picture_alttext = $row2['picture_alttext'];
  $picture_thumbnail = (substr($picture_filename, 0, (strrpos($picture_filename, '.')))) ."-sm.jpg";
?>
          <li> <a class="fancybox" rel="tag" title="<?php echo $picture_alttext; ?>" href="<?php echo constant("PRODUCT_IMAGE_DIR");?><?php echo nl2br($row['gallery_url']); ?>/<?php echo $picture_filename; ?>"><img style="max-width:184px;width:184px;" src="<?php echo constant("PRODUCT_IMAGE_DIR");?><?php echo nl2br($row['gallery_url'])."/"; ?><?php echo $picture_thumbnail; ?>" alt="<?php echo $picture_alttext; ?>" /></a> </li>
<?php 
    }
   }
?>
		  
        </ul>
<?
}
// GALLERY FIX -- End
// -------------------------------------------------
?>

<p>Please view our <a href="/cancellation-policy/">Cancellation Policy</a></p>
<p>&nbsp;</p>
        <form action="/contact/" method="post">
        <input type="hidden" name="tour" value="<?php echo nl2br($tour_name); ?>">
        <button type="submit" class="btn">Contact Us Now<i class="icon-chevron-right"></i></button>
        </form>
          

        </section><!-- /main_body -->
      </div> <!-- /span8 (left column) -->

  <?php require_once 'inc/sidebar_tour.php'; ?>
    </div><!-- /row -->
  </div><!-- /container -->

  <?php require_once 'inc/footer.php'; ?>

<?php 
/* End of First Page */
} else {
/* Begin Home Page */
?>


<?php require_once 'inc/meta.php'; ?>
<?php require_once 'inc/header.php'; ?>

<div class="container">
    <div class="row-fluid">
      <div class="span8">

      <!-- Main Content
      ================================================== -->
  <section class="main_body">
	  
	  <div class="video-container">
	  <iframe width="560" height="315" src="//youtube.com/embed/ocYoKbW3Gmo?rel=0&#038;autohide=1&#038;hd=1&#038;iv_load_policy=3&#038;wmode=transparent&#038;modestbranding=1&#038;autoplay=0"></iframe> <!-- buggies ocYoKbW3Gmo? whales -cOlxBkXMTw?  -->
	  </div>
	  
  <a href="/macao-buggies/"><h1>Enjoy Offroad Adventures</h1></a>
  <h3>Book Early so you Don't Miss Out!</h3>
  <p>Caribbean Dream offers the best selection of Punta Cana excursions at the most competitive prices. Customer service is our focus and unforgettable experiences are what we offer!<p>
  <p>Find your perfect Punta Cana tour with Caribbean Dream!<p>
  <p>Punta Cana is your gateway to magical adventure tours in the Caribbean. Fly high above the forest canopy on a <a href="zipline-canopy-adventure/">zip-line adventure</a> or <a href="/excursions/dolphin-swim/">swim with dolphins</a> for an incredible experience you will never forget. Go for a ride in your own <a href="bavaro-splash-speed-boats/">speed boat</a> off the tropical shores of Playa Bavaro, or just relax in a <a href="dr-fish-ocean-spa/">Spa Filled Adventure</a></p>
  <p>Browse, Book, Relax!<p>
  
 <!-- <p>Looking for <a href="/excursions/all-tours/">things to do in Punta Cana</a>? We offer a large selection of sightseeing excursions, attractions, day trips and <strong>tours in Punta Cana</strong>. Discover the ultimate adventure with our many incredible Punta Cana deals and lowest priced activities. Book Now and get great discounts on tours and attractions throughout Punta Cana.</p>
  <p>Punta Cana is your gateway to magical adventure tours in the Caribbean. Fly high above the forest canopy on a <a href="zipline-canopy-adventure/">zip-line adventure</a> or <a href="/excursions/dolphin-swim/">swim with dolphins</a> for an incredible experience you will never forget. Go for a ride in your own <a href="bavaro-splash-speed-boats/">speed boat</a> off the tropical shores of Playa Bavaro, or just relax in a <a href="dr-fish-ocean-spa/">Spa Filled Adventure</a></p>  -->

  <h1>Top 3 Excursions</h1>
  <div class="container row-fluid">
      <div class="span4">
          <div class="thumbnail">
            <div class="center_it"><a href="/scapepark//"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>scapepark-zipline/zip-line-punta-cana.jpg" alt="Hoyo Azul ScapePark" /></a></div>
            <div class="caption">
              <h4>Scape Park</h4>
              <p>Hoyo Azul &amp; more...</p>
              <p><a href="/scapepark/" class="btn btn-block btn-primary">Details</a></p>
            </div><!--/center_it-->
          </div><!--/thumbnail-->
      </div><!--/span4-->

      <div class="span4">
          <div class="thumbnail">
            <div class="center_it"><a href="/macao-buggies/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>macao-buggies/offroad-buggies.jpg" alt="Macao Buggies" /></a></div>
            <div class="caption">
              <h4>Macao Buggies</h4>
              <p>Go Offroading!</p>
              <p><a href="/macao-buggies/" class="btn btn-block btn-primary">Details</a></p>
            </div><!--/center_it-->
          </div><!--/thumbnail-->
      </div><!--/span4-->
	  
      <div class="span4">
          <div class="thumbnail">
            <div class="center_it"><a href="/4-wheel-adventure/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>4-wheel-adventure/4x4-atv.jpg" alt="4WD Offroad Adventure" /></a></div>
            <div class="caption">
              <h4>4 Wheel Adventure </h4>
              <p>ATV's ROCK!</p>
              <p><a href="/4-wheel-adventure/" class="btn btn-block btn-primary">Details</a></p>
            </div><!--/center_it-->
          </div><!--/thumbnail-->
      </div><!--/span4-->
  </div><!--/container-->

  <p>&nbsp;</p>
  <a class="btn btn-warning btn-large pull-right" href="/excursions/all-tours/">Let's Get Started <i class="icon-play icon-white"></i> </a>
  <p>&nbsp;</p>
  <div class="clearfix"></div>

  <h1>Most popular tour</h1>
  <div class="container row-fluid">
      <div class="span12">
          <div class="thumbnail">
            <div class="center_it"><a href="/macao-buggies/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>macao-buggies/dirty-road.jpg" alt="Offroad Buggies" /></a></div>
            <div class="caption">
              <h4>Check out our Buggies! </h4>
              <p>Book Early so you don't Miss Out!</p>
              <p><a href="/macao-buggies/" class="btn btn-block btn-primary">Details</a></p>
            </div>
          </div>
      </div><!--/span12-->
  </div><!--/container-->

  <p>&nbsp;</p>
  <a class="btn btn-warning btn-large pull-right" href="/excursions/all-tours/">More Punta Cana Tours <i class="icon-play icon-white"></i> </a>
  <p>&nbsp;</p>
  <div class="clearfix"></div>

  <h1>Exclusive Excursions</h1>
  <div class="container row-fluid">
    <!--  <div class="span6">
          <div class="thumbnail">
            <div class="center_it"><a href="/jeep-safari/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>jeep-safari/jeep-safari-river.jpg" alt="Punta Cana Jeep Safari" /></a></div>
            <div class="caption">
              <h4>Jeep Safari</h4>
              <p>The only tour with real Jeeps!</p>
              <p><a href="/jeep-safari/" class="btn btn-block btn-primary">Details</a></p>
            </div>
          </div>
      </div> 
      -->
     <div class="span6">
         <div class="thumbnail">
           <div class="center_it"><a href="/horseback-riding/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>horseback-riding/horseback-riding-3.jpg" alt="Beach Horseback Riding" /></a></div>
           <div class="caption">
             <h4>Horseback Riding</h4>
             <p>Now, Horseback Riding on the Beach!</p>
             <p><a href="/horseback-riding/" class="btn btn-block btn-primary">Details</a></p>
           </div>
         </div>
     </div><!--/span6-->
      <div class="span6">
          <div class="thumbnail">
            <div class="center_it"><a href="/saona-island/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR");?>saona-island/saona-island-1.jpg" alt="Saona island excursion" /></a></div>
            <div class="caption">
              <h4>Saona Island</h4>
              <p>Sun, Sand & A Drink In Your Hand!</p>
              <p><a href="/saona-island/" class="btn btn-block btn-primary">Details</a></p>
            </div>
          </div>
      </div><!--/span6-->
  </div><!--/container-->

   </section><!-- /main_body -->
 </div> <!-- /span8 (left column) -->

<?php require_once 'inc/sidebar_tour.php'; ?>
</div><!-- /row -->
</div><!-- /container -->

<?php 
/* End of ELSE Statement */
} ?>

<?php require_once 'inc/footer.php'; ?>
