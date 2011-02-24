<?php session_start();

require_once('config.php');
require_once('phpFlickr-3.1/phpFlickr.php');
require_once('tinypay-api/Tinypayme.php');

$f = new phpFlickr(FLICKR_KEY, FLICKR_SECRET);

if(!isset($_SESSION['phpFlickr_auth_token']) OR isset($_GET['logout'])){
	$f->auth("read");
	exit;
}

$tinypay = new Tinypayme(MASHAPE_KEY);
$request = $tinypay->getCurrencies();
$currencies = isset($request->result) ? $request->result : array();

$f = new phpFlickr(FLICKR_KEY, FLICKR_SECRET);

/*
echo '<pre>';
var_dump($_POST);
echo '</pre>';
*/

if(isset($_POST['photo_ids']) AND isset($_SESSION['photos'])){
	$photo_ids = $_POST['photo_ids'];
	
	$photos = $_SESSION['photos'];
	
	$user = $_SESSION['user'];
	
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
					
					$i = 0;
					foreach ($photo_ids as $photo_id){
		
						if(isset($photos[$photo_id])){
			
							$photo = $photos[$photo_id];
							
							?>
							
							<input type="hidden" name="photo[<?php echo $i;?>][id]" value="<?php echo $photo['id'];?>" />
							
							<div class="photo_edit">
								
								<div class="photo" style="height: 105px;background-color:white;padding:10px;margin-bottom:10px;width:870px;">	
									
									<div style="width:95px;display:inline-block;vertical-align:top;">
										<a href="<?php echo !empty($photo['url_l']) ? $photo['url_l'] : $photo['url_m'];?>" target="_blank"><img src="<?php echo $photo['url_sq'];?>" title="<?php echo $photo['title'];?>" style="border:1px #fff solid;margin-bottom:5px;-moz-box-shadow: 3px 3px 4px #999;-webkit-box-shadow: 3px 3px 4px #999;box-shadow: 3px 3px 4px #999;"/></a> <br/>
									</div>
									
									<div style="width:750px;display:inline-block;">
										Price: <input type="text" name="photo[<?php echo $i;?>][price]" value="9.99" /> 
										 <select name="photo[<?php echo $i;?>][currency]">
										<?php
											foreach ($currencies as $currency){
												echo '<option value="'.$currency->code.'">'.$currency->sign.' '.$currency->title.'</option>';
											}
										?>
										</select><br/>
										
										Title: <input type="text" name="photo[<?php echo $i;?>][title]" value="<?php echo $photo['title'];?>" size="55" /><br/>
										<textarea name="photo[<?php echo $i;?>][description]" style="width:425px;padding:5px;"><?php echo $photo['description'];?></textarea>
									</div>	
									
								</div>
								
							</div>
							
							<?php
							$i ++;
						}
		
					}
	
					?>
	
						</div>

				<div id="submit" style="text-align:right;width:890px;margin-left:auto;margin-right:auto;padding:10px;background-color:#e3e3e3;padding-bottom:100px;">
					<input type="submit" value="NEXT &raquo;" style="font-size:26px; />
				</div>


			</form>


		</body>
		</html>					
	
<?php
}

exit;
?>


