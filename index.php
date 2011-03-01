<?php

/**
 * tinyFlickr - Feb 2011
 *
 * @author Melvin Tercan (http://twitter.com/melvinmt)
 * @link http://developers.tinypay.me
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

session_start();

if(!isset($_GET['login'])){
	session_destroy();
	session_start();
}

// set variables
$_SESSION['photos'] = array();
$_SESSION['user'] = null;

require_once('config.php');
require_once('phpFlickr-3.1/phpFlickr.php');
require_once('tinypay-api/Tinypayme.php');

$f = new phpFlickr(FLICKR_KEY, FLICKR_SECRET);

if(isset($_GET['logout'])){
	unset($_SESSION['phpFlickr_auth_token']);
	header("Location: http://www.flickr.com/logout.gne");
	exit;
}

if(!isset($_SESSION['phpFlickr_auth_token'])){
	$f->auth("read");
	exit;
}

$request = $f->auth_checkToken();
	if(isset($request['user'])){
	$user = $request['user'];	
	$_SESSION['user'] = $user;
}

$params = array(
	'extras' => 'description,date_taken,original_format,geo,tags,url_sq,url_l,url_m',
);

$request = $f->people_getPhotos($user['nsid'], $params);

if(!empty($request)){
	
	$photos = array();
	
	foreach ($request['photos']['photo'] as $photo){
				
		$photos[$photo['id']] = $photo;
		
	}
	
	$_SESSION['photos'] = $photos;

}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<title>tinyFlickr (demo)</title>

</head>

<body style="font-family:Georgia;font-size:13px;margin:0px;">

	<form action="sell.php" method="post" style="margin:0px;">
	

		<div id="container" style="width:890px;background-color:#e3e3e3;margin-left:auto;margin-right:auto;padding:10px;overflow:auto;margin-bottom:0px;">
		
			<h1>tinyFlickr
				<span style="font-size:14px;font-weight:normal;font-style:italic;margin-left:20px;">logged in as <?php echo $user['fullname'].' ('.$user['username'].')';?> &nbsp; <a href="index.php?logout=1">logout</a></span>
			</h1>
		
			
				<?php foreach ($photos as $photo){?>
				
					<div class="photo" style="float: left; width: 100px; height: 105px; display: inline-block; margin-left: 10px;text-align:center;background-color:white;padding-top:10px;margin-bottom:10px;-moz-box-shadow: 3px 3px 4px #999;-webkit-box-shadow: 3px 3px 4px #999;box-shadow: 3px 3px 4px #999;">
						<a href="<?php echo !empty($photo['url_l']) ? $photo['url_l'] : $photo['url_m'];?>" target="_blank"><img src="<?php echo $photo['url_sq'];?>" title="<?php echo $photo['title'];?>" style="border:1px #fff solid;margin-bottom:5px;"/></a> <br/>
					
						<input type="checkbox" name="photo_ids[]" value="<?php echo $photo['id'];?>" /> Sell this
					</div>
				
				<?php } ?>
			
			
		</div>
	
		<div id="submit" style="text-align:right;width:890px;margin-left:auto;margin-right:auto;padding:10px;background-color:#e3e3e3;padding-bottom:100px;">
			<input type="submit" value="NEXT &raquo;" style="font-size:26px;" />
		</div>
	
	
	</form>
	

</body>
</html>