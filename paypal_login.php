<?php session_start();

if(!isset($_SESSION['phpFlickr_auth_token']) OR isset($_GET['logout'])){
	$f->auth("read");
	exit;
}

require_once('config.php');
require_once('phpFlickr-3.1/phpFlickr.php');
require_once('tinypay-api/Tinypayme.php');

$tinypay = new Tinypayme(MASHAPE_KEY);

if(isset($_POST['photo']) AND !empty($_POST['photo'])){
	
	$_SESSION['post'] = $_POST['photo'];
	
	// request URL
		
	$request = $tinypay->getOAuthPermission(TINY_MARKETPLACE_ID, PROCESS_URL, 'create_items');
	
	if(isset($request->result->oauth_url)){
		
		header('Location: '.$request->result->oauth_url);
		exit;
		
	}
	
	// redirecting to PayPal
	
	
	
}
