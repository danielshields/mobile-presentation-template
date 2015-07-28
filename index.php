<?php
	$projTitle = "";
	$displayType = "iphone"; // OPTIONS: iphone, ipad, desktop
	$ignore = array(
		'bower_components',
		'css',
		'img'
	);
	$assetPath = "./";
	if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/'){
		$assetPath = $_SERVER['REQUEST_URI'];
		if (strpos($_SERVER['REQUEST_URI'],'iphone/') !== false) {
			$displayType = "iphone";
		}
		include("template_proto.php");
	} else {
		include("template_nochoice.php");
	}
?>