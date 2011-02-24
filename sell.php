<?php session_start();

if(!isset($_SESSION['phpFlickr_auth_token']) OR isset($_GET['logout'])){
	$f->auth("read");
	exit;
}


echo '<pre>';
var_dump($_POST);
echo '</pre>';

exit;
?>

	<html>
	<head>

	<title>tinyFlickr (demo)</title>

	</head>

	<body style="font-family:Georgia;font-size:13px;margin:0px;">

		<div id="container" style="width:890px;background-color:#e3e3e3;margin-left:auto;margin-right:auto;padding:10px;overflow:auto;">

			<h1>tinyFlickr</h1>
			logged in as <?php echo $user['fullname'].' ('.$user['username'].')';?> &nbsp; <a href="index.php?logout">logout</a>

			<form action="sell.php" method="post">

				<?php foreach ($photos as $photo){?>

					<div class="photo" style="float: left; width: 100px; height: 105px; display: inline-block; margin-left: 10px;text-align:center;background-color:white;padding-top:10px;margin-bottom:10px;-moz-box-shadow: 3px 3px 4px #999;-webkit-box-shadow: 3px 3px 4px #999;box-shadow: 3px 3px 4px #999;">
						<img src="<?php echo $photo['url_sq'];?>" title="<?php echo $photo['title'];?>" style="border:1px #fff solid;margin-bottom:5px;"/> <br/>

						<input type="checkbox" name="photo_ids[]" value="<?php echo $photo['id'];?>" /> Sell this
					</div>

				<?php } ?>

			</form>

		</div>

	</body>
	</html>