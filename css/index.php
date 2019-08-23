<?php
$start = microtime(true);
require_once 'inc/config.php';
require_once 'inc/cart-manager.php';

$uri = explode('/', $_SERVER['REQUEST_URI']);
if (sizeof($uri) > 1 && !empty($uri[1])) {
  $page = $uri[1];

  $show_products_new = 1;

  // -------------------------------------------------
  // GALLERY FIX from MalibuPartyBoat
  // Clean up the $page variable here!!!
  // Allow only a-z, A-Z, 0-9 and dash
  $page = preg_replace("/[^a-zA-Z0-9\-]/", "", $page);
  // -------------------------------------------------

  // Get this website id
  $ws_url = strtolower($_SERVER['HTTP_HOST']);
  $sql = "select * FROM websites WHERE ws_url = '$ws_url'";
  $res = mysql_query($sql) or die(mysql_error());
  while ($row = MYSQL_FETCH_ARRAY($res)) {
    $v_site = $row['id'];
  }

  $error404 = true;

  $sql = "select * FROM $toursTable 
  WHERE t_url = '$page' and v_site='$v_site'";
  $res = mysql_query($sql) or die(mysql_error());
  while ($row = MYSQL_FETCH_ARRAY($res)) {
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
    if ($t_wdays[0] == '1') {
      $arr_days[$i] = 'Mon';
      $i++;
    }
    if ($t_wdays[1] == '1') {
      $arr_days[$i] = 'Tue';
      $i++;
    }
    if ($t_wdays[2] == '1') {
      $arr_days[$i] = 'Wed';
      $i++;
    }
    if ($t_wdays[3] == '1') {
      $arr_days[$i] = 'Thu';
      $i++;
    }
    if ($t_wdays[4] == '1') {
      $arr_days[$i] = 'Fri';
      $i++;
    }
    if ($t_wdays[5] == '1') {
      $arr_days[$i] = 'Sat';
      $i++;
    }
    if ($t_wdays[6] == '1') {
      $arr_days[$i] = 'Sun';
      $i++;
    }

    $arr_c = count($arr_days) - 1;
    array_unshift($arr_days, $arr_days[$arr_c]);
    $dummy = array_pop($arr_days);
    $tour_days = implode(', ', $arr_days);


    // Change datepicker settings
    array_unshift($t_wdays, $t_wdays[6]);
    $dummy = array_pop($t_wdays);

    $arr_days = array();

    $i = 0;
    if ($t_wdays[0] == '0') {
      $arr_days[$i] = '0';
      $i++;
    }
    if ($t_wdays[1] == '0') {
      $arr_days[$i] = '1';
      $i++;
    }
    if ($t_wdays[2] == '0') {
      $arr_days[$i] = '2';
      $i++;
    }
    if ($t_wdays[3] == '0') {
      $arr_days[$i] = '3';
      $i++;
    }
    if ($t_wdays[4] == '0') {
      $arr_days[$i] = '4';
      $i++;
    }
    if ($t_wdays[5] == '0') {
      $arr_days[$i] = '5';
      $i++;
    }
    if ($t_wdays[6] == '0') {
      $arr_days[$i] = '6';
      $i++;
    }

    $daysOfWeekDisabled = implode(',', $arr_days);

    //$daysOfWeekDisabled = implode(',', $t_wdays);
    // ------------------------------------------------- 
  }
  if ($error404 == true) {
    // 404 Error Page Here
    header('Location: /');
    return;
  }
  ?>
  <!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">

  <head>
    <?
    if ($googletest) {
      echo $googletest;
      //readfile($googletest);   
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php if (!$error404) {
                                        echo $tour_desc_meta;
                                      } ?>" />
    <meta name="keywords" content="excursions, tours, punta cana, dominican, vacation, tour operator" />
    <meta name="robots" content="index, follow" />
    <meta name="geo.region" content="DO-11" />
    <meta name="geo.placename" content="Punta Cana" />
    <meta property="og:title" content="<?php echo nl2br($tour_name); ?>" />
    <meta property="og:type" content="product" />
    <meta property="og:price:amount" content="varies" />
    <meta property="og:price:currency" content="USD" />
    <title><?php if (!$error404) {
              echo nl2br($tour_name);
            } ?> | Punta Cana Tours and Excursions</title>
    <link rel="canonical" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>">
    <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en" />
    <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en-us" />
    <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en-ca" />
    <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="en-do" />
    <link rel="alternate" href="http://puntacanatours.com<?php echo $_SERVER['REQUEST_URI']; ?>" hreflang="x-default" />
    <link href="/css/compress.min.css?v=6" rel="stylesheet">
    <link href="/css/pct.css?v=7?v=6" rel="stylesheet">
    <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <link href="//puntacanatours-caribbeandream.netdna-ssl.com/img/Caribbean-Dream-Favicon.png" rel="shortcut icon" type="image/png" />
    <!-- Facebook Pixel Code -->
    <script>
      ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
          n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
      }(window,
        document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

      fbq('init', '276559712701569');
      fbq('track', "PageView");
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=276559712701569&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->
  </head>

  <body onload itemscope itemtype="http://schema.org/WebPage">
    <?php
    require_once 'inc/analyticstracking.php';
    require_once 'inc/header.php';

    if ($error404 == true) {
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
      <div class="span12">

        <!-- Main Content
            ================================================== -->
        <section class="main_body">
          <h1><?php echo nl2br($tour_name); ?></h1>
          <?php if ($tour_video != "") { ?>
            <div class="video-container">
              <div id="player" name="<?= nl2br($tour_name) ?>"></div>
            </div>
          <?php } else { ?>
            <div class="gallery">
              <img src="<?php echo constant("CATEGORY_IMAGE_DIR");
                        echo nl2br($tour_photo); ?>" alt="<?php echo nl2br($tour_name); ?>">
            </div>
          <?php } ?>


          <h2>Description</h2>
          <p><?php echo nl2br($tour_desc); ?></p>
          <div class="row">
            <div class="span4">

              <h3>Included</h3>
              <ul class="check_list">
                <?php echo '<li>' . str_replace(array("\r", "\n\n", "\n"), array('', "\n", "</li>\n<li>"), trim($tour_included, "\n\r")) . '</li>'; ?>
              </ul>

              <h3>Not Included</h3>
              <ul class="check_list">
                <?php echo '<li>' . str_replace(array("\r", "\n\n", "\n"), array('', "\n", "</li>\n<li>"), trim($tour_not_included, "\n\r")) . '</li>'; ?>
              </ul>
            </div>

            <div class="span4">
              <h3>Duration</h3>
              <p><?php echo nl2br($tour_duration); ?></p>

              <h3>Hours</h3>
              <p><?php echo nl2br($tour_times); ?><br /><br /><em>"Pickup times and locations vary depending on the hotel
                  you are staying at. We will be contacting you shortly with the exact time and pickup location"</em></p>

              <h3>Availability</h3>
              <p>This tour operates<br /><?php echo nl2br($tour_days); ?></p>

              <h3>Pickup Location</h3>
              <p>Hotel Lobby or specified meeting point<br />
                <em class="italics">"Pickup locations vary by hotel location<br />
                  We'll be contacting you with the exact location"</em><br />
            </div>
          </div>

          <?php
          if (!empty($tour_additional)) {
            ?>
            <div class="alert alert-info">
              <i class="icon-thumbs-up"></i>
              <?php echo nl2br($tour_additional); ?>
            </div>
          <?php
        }
        if (!$show_products_new) {
          ?>

            <h2> Products </h2>
            <?php
            if ($tour_status != 0) {
              embedProducts($tour_id, $tour_url);
            } else {
              // Disabled Tour
              echo '<p>This Excursion is no longer available. Please <a href="/excursions/all-tours/">click here</a>, for other tour options.</p>';
            }
          } else {
            ?>
            <a name="purchase"></a>
            <h3>Order Now</h3>

            <?php
            if ($tour_status != 0) {
              embedProductsNew($tour_id, $tour_url);
            } else {
              // Disabled Tour
              echo '<p>This Excursion is no longer available. Please <a href="/excursions/all-tours/">click here</a>, for other tour options.</p>';
            }
          }

          ?>


          <?php
          // -------------------------------------------------
          // GALLERY FIX -- Start

          if ($tour_gallery) {

            $array[] = "pin";
            $array[] = "clip";
            $array[] = "tape";
            $array[] = "pin transform";
            $array[] = "clip transform";
            $array[] = "tape transform";
            $galleryType = array_rand($array);

            if ($show_products_new) {
              ?>
              <fieldset style="border-top:1px solid #b3c8e2;">
                <legend style="border:1px solid #b3c8e2; width:140px;padding:0px; margin-left:50px;">&nbsp;&nbsp;Sneak Peak
                </legend>
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
              if (mysql_num_rows($res)) {
                $row = MYSQL_FETCH_ARRAY($res);

                $sql2 = "select * FROM photos 
  WHERE gallery_id = '$tour_gallery'
  ORDER BY picture_sortorder";
                $res2 = mysql_query($sql2) or die(mysql_error());
                while ($row2 = MYSQL_FETCH_ARRAY($res2)) {
                  $picture_filename = $row2['picture_filename'];
                  $picture_alttext = $row2['picture_alttext'];
                  $picture_thumbnail = (substr($picture_filename, 0, (strrpos($picture_filename, '.')))) . "-sm.jpg";
                  ?>
                  <li> <a class="fancybox" rel="tag" title="<?php echo $picture_alttext; ?>" href="<?php echo constant("PRODUCT_IMAGE_DIR"); ?><?php echo nl2br($row['gallery_url']); ?>/<?php echo $picture_filename; ?>"><img style="max-width:184px;width:184px;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?><?php echo nl2br($row['gallery_url']) . "/"; ?><?php echo $picture_thumbnail; ?>" alt="<?php echo $picture_alttext; ?>" /></a> </li>
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

      <?php /* require_once 'inc/sidebar_tour.php'; */ ?>
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
  <!-- EndModal -->
  <div class="row-fluid mb-3">
    <div class="search">
      <img src="/img/Punta-Cana-Tours-background.jpg" alt="">
      <div class="search-form">
        <div class="search-form-2">
          <h1>Browse, Book, Relax.</h1>
          <p>The fun way to enjoy Punta Cana</p>
          <div class="form-input">
            <input placeholder="Search for a tour: Ej. Zipline tour Punta Cana" id="appendedInputButton" type="text">
            <button class="btn" type="button"><i class="fa fa-search"></i> Search</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row-fluid">

      <!-- <aside class="span4">
        <div class="form-book">
          <div class="tabbable">
            
            <ul class="nav nav-tabs mb-0">
              <li class="span6 text-center active"><a href="#tab1" data-toggle="tab">Tours</a></li>
              <li class="span6 text-center"><a href="#tab2" data-toggle="tab">Transfers</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <form class="row" method="POST" action="/redirect.php">
                  <div class="span12 mb-1">
                    <label for="">Category</label>
                    <select name="category" class="form-control chosen-select form-control">
                      <option value disabled selected>Choose one</option>
                      <option value="day-tours">Day Tours</option>
                      <option value="water-tours">Water</option>
                      <option value="adventure-tours">Adventures </option>
                      <option value="horseback">Horseback</option>
                      <option value="sharks-stingrays">Sharks Stingrays</option>
                      <option value="cultural-tours">Cultural</option>
                      <option value="kid-discounts">Kid Discounts</option>
                      <option value="dolphin-swim">Dolphin Swim</option>
                      <option value="air">Air</option>
                      <option value="top-tours">Top Tours</option>
                      <option value="combos">Combos</option>
                    </select>
                  </div>
                  <div class="span12 mb-1">
                    <label for="">Tour</label>
                    <select name="tour" class="form-control chosen-select form-control">
                      <option value disabled selected>Choose one</option>
                      <?php
                      $sql = "select * FROM tours_v2 WHERE v_site = 24";
                      $res = mysql_query($sql) or die(mysql_error());
                      while ($row = MYSQL_FETCH_ARRAY($res)) {
                        echo "<option value=" . $row['t_url'] . ">" . $row['t_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="span12 text-center ml-0">
                    <button class="btn btn-danger" type="submit">Search</button>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="tab2">
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

                  <label>Hotel</label>
                  <?php showHotelPicker("hotel"); ?>

                  <label>Passengers</label>
                  <select name="pax" data-placeholder="Passengers" class="input-xlarge chosen-select form-control" data-required="true">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2" selected>2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                  </select>

                  <label>Airport</label>
                  <select name="airport" data-placeholder="What Airport" class="input-xlarge chosen-select form-control" data-required="true">
                    <option value=""></option>
                    <option value="puj" selected>Punta Cana (PUJ)</option>
                    <option value="lrm">La Romana (LRM)</option>
                    <option value="sdq">Santo Domingo (SDQ)</option>
                  </select>

                  <br /><br />
                  <button type="submit" class="pull-left btn btn-danger">Next</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </aside> -->

      <div class="span12 m-0">
        <div class="row-fluid">
          <a href="/macao-buggies/">
            <h1>Enjoy Offroad Adventures</h1>
          </a>
          <h3>Book Early so you Don't Miss Out!</h3>
          <p>Caribbean Dream offers the best selection of Punta Cana excursions at the most competitive prices. Customer
            service is our focus and unforgettable experiences are what we offer!</p>
          <p>Find your perfect Punta Cana tour with Caribbean Dream!</p>
          <p>Punta Cana is your gateway to magical adventure tours in the Caribbean. Fly high above the forest
            canopy on a <a href="zipline-canopy-adventure/">zip-line adventure</a> or <a href="/excursions/dolphin-swim/">swim
              with dolphins</a> for an incredible experience you will never
            forget. Go for a ride in your own <a href="bavaro-splash-speed-boats/">speed boat</a> off the tropical
            shores of Playa Bavaro, or just relax in a <a href="dr-fish-ocean-spa/">Spa Filled Adventure</a></p>
          <p>Browse, Book, Relax!</p>
          <h1>Top 3 Excursions</h1>
          <div class="container row-fluid">
            <div class="span4">
              <div class="thumbnail">
                <div class="center_it"><a href="/scapepark//"><img src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>scapepark-zipline/zip-line-punta-cana.jpg" alt="Hoyo Azul ScapePark" /></a></div>
                <div class="caption">
                  <h4>Scape Park</h4>
                  <p>Hoyo Azul &amp; more...</p>
                  <p><a href="/scapepark/" class="btn btn-block btn-danger">Details</a></p>
                </div>
                <!--/center_it-->
              </div>
              <!--/thumbnail-->
            </div>
            <!--/span4-->

            <div class="span4">
              <div class="thumbnail">
                <div class="center_it"><a href="/macao-buggies/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>macao-buggies/offroad-buggies.jpg" alt="Macao Buggies" /></a></div>
                <div class="caption">
                  <h4>Macao Buggies</h4>
                  <p>Go Offroading!</p>
                  <p><a href="/macao-buggies/" class="btn btn-block btn-danger">Details</a></p>
                </div>
                <!--/center_it-->
              </div>
              <!--/thumbnail-->
            </div>
            <!--/span4-->

            <div class="span4">
              <div class="thumbnail">
                <div class="center_it"><a href="/4-wheel-adventure/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>4-wheel-adventure/4x4-atv.jpg" alt="4WD Offroad Adventure" /></a></div>
                <div class="caption">
                  <h4>4 Wheel Adventure </h4>
                  <p>ATV's ROCK!</p>
                  <p><a href="/4-wheel-adventure/" class="btn btn-block btn-danger">Details</a></p>
                </div>
                <!--/center_it-->
              </div>
              <!--/thumbnail-->
            </div>
            <!--/span4-->
            <p>&nbsp;</p>
            <a class="btn btn-warning btn-large pull-right" href="/excursions/all-tours/">Let's Get Started <i class="icon-play icon-white"></i> </a>
            <p>&nbsp;</p>
            <div class="clearfix"></div>
          </div>
          <!--/container-->

          <h1>Exclusive Excursions</h1>
          <div class="container row-fluid">
            <div class="span4">
              <div class="thumbnail">
                <div class="center_it"><a href="/macao-buggies/">
                    <img src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>macao-buggies/dirty-road.jpg" alt="Beach Horseback Riding" /></a></div>
                <div class="caption">
                  <h4>Check out our Buggies! </h4>
                  <p>Book Early so you don't Miss Out!</p>
                  <p><a href="/macao-buggies/" class="btn btn-block btn-danger">Details</a></p>
                </div>
              </div>
            </div>
            <div class="span4">
              <div class="thumbnail">
                <div class="center_it"><a href="/horseback-riding/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>horseback-riding/horseback-riding-3.jpg" alt="Beach Horseback Riding" /></a></div>
                <div class="caption">
                  <h4>Horseback Riding</h4>
                  <p>Now, Horseback Riding on the Beach!</p>
                  <p><a href="/horseback-riding/" class="btn btn-block btn-danger">Details</a></p>
                </div>
              </div>
            </div>
            <div class="span4">
              <div class="thumbnail">
                <div class="center_it"><a href="/saona-island/"><img src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>saona-island/saona-island-1.jpg" alt="Saona island excursion" /></a></div>
                <div class="caption">
                  <h4>Saona Island</h4>
                  <p>Sun, Sand & A Drink In Your Hand!</p>
                  <p><a href="/saona-island/" class="btn btn-block btn-danger">Details</a></p>
                </div>
              </div>
            </div>
            <p>&nbsp;</p>
            <a class="btn btn-warning btn-large pull-right" href="/excursions/all-tours/">More Punta Cana Tours
              <i class="icon-play icon-white"></i> </a>
            <p>&nbsp;</p>
            <div class="clearfix"></div>
          </div>
          <!--/container-->
        </div>
      </div>

      <div class="span12">
        <!-- Modal -->
        <div id="oferta" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:90%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title combo-title">Super Combos for only <span class="color">$99.00</span></h3>
              </div>
              <div class="modal-body">
                <div class="owl-carousel owl-theme">
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/supercombo-buggies-horseback-riding/">
                          <img style="width:100%;" src="//cdto.net/assets/thumbnails/combo002.jpg" alt="Combo Buggies + Horseback riding" title="Combo Buggies + Horseback riding">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Buggies + Horseback riding</h4>
                        <p><a href="/supercombo-buggies-horseback-riding/" class="btn btn-block btn-danger">Book Now</a>
                        </p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/experienceBuggies-safari-zipline/">
                          <img style="width:100%;" src="//cdto.net/assets/combo003.jpg" alt="Combo Buggies + Safari + Zip line" title="Combo Buggies + Safari + Zip line">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Buggies + Safari + Zip line</h4>
                        <p><a href="/experienceBuggies-safari-zipline/" class="btn btn-block btn-danger">Book Now</a></p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/surfinginzipline-safari-horsesbackride/">
                          <img style="width:100%;" src="//cdto.net/assets/combo004.jpg" alt="Combo Zip Line + Safari + Lunch + Horsesback Ride" title="Combo Zip Line + Safari + Lunch + Horsesback Ride">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Zip Line + Safari + Lunch + Horsesback Ride</h4>
                        <p><a href="/surfinginzipline-safari-horsesbackride/" class="btn btn-block btn-danger">Book
                            Now</a></p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/combocatamaran-zipline-safari-lunch/">
                          <img style="width:100%;" src="//cdto.net/assets/combo005.jpg" alt="Combo Catamarán + Zip Line + Safari + Lunch" title="Combo Catamarán + Zip Line + Safari + Lunch">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Catamarán + Zip Line + Safari + Lunch</h4>
                        <p><a href="/combocatamaran-zipline-safari-lunch/" class="btn btn-block btn-danger">Book Now</a>
                        </p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/surfingincatamaran-horsesbackride-lunch/">
                          <img style="width:100%;" src="//cdto.net/assets/combo006.jpg" alt="Combo Catamaran + Horsesback Ride + Lunch" title="Combo Catamaran + Horsesback Ride + Lunch">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Catamaran + Horsesback Ride + Lunch</h4>
                        <p><a href="/surfingincatamaran-horsesbackride-lunch/" class="btn btn-block btn-danger">Book
                            Now</a></p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/experiencethecatamaran-aquapark-luch/">
                          <img style="width:100%;" src="//cdto.net/assets/combo007.jpg" alt="Combo Catamaran + Aquapark + Lunch" title="Combo Catamaran + Aquapark + Lunch">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Catamaran + Aquapark + Lunch</h4>
                        <p><a href="/experiencethecatamaran-aquapark-luch/" class="btn btn-block btn-danger">Book Now</a>
                        </p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                  <div class="item">
                    <div class="thumbnail">
                      <div class="center_it">
                        <a href="/Combohorsesbackride-safari-zipline-buggies-lunch-funpark/">
                          <img style="width:100%;" src="//cdto.net/assets/combo008.jpg" alt="Combo Horsesback Ride + Safari + Zip Line + Buggies + Lunch" title="Combo Horsesback Ride + Safari + Zip Line + Buggies + Lunch">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Horsesback Ride + Safari + Zip Line + Buggies + Lunch</h4>
                        <p><a href="/Combohorsesbackride-safari-zipline-buggies-lunch-funpark/" class="btn btn-block btn-danger">Book Now</a></p>
                      </div>
                      <!--/center_it-->
                    </div>
                    <!--/thumbnail-->
                  </div>
                  <!--/item-->
                </div>
              </div>

            </div>
          </div>
        </div>
      </div><!-- /row -->
    </div><!-- /container -->
  <?php
  /* End of ELSE Statement */
} ?>

  <?php require_once 'inc/footer.php'; ?>
  <div class="marca">
    <img src="//puntacanatours-caribbeandream.netdna-ssl.com/img/Caribbean-Dream-Favicon.png" alt="">
  </div>
  <script>
    $(function() {
      /* $('#oferta').modal('show'); */
      $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 1
          },
          1000: {
            items: 3
          }
        }
      });
    });
  </script>