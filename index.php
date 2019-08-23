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
    <link href="/css/pct.css?v=12" rel="stylesheet">
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
      <div class="col-12">

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
          <!-- <h1>Browse, Book, Relax.</h1>
          <p>The fun way to enjoy Punta Cana</p>
          <div class="form-input">
            <input placeholder="Search for a tour: Ej. Zipline tour Punta Cana" id="appendedInputButton" type="text">
            <button class="btn" type="button"><i class="fa fa-search"></i> Search</button>
          </div> -->
          <ul class="nav nav-tabs mb-0">
            <li class="active"><a href="#tab1" data-toggle="tab">Экскурсии</a></li>
            <li class=""><a href="#tab2" data-toggle="tab">переводы</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
              <div class="container-new-fluid">
                <form class="row-new" method="POST" action="/redirect.php">
                  <div class="col-md-5 col-12 mb-1">
                    <label for="">категория</label>
                    <select name="category" class="form-control">
                      <option value disabled selected>Выбери один</option>
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
                  <div class="col-md-5 col-12 mb-1">
                    <label for="">экскурсия</label>
                    <select name="tour" class="form-control">
                      <option value disabled selected>Выбери один</option>
                      <?php
                      $sql = "select * FROM tours_v2 WHERE v_site = 3";
                      $res = mysql_query($sql) or die(mysql_error());
                      while ($row = MYSQL_FETCH_ARRAY($res)) {
                        echo "<option value=" . $row['t_url'] . ">" . $row['t_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2">
                    <button class="col-12 btn btn-warning" type="submit"><i class="fa fa-search"></i> Поиск</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="tab-pane" id="tab2">
              <form method="post" action="/airport-transfer-quote.php">
                <div class="container-new-fluid">
                  <div class="row-new">
                    <div class="col-12 mb-1">
                      <div class="row-new">
                        <label class="mr-1" style="margin-left:2em;margin-right:1em;">Тип трансфера: </label>
                        <label class="radio mr-1">
                          <input type="radio" name="transfer" value="1" checked>
                          Round Trip
                        </label>

                        <label class="radio mr-1">
                          <input type="radio" name="transfer" value="2">
                          One Way (Arrival)
                        </label>

                        <label class="radio mr-1">
                          <input type="radio" name="transfer" value="3">
                          One Way (Departure)
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row-new">
                    <div class="col-md-3 col-6">
                      <label>Гостиница</label>
                      <select id="hotel" name="hotel" data-placeholder="Hotel for Pickup" class="form-control" required>
                        <option value=""></option>
                        <optgroup label="Punta Cana">
                          <option value="79">AlSol del Mar</option>
                          <option value="7">AlSol Luxury Village</option>
                          <option value="90">TRS Cap Cana</option>
                          <option value="88">Aquamarina</option>
                          <option value="1">Club Med</option>
                          <option value="6">Sanctuary Cap Cana</option>
                          <option value="157">Secrets Cap Cana</option>
                          <option value="5">Sheraton Four Points</option>
                          <option value="2">Westin Puntacana</option>
                          <option value="159">Eden Roc</option>
                          <option value="161">TRS Cap Cana</option>
                          <option value="164">Tortuga Bay</option>
                        </optgroup>
                        <optgroup label="Cabeza de Toro">
                          <option value="10">Be Live Collection Punta Cana</option>
                          <option value="9">Be Live Grand Bavaro</option>
                          <option value="8">Catalonia Bavaro</option>
                          <option value="83">Catalonia Royal Bavaro</option>
                          <option value="11">Dreams Palm Beach</option>
                          <option value="12">Natura Park</option>
                          <option value="163">Blue Beach Punta Cana</option>
                          <option value="168">Blue Bay Punta Cana</option>
                        </optgroup>
                        <optgroup label="Bavaro">
                          <option value="46">Bahia Principe Ambar</option>
                          <option value="47">Bahia Principe Bavaro</option>
                          <option value="45">Bahia Principe Esmeralda</option>
                          <option value="48">Bahia Principe Punta Cana</option>
                          <option value="85">Bahia Principe Turquesa</option>
                          <option value="14">Impressive Resort & Spa</option>
                          <option value="13">Barcelo Bavaro Palace Deluxe</option>
                          <option value="53">Occidental Grand Caribe (Barcelo P C)</option>
                          <option value="28">Bavaro Princess</option>
                          <option value="30">Caribe Club Princess</option>
                          <option value="23">Grand Palladium Bavaro</option>
                          <option value="25">Grand Palladium Palace</option>
                          <option value="24">Grand Palladium Punta Cana</option>
                          <option value="54">Hard Rock Hotel</option>
                          <option value="39">Iberostar Bavaro </option>
                          <option value="38">Iberostar Dominicana</option>
                          <option value="37">Iberostar Grand </option>
                          <option value="36">Iberostar Punta Cana</option>
                          <option value="15">IFA Villas Bavaro</option>
                          <option value="50">Majestic Colonial</option>
                          <option value="49">Majestic Elegance</option>
                          <option value="153">Majestic Mirage</option>
                          <option value="16">Melia Caribe Tropical</option>
                          <option value="51">Memories Splash</option>
                          <option value="77">NH Hotel</option>
                          <option value="144">NOW Garden</option>
                          <option value="18">NOW Larimar</option>
                          <option value="35">Ocean Blue &amp; Sand</option>
                          <option value="27">Occidental Punta Cana</option>
                          <option value="17">Paradisus Palma Real</option>
                          <option value="32">Paradisus Punta Cana</option>
                          <option value="155">Plaza Turquesa</option>
                          <option value="78">Presidential Suites</option>
                          <option value="29">Punta Cana Princess</option>
                          <option value="44">RIU Bambu</option>
                          <option value="43">RIU Naiboa</option>
                          <option value="40">RIU Palace Bavaro</option>
                          <option value="41">RIU Palace Punta Cana</option>
                          <option value="42">RIU Palace Macao</option>
                          <option value="148">RIU Republica</option>
                          <option value="26">TRS Turquesa</option>
                          <option value="52">Royalton Punta Cana</option>
                          <option value="19">Secrets Royal Beach</option>
                          <option value="156">Impressive Punta Cana</option>
                          <option value="31">Tropical Club Princess</option>
                          <option value="34">VIK Hotel Arena Blanca</option>
                          <option value="33">VIK Hotel Cayena Beach</option>
                          <option value="22">Vista Sol</option>
                          <option value="20">Whala Bavaro</option>
                          <option value="91">Paradisus Grand Reserve</option>
                          <option value="160">Royalton Bavaro</option>
                          <option value="166">Grand Bahia Principe Aquamarine </option>
                          <option value="170">Aventura Beach Resort</option>
                        </optgroup>
                        <optgroup label="Uvero Alto">
                          <option value="60">Breathless</option>
                          <option value="86">Chic Punta Cana</option>
                          <option value="56">Dreams Punta Cana</option>
                          <option value="59">Excellence Punta Cana</option>
                          <option value="149">Excellence El Carmen</option>
                          <option value="145">Nickelodeon</option>
                          <option value="151">NOW Onyx</option>
                          <option value="146">Sensatori Punta Cana</option>
                          <option value="57">Sirenis Cocotal</option>
                          <option value="58">Sirenis Tropical Suites</option>
                          <option value="62">Sivory</option>
                          <option value="61">Zoetry Agua</option>
                          <option value="165">Ocean El Faro</option>
                        </optgroup>
                        <optgroup label="Bayahibe">
                          <option value="67">Bahia Principe La Romana</option>
                          <option value="66">Be Live Canoa</option>
                          <option value="89">Casa de Campo</option>
                          <option value="87">Catalonia Gran Dominicus</option>
                          <option value="63">Hilton La Romana</option>
                          <option value="143">Iberostar Hacienda Dominicus</option>
                          <option value="64">Viva Dominicus</option>
                        </optgroup>
                        <optgroup label="">
                          <option value="167"></option>
                        </optgroup>
                      </select>
                    </div>
                    <div class="col-md-3 col-6">
                      <label>Пассажиры</label>
                      <select name="pax" data-placeholder="Passengers" class="input-xlarge form-control" data-required="true">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2" selected>2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6">
                      <label>аэропорт</label>
                      <select name="airport" data-placeholder="What Airport" class="input-xlarge form-control" data-required="true">
                        <option value=""></option>
                        <option value="puj" selected>Punta Cana (PUJ)</option>
                        <option value="lrm">La Romana (LRM)</option>
                        <option value="sdq">Santo Domingo (SDQ)</option>
                      </select>
                    </div>
                    <div class="col-md-3 col-6">
                      <button type="submit" class="col-12 btn btn-warning">следующий</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-new">
    <div class="row-new info-important">
      <div class="col-4 col-md-2">
        <img class="img-responsive" src="/img/callnow.png" alt="">
      </div>
      <div class="col-4 col-md-2 text-center">
        <p>Бесплатный звонок из США и Канады</p>
        <h4>844-DR-TOURS</h4>
      </div>
      <div class="col-4 col-md-2 text-center">
        <p>Доминиканская Республика и другие страны</p>
        <h4>829 961-4829</h4>
      </div>
      <div class="col-4 col-md-2 text-center">
        <div class="row">
          <p>Мы принимаем все формы оплаты</p>
          <img class="img-responsive" src="/img/caribbeandream-payment-circle.png" alt="caribbeandream-payment-circle">
        </div>
      </div>
      <div class="col-4 col-md-2">
        <img class="img-responsive" src="/img/tripadvisor.png" alt="Tripadvisor Punta Cana Tours">
      </div>
      <div class="col-4 col-md-2">
        <img class="img-responsive" src="/img/satisfactionfuaranted.png" alt="satisfactionfuaranted">
      </div>
    </div>
  </div>


  <div class="container-new">
    <div class="row-new mt-3 book-before">
      <div class="col-lg-6 col-md-12 pt-2 book-before-fondo">
        <div class="row-new">
          <h1 class="col-12 m-0 mb-1">КНИГА РАНЬШЕ, ЧТО ВЫ НЕ ПРОПУСТИТЕ!</h1>
          <p class="col-10 offset-1 tex-center">
          Caribbean Dream предлагает лучший выбор экскурсий в Пунта-Кана по самым конкурентоспособным ценам. Обслуживание клиентов - это наше внимание, а незабываемые впечатления - это то, что мы предлагаем!
            <br><br>
            Найдите свой идеальный тур по Пунта-Кана с Caribbean Dream!
            <br><br>
            Пунта Кана - это ваши ворота в волшебные приключенческие туры по Карибам. Летите высоко над пологом леса на приключениях на молнии или плавайте с дельфинами, чтобы получить невероятные впечатления, которые вы никогда не забудете. Прокатитесь на своем скоростном катере у тропических берегов Плайя Баваро или просто отдохните в Spa Filled Adventure.
          </p>
        </div>
      </div>
      <div class="col-lg-6 visible-lg p-0">
        <img src="/img/caribbeandream-1.png" alt="">
      </div>
    </div>
  </div>

  <div class="container-new mt-2">
    <div class="row-new">
    <a href="/macao-buggies/">
      <h1>НАСЛАЖДАЙТЕСЬ НОВЫМИ ПРИКЛЮЧЕНИЯМИ!</h1>
    </a>
    <p>Наша компания «Карибская мечта» предлагает лучший выбор экскурсий по самым низким ценам. Качественное обслуживание клиентов и ваши незабываемые впечатления  – наша главная цель. С нами вы найдете и воплотите в жизнь идеальные маршруты в Доминиканской Республике! </p>
    <p>Экскурсионные программы в Доминикане способны удовлетворить даже самого искушенного путешественника. Хотите поплавать с морскими звездами и увидеть своими глазами любовные игры китов? Острова Саона и Самана – обязательны к посещению. Любителям адреналина - заготовки от компании «Карибская мечта» на любой вкус: порулить вертолетом вдоль бирюзы океана в Пунта Кана, спуститься с 27 водопадов в национальном парке, заглянуть в глаза крокодилу на озере Энрикийо, или полетать над джунглями по канатным дорогам.</p>
    <p>Противникам ленивого отдыха всегда найдется альтернатива в виде серфинга, дайвинга или рыбалки. Фанатов братьев наших меньших ждут многочисленные парки, где можно покормить с рук экзотических животных и научить попугаев говорить: «Привет», озеро с розовыми фламинго, прогулка на лошадях, поцелуи дельфинов. После насыщенных экскурсионных дней вы сможете расслабиться в «СПА Файлед Адвенчур».</p>
    <p>Выбирайте, бронируйте, отдыхайте!</p>
    </div>
  </div>
  
  <div class="container-new mt-1">
    <div class="row-new">
      <h1 class="col-12">ТОП 3 ЭКСКУРСИИ</h1>
      <div class="col-12 col-md-4">
        <div class="thumbnail">
          <div class="center_it">
            <a href="/saona-island/">
              <div style="width:100%;height:250px;display:flex;align-items:center;overflow:hidden;">
                <img style="min-height:100%;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>saona-island/saona-island-10.jpg" alt="Saona Island" />
              </div>
            </a>
          </div>
          <div class="caption">
            <h4>Остров Саона</h4>
            <p>Карибское море, по пояс песочница!</p>
            <p><a href="/saona-island/" class="btn btn-block btn-danger">подробности</a></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="thumbnail">
          <div class="center_it">
            <a href="/macao-buggies/">
              <div style="width:100%;height:250px;display:flex;align-items:center;overflow:hidden;">
                <img style="min-height:100%;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>macao-buggies/dirty-road.jpg" alt="Macao Buggies" />
              </div>
            </a>
          </div>
          <div class="caption">
            <h4>Багги</h4>
            <p>Посетите Пляж Макао</p>
            <p><a href="/macao-buggies/" class="btn btn-block btn-danger">подробности</a></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="thumbnail">
          <div class="center_it">
            <a href="/catamaran-sailing/">
              <div style="width:100%;height:250px;display:flex;align-items:center;overflow:hidden;">
                <img style="min-height:100%;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>catamaran-cruise-point/tourspoint%20(1).jpg" alt="Catamaran Cruise" />
              </div>
            </a>
          </div>
          <div class="caption">
            <h4>Катамаран Круиз</h4>
            <p>Знаете ли вы, что посетители № 1 в Пунта-Кане</p>
            <p><a href="/catamaran-sailing/" class="btn btn-block btn-danger">подробности</a></p>
          </div>
        </div>
      </div>

      <div class="col-12">
        <a class="btn btn-warning btn-large pull-right" href="/excursions/all-tours/">Давайте начнем <i class="icon-play icon-white"></i> </a>
      </div>
    </div>
  </div>


  <div class="container-new mt-1">
    <h1>Эксклюзивные Экскурсии</h1>
    <div class="row-new">
      <div class="col-12 col-md-4">
        <div class="thumbnail">
          <div class="center_it">
            <a href="/SlingShot-cana-com/">
              <div style="width:100%;height:250px;display:flex;align-items:center;overflow:hidden;">
                <img style="min-height:100%;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>SLINGSHOT-GELLERIES-COM-G/slingshot002.jpg" alt="Slingshots" />
              </div>
            </a>
          </div>
          <div class="caption">
            <h4>Рогатки</h4>
            <p>Отель Хард Рок Пунта Кана</p>
            <p><a href="/SlingShot-cana-com/" class="btn btn-block btn-danger">подробности</a></p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="thumbnail">
          <div class="center_it">
            <a href="/jeep-safari/">
              <div style="width:100%;height:250px;display:flex;align-items:center;overflow:hidden;">
                <img style="min-height:100%;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>jeep-safari/jeep%20(9).jpg" alt="Jeep Safari" />
              </div>
            </a>
          </div>
          <div class="caption">
            <h4>Джип Сафари</h4>
            <p>Оставьте курортные пляжи Пунта-Кана</p>
            <p><a href="/jeep-safari/" class="btn btn-block btn-danger">подробности</a></p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="thumbnail">
          <div class="center_it">
            <a href="/imagen-disco-caribbeandream/">
              <div style="width:100%;height:250px;display:flex;align-items:center;overflow:hidden;">
                <img style="min-height:100%;" src="<?php echo constant("PRODUCT_IMAGE_DIR"); ?>imagine-disco-caribbeandream-flow/imagine%20(10)-sm.jpg" alt="Imagine Disco" />
              </div>
            </a>
          </div>
          <div class="caption">
            <h4>Представь себе диско</h4>
            <p>Который известен как "Пещера"</p>
            <p><a href="/imagen-disco-caribbeandream/" class="btn btn-block btn-danger">подробности</a></p>
          </div>
          <!--/center_it-->
        </div>
        <!--/thumbnail-->
      </div>
      <div class="col-12">
        <a class="btn btn-warning btn-large pull-right" href="/excursions/all-tours/">
          Больше туров по Пунта-Кане
          <i class="icon-play icon-white"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="container-new-fluid">
    <div class="row-new">
      
      <div class="col-12">
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
                        <a href="/supercombo-buggies-SlingShot-cana-com/">
                          <img style="width:100%;" src="//cdto.net/assets/thumbnails/combo002.jpg" alt="Combo Buggies + Horseback riding" title="Combo Buggies + Horseback riding">
                        </a>
                      </div>
                      <div class="caption">
                        <h4>Buggies + Horseback riding</h4>
                        <p><a href="/supercombo-buggies-SlingShot-cana-com/" class="btn btn-block btn-danger">Book Now</a>
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