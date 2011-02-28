<?php session_start();

/**
 * tinyFlickr - Feb 2011
 * The auth.php file has to be the return path of the Flickr Authentication process
 *
 * @author Melvin Tercan (http://twitter.com/melvinmt)
 * @link http://developers.tinypay.me
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once('config.php');

   $api_key                 = FLICKR_KEY;
   $api_secret              = FLICKR_SECRET;
   $default_redirect        = "index.php";
   $permissions             = "read";
   $path_to_phpFlickr_class = "phpFlickr-3.1/";


   require_once($path_to_phpFlickr_class . "phpFlickr.php");
   unset($_SESSION['phpFlickr_auth_token']);
    
if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
	$redirect = $_SESSION['phpFlickr_auth_redirect'];
	unset($_SESSION['phpFlickr_auth_redirect']);
}
   
   $f = new phpFlickr($api_key, $api_secret);

   if (empty($_GET['frob'])) {
       $f->auth($permissions, false);
   } else {
       $f->auth_getToken($_GET['frob']);
}

	header("Location: index.php");
