<?php
require_once 'inc/config.php';

// unset checkout session 
	if(isset($_SESSION["checkout"]))
	    unset($_SESSION["checkout"]);
	setcookie("checkout", "", time()-3600);
	
	$_SESSION["cart"] = array();
	setcookie("cart", "", time()-3600);
	unset($_SESSION["checkout_step"]);

	header( 'Location: checkout.php' ) ;
	return;
?>
