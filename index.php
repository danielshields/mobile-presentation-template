<?php
	global $globalSettings;
	$globalSettings = (object) [
		'projectTitle' => 'ART21 Design Review',
		'projectDirectory' => '/art21design/',
		'displayType' => 'desktop',
		'ignore' => array(
			'css',
			'img',
			'assets',
			'js'
		),
		'assetPath' => './assets/',
		'resourcePath' => '../',
		'projectToRoot' => '../../',
		'filetype' => 'png',
		'maxWidth' => '1100px',
		'autoTOC' => true,
		'bgColor' => "#FFFFFF",
		'outdated' => array()
	];

	if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== $globalSettings->projectDirectory){
		$assetPath = $_SERVER['REQUEST_URI'];
		if (strpos($_SERVER['REQUEST_URI'],'iphone/') !== false || strpos($_SERVER['REQUEST_URI'],'mobile') !== false) {
			$globalSettings->displayType = 'iphone';
		}
		include("template_proto.php");
	} else {
		include("toc.php");
		include("template_nochoice.php");
	}
?>
