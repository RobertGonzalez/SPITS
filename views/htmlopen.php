<?php
/**
 * If you want to add anything to the HTML header segment do it here. You can
 * define your own styles sheets, javascripts, doctypes, etc.
 * 
 * The only expectation this include has is the $pagetitle variable, but even 
 * that isn't required as it will be set in the output controller.
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<title><?php echo $pagetitle ?></title>
	<style>
		body{font-family:Verdana;}
		a,a:visited{color:#00c;}
		#gohome{font-size: 8pt;margin-top:2em;}
	</style>
    <?php if (!empty($importjQuery)) : ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <?php endif ?>
</head>
<body>
