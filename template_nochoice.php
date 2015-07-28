<!doctype html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php if($projTitle !== ""){ echo $projTitle . ' | '; }?>CHIPS</title>
	<meta name="viewport" content="width=device-width">
	<link href='http://fonts.googleapis.com/css?family=Cousine:400,700,400italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php print $assetPath; ?>css/style.css">
</head>
<body>
	<div class="no-choice">
		<h1><a href="http://www.chips-ny.com">CHIPS</a></h1>
		<?php
			$dirs = array_filter(glob('*'), 'is_dir');
			print '<ul id="dirlist">';
			foreach($dirs as $dir){ if(!in_array($dir,$ignore)){
				print '<li><a href="' . $dir . '">' . $dir . '</a></li>';
			}}
			print '</ul>';
		?>
	</div>
</body>
</html>

