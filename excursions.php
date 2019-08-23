<?php
require_once 'inc/config.php';
require_once 'inc/cart-manager.php';

$uri = explode('/', $_SERVER['REQUEST_URI']);
if (sizeof($uri) > 1 && !empty($uri[1]))
  $page = $uri[1];

if (sizeof($uri) > 1 && !empty($uri[2]))
  $page2 = $uri[2];
?>

<?php require_once 'inc/meta.php'; ?>
<?php require_once 'inc/header.php'; ?>


<?php
  $sql = "select * FROM categories WHERE cat_url = '$page2'";
  $res = mysql_query($sql) or die(mysql_error());
  while ($row = MYSQL_FETCH_ARRAY($res)) {
    $cat_id = $row['cat_id'];
    $cat_name = $row['cat_name'];
    $cat_desc = $row['cat_desc'];
  }
?>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/">Home</a> <span class="divider">></span></li>
    <li><a href="/excursions/all-tours/">Excursions</a> <span class="divider">></span></li>
    <li class="active"><?php echo $cat_name; ?></li>
  </ul>
  <div class="row">
    <div class="span8">

      <!-- Main Content
      ================================================== -->
      <section class="main_body">
        <h1><?php echo $cat_name; ?></h1>
        <p><?php echo $cat_desc; ?></p>


        <table class="table" id="example">
          <thead>
            <tr>
              <th><?php echo $cat_name; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT *  FROM $toursTable AS t  JOIN tour_cat_prod AS r ON r.pd_id = t.t_id WHERE cat_id = $cat_id AND t_status <> 0 ORDER BY t_order ASC";
            $res = mysql_query($sql) or die(mysql_error());
            while ($row = MYSQL_FETCH_ARRAY($res)) {
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
              ?>
              <tr>
                <td>
                  <h4><a href="/<?php echo $tour_url; ?>/"><?php echo $tour_name; ?></a></h4>
                  <div class="row">
                    <div class="span3">
                      <a class="thumbnail" href="/<?php echo $tour_url; ?>/"><img src="<?php echo constant("CATEGORY_IMAGE_DIR"); echo $tour_thumbnail; ?>" alt="<?php echo $tour_name; ?>" title="<?php echo $tour_name; ?>"></a>
                    </div>
                    <div class="span9">
                      <p><?php echo $tour_desc_excerpt; ?></p>
                      <span class="span12"><a class="btn btn-warning pull-right" href="/<?php echo $tour_url; ?>/">Learn
                          more <i class="icon-chevron-right icon-white"></i></a></span>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </section><!-- /main_body -->
      <!-- <img src="/img/variable_ad_footer.png" alt="Variable Advert Footer" /> -->
    </div> <!-- /span8 (left column) -->

    <?php require_once 'inc/sidebar_tour.php'; ?>
  </div><!-- /row -->
</div><!-- /container -->

<?php require_once 'inc/footer.php'; ?>