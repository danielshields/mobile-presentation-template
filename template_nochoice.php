<?php global $globalSettings; 
require_once("toc.php");
?>
<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php if($globalSettings->projectTitle !== ""){ echo $globalSettings->projectTitle . ' | '; }?>CHIPS</title>
	<meta name="viewport" content="width=device-width">
	<link href='http://fonts.googleapis.com/css?family=Cousine:400,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php print $globalSettings->resourcePath; ?>css/style.css">
</head>
<body>
	<div class="no-choice">
		<h1><a href="//chips.nyc">CHIPS</a></h1>
		<?php
			print '<ul id="dirlist">';
			if($globalSettings->autoTOC === true){
				$dirs = array_filter(glob($globalSettings->assetPath . '*'), 'is_dir');
				foreach($dirs as $dir){ if(!in_array($dir,$globalSettings->ignore)){
					$displayDir = str_replace($globalSettings->assetPath,"",$dir);
					print '<li><a href="' . $displayDir . '/">' . $displayDir . '</a></li>';
				}}
			} else {
				foreach($toc as $tocItem) {
					print '<li><a href="' . $tocItem[0] . '/">' . $tocItem[1] . '</a></li>';	
				}
			}
			print '</ul>';
		?>
	</div>
</body>
</html>

