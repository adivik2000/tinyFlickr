<?php session_start();

require_once('config.php');
require_once('phpFlickr-3.1/phpFlickr.php');
require_once('tinypay-api/Tinypayme.php');

error_reporting(E_ALL);
ini_set('display_errors', true);

$f = new phpFlickr(FLICKR_KEY, FLICKR_SECRET);

if(!isset($_SESSION['phpFlickr_auth_token']) OR isset($_GET['logout'])){
	$f->auth("read");
	exit;
}

$tinypay = new Tinypayme(MASHAPE_KEY);

$user = $_SESSION['user'];	

if(!isset($_SESSION['tiny_access_token']) AND isset($_GET['code'])){
	
	$request = $tinypay->getOAuthAccessToken(TINY_ACCESS_TOKEN, $_GET['code']);
	
	echo '<pre>';
	var_dump($request);
	echo '</pre>';
	
	if(isset($request->result->access_token)){
		
		$_SESSION['tiny_access_token'] = $request->result->access_token;
		
		echo $_SESSION['tiny_access_token'];
	}
	
}

if(isset($_SESSION['tiny_access_token']) AND isset($_SESSION['post'])){
	
	while (@ob_end_flush()) {} 
	
	?>
	
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

		<title>tinyFlickr (demo)</title>

		</head>

		<body style="font-family:Georgia;font-size:13px;margin:0px;">

			<form action="paypal_login.php" method="post" style="margin:0px;">


				<div id="container" style="width:890px;background-color:#e3e3e3;margin-left:auto;margin-right:auto;padding:10px;overflow:auto;margin-bottom:0px;">

					<h1>tinyFlickr
						<span style="font-size:14px;font-weight:normal;font-style:italic;margin-left:20px;">logged in as <?php echo $user['fullname'].' ('.$user['username'].')';?> &nbsp; <a href="index.php?logout=1">logout</a></span>
					</h1>

					<?php

					foreach ($_SESSION['post'] as $item){
						
						$photo = $_SESSION['photos'][$item['id']];
				
					?>
										
						<div class="photo_insert">
							
							<div class="photo" style="background-color:white;padding:10px;margin-bottom:10px;width:870px;overflow:hidden;">	
								
								<div style="width:95px;display:inline-block;vertical-align:top;">
									<a href="<?php echo !empty($photo['url_l']) ? $photo['url_l'] : $photo['url_m'];?>" target="_blank"><img src="<?php echo $photo['url_sq'];?>" title="<?php echo $photo['title'];?>" style="border:1px #fff solid;margin-bottom:5px;-moz-box-shadow: 3px 3px 4px #999;-webkit-box-shadow: 3px 3px 4px #999;box-shadow: 3px 3px 4px #999;"/></a> <br/>
								</div>
								
									
									<?php
										// retrieve Flickr sizes
										echo '<p>retrieving Flickr sizes...';
										flush();
										
										$request = $f->photos_getSizes($photo['id']);
									
										// assume that largest size comes last:
										$large = $request[count($request)-1];
										$medium = $request[count($request)-2];
										
										echo ' this is the <a href="'.$large['source'].'" target="_blank">largest</a> one I could find!</p>';
										
										flush();
										
									?>
									
									<?php
									
										// save remote images in local folder
										echo '<p>saving remote images to local folder...';
										flush();
										
										// first, save medium image
										
										$ch = curl_init($medium['source']);
										$medium_local_path = ini_get('upload_tmp_dir').'/'.time().'_'.basename($medium['source']);
										$parse = parse_url($medium_local_path);
										$medium_local_path = $parse['path']; // clean up dirty query strings from file name
										
										$fh = fopen($medium_local_path, "w");
										
										curl_setopt($ch, CURLOPT_FILE, $fh);
										curl_exec($ch);
										curl_close($ch);
										fclose($fh);										
										
										// then, the large image
										
										$ch = curl_init($large['source']);
										$large_local_path = ini_get('upload_tmp_dir').'/'.time().'_'.basename($large['source']);
										$parse = parse_url($large_local_path);
										$large_local_path = $parse['path']; // clean up dirty query strings from file name
										
										$fh = fopen($large_local_path, "w");
										curl_setopt($ch, CURLOPT_FILE, $fh);
										curl_exec($ch);
										curl_close($ch);
										
										echo ' done!</p>';
																				
										flush();
										
									?>

									<?php
										// upload to tinypay
										
										echo '<p>uploading medium image as image to tinypay.me..'; 
										flush();
										
										$mashape_token = TokenUtil::requestToken(MASHAPE_KEY);
					
										// construct upload url
										$upload_url = 'https://tinypay.me/mashape';
																				
										$ch = curl_init();
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_VERBOSE, 0);
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
									    curl_setopt($ch, CURLOPT_URL, $upload_url);
									    curl_setopt($ch, CURLOPT_POST, true);
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
										
									    $post = array(
									        'file' => '@'.$medium_local_path,
											'_token' => $mashape_token,
											'_method' => 'uploadImage',
											'access_token' => $_SESSION['tiny_access_token'],
									    );
									    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
									
									    $response = curl_exec($ch);
										
										if(!empty($response)){
											
											$response = json_decode($response);
											
											if(isset($response->result->thumbnail)){
												
												$image_token = $response->result->token;
												
												echo ' done! see <a href="'.$response->result->thumbnail.'" target="_blank">thumbnail</a><p>';
												
											}else{
												
												echo 'upload failed.. aborting mission..';
												break;
											}	
											
										}
										
										flush();
										
									?>


									<?php
										// upload to tinypay

										echo '<p>uploading large image as file to tinypay.me..'; 
										flush();

										$mashape_token = TokenUtil::requestToken(MASHAPE_KEY);

										// construct upload url
										$upload_url = 'https://tinypay.me/mashape';

										$ch = curl_init();
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_VERBOSE, 0);
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
									    curl_setopt($ch, CURLOPT_URL, $upload_url);
									    curl_setopt($ch, CURLOPT_POST, true);
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);

									    $post = array(
									        'file' => '@'.$large_local_path,
											'_token' => $mashape_token,
											'_method' => 'uploadFile',
											'access_token' => $_SESSION['tiny_access_token'],
									    );
									    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 

									    $response = curl_exec($ch);
										
										if(!empty($response)){

											$response = json_decode($response);

											if(isset($response->result->token)){
												
												$file_token = $response->result->token;
												echo ' done!<p>';

											}else{

												echo 'upload failed.. aborting mission..';
												break;
											}	

										}

										flush();

									?>

									<?php
										// preparing an item..
										
										echo '<p>preparing the item data..'; 
										
										$data = array(
											'title' => stripslashes($item['title']),
											'description' => stripslashes($item['description']),
											'price' => (float) $item['price'],
											'currency' => $item['currency'],
											'image_tokens' => $image_token,
											'file_token' => $file_token,
											'quantity' => -1,
											'geo_latitude' => $photo['latitude'],
											'geo_longitude' => $photo['longitude'],
										);
										
										if(!empty($photo['tags'])){
											$data['tags'] = implode(',', explode(' ',$photo['tags']));
										}else{
											$data['tags'] = null;
										}
										
										echo '<pre>';
										print_r($data);
										echo '</pre>';
										
										$data['access_token'] = $_SESSION['tiny_access_token'];
										
										flush();
										
									?>
									
									<?php
									
										// creating an item on tinypay..

										echo '<p>creating an item on tinypay..'; 

										$request = $tinypay->createItem(
												$access_token = $data['access_token'], 
												$title = $data['title'], 
												$currency = $data['currency'], 
												$price = $data['price'], 
												$description = $data['description'], 
												$tags = $data['tags'], 
												$quantity = $data['quantity'], 
												$require_shipment_address = null, 
												$shipment_countries = null, 
												$shipment_costs = null, 
												$shipment_costs_per_item = null,
												$geo_latitude = $data['geo_latitude'], 
												$geo_longitude = $data['geo_longitude'], 
												$image_tokens = $data['image_tokens'], 
												$file_token = $data['file_token'], 
												$video_url = null, 
												$charity_id = null, 
												$charity_percentage = null, 
												$language = null, 
												$country = null, 
												$marketplace_category_id = null
												);
										
										if(isset($request->result->item_id)){
											
											$item_id = $request->result->item_id;
											
											echo ' done! see <a href="http://tinypay.me/~'.$item_id.'" target="_blank">http://tinypay.me/~'.$item_id.'</a><p>';
											
											echo '<p><a href="http://tinypay.me/~'.$item_id.'" target="_blank"><img src="http://img.tinypay.me/btn/'.$item_id.'"  border="0" title="'.$data['title'].'"/></a></p>';
										}else{
											
											echo ' omg it failed! aborting mission..';
											break;
										}
										
										flush();

									?>
								
														
							</div>
							
						</div>
			
				
					<?php 

					}

					?>

	
<?php
	
	
	
}