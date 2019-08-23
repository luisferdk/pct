<header class="row-fluid header-2" style="display:flex;align-items:center;justify-content:center;">
  <div class="col-10 text-center">
    <strong><i class="fa fa-phone-square"></i> Звоните нам сейчас! <br></strong>
    <span class="visible-lg">TБЕСПЛАТНО ИЗ США И КАНАДЫ 844-DR-TOURS ДОМИНИКАНСКАЯ РЕСПУБЛИКА И ДРУГИЕ СТРАНЫ 829 961-4829</span>
    <span class="hide-lg">829 961-4829</span>
  </div>
  <a class="idioma" href="https://puntacanatours.es">
    <img src="/img/spain.png" alt="">
  </a>
</header>
<div class="navbar hide-lg">
  <div class="navbar-inner">
    <div class="container">
 
      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <ul class="nav pull-right">
        <li class="dropdown">
          <a href="/checkout.php" class="dropdown-toggle carrito" data-toggle="dropdown">
            <i class="fa fa-shopping-cart"></i>
            <span class="estela"><?php echo getItemCount(); ?></span>
          </a>
          <ul class="dropdown-menu">
            <?php if (isset($_SESSION["cart"])) {
              foreach ($_SESSION["cart"] as $item) { ?>
                <?php
                if (isset($item["link"])) {
                  $href_attribute = "href=\"/" . $item["link"] . "\"";
                } else {
                  $href_attribute = "";
                }
                ?>
                <li><a <?php echo $href_attribute; ?> class="plain"><?php echo $item["name"]; ?>
                    (<?php echo $item["quantity"]; ?>)
                    $<?php echo number_format($item["price"] * $item["quantity"], 2); ?></a></li>
              <?php }
          } ?>
            <li><a href="/checkout.php">Checkout</a></li>
            <!--
            <li><a href="/cart_empty.php">Empty shopping cart</a></li>
            -->
          </ul>
        </li>
      </ul>
 
      <!-- Be sure to leave the brand out there if you want it shown -->
      <a class="brand" href="/">
        <img src="//puntacanatours-caribbeandream.netdna-ssl.com/img/Caribbean.png" style="height:auto;" class="logo" alt="Punta Cana Tours" />
      </a>
 
      <!-- Everything you want hidden at 940px or less, place within here -->
      <div class="nav-collapse collapse">
        <ul class="nav menu">
          <li class="active"><a href="/">ГЛАВНАЯ</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> О НАС<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/about-us/">Who we Are </a></li>
              <li><a href="/why-us/">Why Choose Us? </a></li>
              <li><a href="/team/">Meet the Team</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">ЭКСКУРСИИ<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/excursions/top-tours/">Top 5 Tours</a></li>
              <li><a href="/excursions/all-tours/">All Tours</a></li>
              <li class="divider"></li>
              <li><a href="/excursions/day-tours/">All Day ЭКСКУРСИИ</a></li>
              <li><a href="/excursions/water-tours/">Water Tours</a></li>
              <li><a href="/excursions/adventure-tours/">Adventure Tours</a></li>
              <li><a href="/excursions/saona/">Saona Island</a></li>
              <li><a href="/excursions/cultural-tours/">Cultural ЭКСКУРСИИ</a></li>
              <li><a href="/excursions/kid-discounts/">Kid Discount</a></li>
              <li><a href="/excursions/dolphin-swim/">Swim With Dolphins</a></li>
              <li class="divider"></li>
              <li><a href="http://puntacanatours.es">Tours en Español</a></li>
              <li><a href="http://puntacanayachts.com">Private Boat Rentals</a></li>
              <li><a href="http://puntacanagroups.com">Group Tours</a></li>
            </ul>
          </li>
          <li><a href="/transportation/">ТРАНСФЕР В АЭРОПОРТ</a></li>
          <li><a href="/reviews/">ОТЗЫВЫ</a></li>
          <li><a href="/contact/">НАШИ КОНТАКТЫ</a></li>
          <li><a href="/excursions/combos/">ПАКЕТНЫЕ ТУРЫ</a></li>
        </ul>
      </div>
 
    </div>
  </div>
</div>

<div class="navbar visible-lg">
  <div class="nav-collapse collapse">
    <div class="header-1">
      <a class="brand" href="/">
        <img src="//puntacanatours-caribbeandream.netdna-ssl.com/img/Caribbean-Dream.png" height="100px" class="logo" alt="Punta Cana Tours" />
      </a>
      <ul class="nav menu">
        <li class="active "><a href="/">ГЛАВНАЯ</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> О НАС<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/about-us/">Кто мы </a></li>
            <li><a href="/why-us/">Почему выбрали нас? </a></li>
            <li><a href="/team/">Встретиться с командой</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> ЭКСКУРСИИ<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/excursions/top-tours/">5 лучших экскурсий</a></li>
            <li><a href="/excursions/all-tours/">Все туры</a></li>
            <li class="divider"></li>
            <li><a href="/excursions/day-tours/">Весь день ЭКСКУРСИИ</a></li>
            <li><a href="/excursions/water-tours/">Водные Туры</a></li>
            <li><a href="/excursions/adventure-tours/">Приключенческие туры</a></li>
            <li><a href="/excursions/saona/">Остров Саона</a></li>
            <li><a href="/excursions/cultural-tours/">культурный ЭКСКУРСИИ</a></li>
            <li><a href="/excursions/kid-discounts/">Детская скидка</a></li>
            <li><a href="/excursions/dolphin-swim/">Плавать с дельфинами</a></li>
            <li class="divider"></li>
            <li><a href="http://puntacanatours.es">Туры на испанском</a></li>
            <li><a href="http://puntacanayachts.com">Аренда частных лодок</a></li>
            <li><a href="http://puntacanagroups.com">Групповые туры</a></li>
          </ul>
        </li>
        <li><a href="/transportation/">ТРАНСФЕР В АЭРОПОРТ</a></li>
        <li><a href="/reviews/">ОТЗЫВЫ</a></li>
        <li><a href="/contact/">НАШИ КОНТАКТЫ</a></li>
        <li><a href="/excursions/combos/">ПАКЕТНЫЕ ТУРЫ</a></li>
      </ul>
      <div class="brand">
        <ul class="nav pull-right">
          <li class="dropdown">
            <a href="/checkout.php" class="dropdown-toggle carrito" data-toggle="dropdown">
              <i class="fa fa-shopping-cart"></i>
              <span class="estela"><?php echo getItemCount(); ?></span>
            </a>
            <ul class="dropdown-menu">
              <?php if (isset($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $item) { ?>
                  <?php
                  if (isset($item["link"])) {
                    $href_attribute = "href=\"/" . $item["link"] . "\"";
                  } else {
                    $href_attribute = "";
                  }
                  ?>
                  <li><a <?php echo $href_attribute; ?> class="plain"><?php echo $item["name"]; ?>
                      (<?php echo $item["quantity"]; ?>)
                      $<?php echo number_format($item["price"] * $item["quantity"], 2); ?></a></li>
                <?php }
            } ?>
              <li><a href="/checkout.php">Checkout</a></li>
              <!--
              <li><a href="/cart_empty.php">Empty shopping cart</a></li>
              -->
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>