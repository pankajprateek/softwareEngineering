<!DOCTYPE HTML>
<html>
      <head>
	      <meta charset = "utf8">
	      <title>Cloud Storage Simplified</title>
	      <link rel="stylesheet" href="bootstrap/css/bootstrap.css"  type="text/css"/>
	      <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	      <script src="bootstrap/js/bootstrap.js"></script>
      </head>
      <body>

	<div class = "container">


		<?php session_start();
		// Include the Box_Rest_Client class
		include('box-php-sdk-master/lib/Box_Rest_Client.php');
		require_once 'Dropbox.class.php';
							
		// Set your API Key. If you have a lot of pages reliant on the 
		// api key, then you should just set it statically in the 
		// Box_Rest_Client class.
		$api_key = '86slra9tek0b1gccb9iwy1ualyc2qqk5';
		$box_net = new Box_Rest_Client($api_key);
		$nl = "<br>\n";
				
		//echo "here";

		if(!array_key_exists('auth',$_SESSION) || empty($_SESSION['auth'])) {
		$_SESSION['auth'] = $box_net->authenticate();
		//echo $_SESSION['auth']."<br/>";
		}
		else {
		// If the auth $_SESSION key exists, then we can say that 
		// the user is logged in. So we set the auth_token in 
		// box_net.
		$box_net->auth_token = $_SESSION['auth'];
		//echo $_SESSION['auth']."<br/>";
		} 
		//echo $box_net->auth_token."<br/>";
		$folder = $box_net->folder(0); 
		//var_dump($folder->file);
		//echo $nl.$nl;

		//var_dump($folder->file);
		//echo "<br/>";

		$arr = array();
		foreach ($folder->file as $try) {
			//var_dump($try);
			$t = (array)$try;       
			foreach($t as $k => $v) {
				//var_dump($v);
				if($v['file_name']) {
					$arr[] = array("path" => $v['file_name'], "is_dir" => $v['is_dir'], "last_modified" => $v["updated"], "stored_at" => "Box.net");
				}		
			}    
			//var_dump($t);
			//var_dump($p);
			//echo $nl.$nl;
			//var_dump($t["file_name"]);
			//echo "<br/><br/>";
		}

		echo $nl.$nl;
		//var_dump($arr);
		$dropbox = new Dropbox();
		echo $dropbox->getHTML($arr);

		//var_dump($folder->file);
		?>
		</div>
	</body>
</html>
