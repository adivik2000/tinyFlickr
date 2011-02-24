<?php
session_start();

// a tiny flickr implementation

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

$tinypay = new Tinypayme(MASHAPE_KEY);

$request = $f->auth_checkToken();
	if(isset($request['user'])){
	$user = $request['user'];	
}

$params = array(
	'extras' => 'description,date_taken,original_format,geo,tags,url_sq,url_l,url_m',
);

$request = $f->people_getPhotos($user['nsid'], $params);

// echo '<pre>';
// var_dump($photos);
// echo '</pre>';

if(!empty($request)){
	
	$photos = array();
	
	foreach ($request['photos']['photo'] as $photo){
		
		// http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret}.jpg
		
		// $url = 'http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_t.jpg';
		
		// echo '<p>'.$url.'</p>';
		
		// echo '<img src="'.$url.'" style="float:left;margin:2px;" />';
		
		// $url = 'http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_s.jpg';
		// echo '<img src="'.$url.'" style="float:left;margin:2px;" />';
		
		
		$photos[] = $photo;
		
	}

}

?>

<html>
<head>

<title>tinyFlickr (demo)</title>

</head>

<body style="font-family:Georgia;font-size:13px;margin:0px;">

	<div id="container" style="width:890px;background-color:#e3e3e3;margin-left:auto;margin-right:auto;padding:10px;overflow:auto;">
		
		<h1>tinyFlickr
			<span style="font-size:14px;font-weight:normal;font-style:italic;margin-left:20px;">logged in as <?php echo $user['fullname'].' ('.$user['username'].')';?> &nbsp; <a href="index.php?logout=1">logout</a></span>
		</h1>
		
		<form action="sell.php" method="post">
			
			<?php foreach ($photos as $photo){?>
				
				<div class="photo" style="float: left; width: 100px; height: 105px; display: inline-block; margin-left: 10px;text-align:center;background-color:white;padding-top:10px;margin-bottom:10px;-moz-box-shadow: 3px 3px 4px #999;-webkit-box-shadow: 3px 3px 4px #999;box-shadow: 3px 3px 4px #999;">
					<a href="<?php echo !empty($photo['url_l']) ? $photo['url_l'] : $photo['url_m'];?>" target="_blank"><img src="<?php echo $photo['url_sq'];?>" title="<?php echo $photo['title'];?>" style="border:1px #fff solid;margin-bottom:5px;"/></a> <br/>
					
					<input type="checkbox" name="photo_ids[]" value="<?php echo $photo['id'];?>" /> Sell this
				</div>
				
			<?php } ?>
			
			<div id="sell" style="width:500px;">
				
				<div style="width:50%;">
					<input type="text" name="price" />
					
					<select name="currency">
						
						<?php
							
							$request = $tinypay->getCurrencies();
							
							foreach ($request->result as $currency){
								echo '<option value="'.$currency->code.'">'.$currency->sign.' '.$currency->title.'</option>';
							}
						?>
						
					</select>
				</div>
				
			</div>
			
		</form>
		
	</div>

</body>
</html>