<?php global $globalSettings;
	function getLastPathSegment($url) {
		$path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
		$pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
		$pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

		if (substr($path, -1) !== '/') {
			array_pop($pathTokens);
		}
		return end($pathTokens); // get the last segment
	}

	$currentDirectory = getLastPathSegment($_SERVER['REQUEST_URI']);

	$pathToAssets = $globalSettings->assetPath . $currentDirectory;
	$images = glob($pathToAssets . "/*.".$globalSettings->filetype);

	$extraClass = "";
	if (in_array($currentDirectory, $globalSettings->outdated)) {
		$extraClass .= " outdated";
	}
?>
<!DOCTYPE html>
<html ng-app="App">
<head>
	<meta charset="utf-8">
	<title><?php print $projTitle; ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="fragment" content="!">
	<link rel="stylesheet" href="<?php print $globalSettings->projectToRoot; ?>css/style.css">
	<style>
		.presentation-wrap { max-width:<?php print $globalSettings->maxWidth; ?>; }
		body { background-color:<?php print $globalSettings->bgColor; ?>; }
	</style>
	<?php 
		$settingsFile = $pathToAssets.'/settings.php';

		if (file_exists($settingsFile)) {
			include($settingsFile);
		}
	?>
</head>

<body class="proto <?php print $displayType; print $extraClass; ?>" style="background-color:<?php echo $globalSettings->bgColor; ?>">

<div keypress ng-click="presentationCtrl.hideInstructions();" ng-swipe-left="presentationCtrl.navImg('next')" ng-swipe-right="presentationCtrl.navImg('prev')"  ng-controller="presentationController as presentationCtrl" ng-init="init(<?php print count($images); ?>)">
	<div class="instructions-wrap <?php if ($globalSettings->showInstructions) print 'showInstructions'; ?>">
		<div class="instructions">
			<div class="inner">
				<p>Use the <u>arrow keys</u>, or click on the <u>left and right edges of the slide</u> to cycle through the presentation.</p>
				<p>Use the <u>esc key</u> to return to the table of contents.</p>
			</div>
		</div>
	</div>
	<div  class="presentation-wrap">
		<ul class="presentation-images">
			<?php
				$trackImg = 1;
				foreach($images as $image){
			?>
			<li class="presentation-item-<?php print $trackImg; ?>" test-header="0" img-src="<?php print $globalSettings->projectToRoot . $image ?>" ng-class="{'active' : activeSlide === <?php print $trackImg; ?>}"></li>
			<?php 
				$trackImg = $trackImg + 1;
				}
			?>
		</ul>
		<span class="image-nav prev-img" ng-click="presentationCtrl.navImg('prev')">&lt;</span>
		<span class="image-nav next-img" ng-click="presentationCtrl.navImg('next')">&gt;</span>
	</div>
</div>

<script src="<?php print $globalSettings->projectToRoot; ?>js/modernizr-custom.js"></script>
<script src="<?php print $globalSettings->projectToRoot; ?>js/angular.min.js"></script>
<script src="<?php print $globalSettings->projectToRoot; ?>js/angular-touch.min.js"></script>
<script src="<?php print $globalSettings->projectToRoot; ?>js/jquery-3.1.1.min.js"></script>
<div ng-view></div>

<script>
var App = angular.module('App', ['ngTouch']);

App.controller('presentationController',['$scope','$location',function($scope, $location){
	var caroCtrl = this;
	$scope.activeSlide = 1;
	$scope.totalSlides = 3;
	if ($location.path() !== '') {
		$scope.activeSlide = parseInt($location.path().split('/')[1]);
	}
	$scope.init = function(numItems){
		$scope.totalSlides = numItems;
		if($(".annotation-"+$scope.activeSlide).hasClass("annotation")){
			$(".annotations").removeClass("none-available");
		} else {
			$(".annotations").addClass("none-available");
		}
	};

	this.hideInstructions = function() {
		$('.instructions-wrap').hide();
	};

	this.navImg = function(direction){
		if(direction === "next"){
			$scope.activeSlide++;
		} else {
			$scope.activeSlide--;
		}
		if($scope.activeSlide > $scope.totalSlides){
			$scope.activeSlide = 1;
		}
		if($scope.activeSlide < 1){
			$scope.activeSlide = $scope.totalSlides;
		}
		$location.path($scope.activeSlide);
		if(typeof(scrollPoints) !== "undefined"){
			if(typeof(scrollPoints[$scope.activeSlide]) !== "undefined"){
				setTimeout(function(){
					$('html,body').scrollTop(scrollPoints[$scope.activeSlide]);
				},1);
			} else {
				document.body.scrollTop = document.documentElement.scrollTop = 0;
			}
		} else {
			document.body.scrollTop = document.documentElement.scrollTop = 0;
		}

		$(".annotation").removeClass("active");
		if(typeof(annotations) !== "undefined"){
			if(typeof(annotations[$scope.activeSlide]) !== "undefined"){
				setTimeout(function(){
					$(".annotation-"+$scope.activeSlide).addClass("active");
				},1);
			}
		}
		if($(".annotation-"+$scope.activeSlide).hasClass("annotation")){
			$(".annotations").removeClass("none-available");
		} else {
			$(".annotations").addClass("none-available");
		}
	};
}]);

App.directive('testHeader', function() {
    return {
        restrict: 'A',
        scope: {
        },
        compile: function(element, attrs) {
            var type = attrs.type || 'text';
            var required = attrs.hasOwnProperty('required') ? "required='required'" : "";
            var htmlText = '<div class="header" style="z-index:2;height:' + attrs.testHeader +'px;width:100%;background:url('+attrs.imgSrc +') 0% 0% no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"></div>'+
            	'<div class="scroller" style="z-index:1;top:0;left:0;width:100%;height:100%;"><img src="' + attrs.imgSrc + '" border="0" /></div>';
            element.html(htmlText);
        }

    };
});

App.directive('keypress', ['$document',  function ($document) {
	return  function (scope, element, attrs) {
		$document.bind("keydown keypress", function (event) {
			$(".instructions-wrap").hide();

			if(event.which === 39) {
				scope.$apply(function (){
					scope.$eval("presentationCtrl.navImg('next')");
				});
				event.preventDefault();
			} else if (event.which === 37) {
				scope.$apply(function (){
					scope.$eval("presentationCtrl.navImg('prev')");
				});
				event.preventDefault();
			} else if(event.which === 27 || event.which === 38){
				window.location = "../";
			} else {

			}
		});
	};
}]);

if ($(".instructions-wrap").hasClass("showInstructions")) {
	setTimeout(function() {
		$(".instructions-wrap").removeClass("showInstructions");
	}, 5000);
}

if($("body").hasClass("outdated")){
	$("body").append("<div style=\"position:fixed;top:0;left:0;width:100%;text-align:center;background-color:rgb(192, 53, 56);color:#fff;font-size:14px;line-height:150%;font-family:Helvetica,sans-serif;padding:5px 0;\">There is an updated version of this presentation. <a href=\"<?php print $globalSettings->projectDirectory; ?>\" style=\"color:#fff;\">See all versions</a>.</div>");
}

if(typeof(annotations) !== "undefined"){
	$("body").append('<div class="annotations"><span class="annotate-helper">i</span></div>');
	for (var key in annotations) {
		if (annotations.hasOwnProperty(key)) {
			$(".annotations").append('<div class="annotation annotation-' + key+'">' + annotations[key] + '</div>');
		}
	}
}

$(".annotate-helper").on("click",function(){
	$(".annotations").toggleClass("annotations-on");
});

</script>

</body>
</html>
