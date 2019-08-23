<?
// PayPal Config
//$paypal_live_account = false; // True for live payments, false for Sandbox

if($paypal_live_account) {
	/* Live Site */
	$paypal_endpoint = "https://api-3t.paypal.com/nvp";
	$paypal_user = "tjmurray824_api1.yahoo.com";
	$paypal_pwd = "7YBGT3DHLW56MP4P";
	$paypal_signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31ARnWXUknKXlDy0okcxIAEt97bQrS";
	$paypal_checkout_link = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
}
else {
	/* Sandbox */
	$paypal_endpoint = "https://api-3t.sandbox.paypal.com/nvp";
	$paypal_user = "corydesautels+PuntaCanaMerchant_api1.gmail.com";
	$paypal_pwd = "1377117674";
	$paypal_signature = "ALh5CH8giXQ-9hEmtfjU5emPEHrjA08YnJ.LqDGTq5DfQKGwRQyJ7200";
	$paypal_checkout_link = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
}
?>