<?
require_once 'inc/config.php';

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
   }
   return $isValid;
}   
require_once ( './captcha/class.captcha_x.php');
$captcha = &new captcha_x ();

  $review_title = clean($_POST['title']);
  $review_desc = clean($_POST['review']);
  $review_author = clean($_POST['name']);
  $review_email = clean($_POST['email']);
  $review_rating = clean($_POST['score']);
  $review_date = date('Y-m-d');

$_SESSION["review_form"] = $_POST;
  
if ( ! $captcha->validate ( $_POST['captcha'])) 
{
$_SESSION['c_error'] = 1;
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
header("Location: /reviews/?sorry#show_form");
exit();
}
if(!$review_author || !$review_email || !$review_desc || !$review_title)
{
$_SESSION['c_error'] = 2;
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
header("Location: /reviews/?sorry#show_form");
exit();
}
if(!validEmail($review_email))
{
$_SESSION['c_error'] = 3;
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
header("Location: /reviews/?sorry#show_form");
exit();
}

$email = preg_replace("([\r\n])", "", $review_email);
$find = "/(content-type|bcc:|cc:)/i";
if (preg_match($find, $review_title) || preg_match($find, $review_email)) 
{
$_SESSION['c_error'] = 3;
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
header("Location: /reviews/?sorry#show_form");
exit();
}
  
$sql = "insert into reviews_v2 
(
review_title,
review_desc,
review_author,
review_email,
review_rating,
review_date
)
values
(
'$review_title',
'$review_desc',
'$review_author',
'$review_email',
'$review_rating',
'$review_date'
)
";
$res = mysql_query($sql) or die(mysql_error());

header("Location: /reviews/?thankyou");
exit();
?>