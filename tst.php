<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test dropdown</title>
  <link href='/css/combined.css' rel='stylesheet'>
<!--
  <link href='/css/bootstrap.css' rel='stylesheet'>
-->

</head>
<body onload itemscope itemtype="http://schema.org/WebPage">
<header class="container">

  <div class="navbar">
    <div class="navbar-inner">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
	  
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Actions 1<b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="#">Action 1.1</a></li>
                  <li><a href="#">Action 1.2</a></li>
                  <li><a href="#">Action 1.3</a></li>
             </ul>
		  </li>	 
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Actions 2<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#">Action 2.1</a></li>
                <li><a href="#">Action 2.2</a></li>
                <li><a href="#">Action 2.3</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /nav-collapse -->	    
    </div><!-- /navbar-inner -->
  </div><!-- /navbar -->
</header>


<div class="container">


</div><!-- /container -->

<!-- Jquery, of course -->
<script src="/js/jquery.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="/js/bootstrap.js" type="text/javascript"></script>
</body>
</html>
