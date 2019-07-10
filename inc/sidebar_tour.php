<!-- Sidebar
================================================== -->
<aside class="span4">   
  <div class="well-small">
    <a href="/guarantee/"><img style="display:block; margin-left:auto; margin-right:auto" src="//cdtoen-caribbeandream.netdna-ssl.com/assets/guarantee.jpg" alt="Risk Free Guarantee" /></a>
  </div>
  <div class="well-small">
    <a href="https://www.tripadvisor.com/Attraction_Review-g147293-d2073653-Reviews-Caribbean_Dream_Tours-Punta_Cana_La_Altagracia_Province_Dominican_Republic.html"><img style="display:block; max-width:165px; margin-left:auto; margin-right:auto" src="https://puntacanatours.com/images/tripadvisor.png" alt="TripAdvisor" title="Read our Reviews"/></a>
  </div>
  <div class="well-small">
    <span itemprop="telephone"><a href="tel:+18298681353"><img style="display:block; margin-left:auto; margin-right:auto" src="//cdtoen-caribbeandream.netdna-ssl.com/assets/call-dr-tours.png" alt="Call 1-829-868-1353 Today" /></a></span>
  </div>

  <div class="well-small">
    <?php
    $sql = "select * FROM reviews_v2 
    WHERE review_language = 1
    AND review_status = 1 
    ORDER BY RAND()
    LIMIT 4";
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
    <h4 style="color:#fe9208"><?php echo $review_title; ?></h4>
    <em style="font-size:1em">
      &ldquo;<?php echo $review_desc; ?>&rdquo;
    </em>
    <?php } ?>
  </div>
</aside>