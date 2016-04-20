<?php
	$projTitle = "projectname";
	$displayType = "desktop"; // OPTIONS: iphone, ipad, desktop
	$ignore = array(
		'bower_components',
		'css',
		'img',
		'assets'
	);
	$assetPath = "./";
	if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/projectname/'){
		$assetPath = $_SERVER['REQUEST_URI'];
		if (strpos($_SERVER['REQUEST_URI'],'iphone/') !== false || strpos($_SERVER['REQUEST_URI'],'mobile') !== false) {
			$displayType = "iphone";
		}
		include("template_proto.php");
	} else {
		include("template_nochoice.php");
	}
?>