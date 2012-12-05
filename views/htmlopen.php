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
		table {border-collapse: collapse;}
		table, td, th {border: solid 1px #ccc;}
		th {background: #e1e1e1;border-color: #999;}
		td, th {padding: 0.25em;font-size: 90%;}
		td.algo {font-weight: bold;}
		tr.on td {background: #f0f0f0;}
		.gohome{font-size: 8pt;margin-top:2em;}
		.gohome.top{margin-top: 0;margin-bottom: 2em;}
		.small {font-size: smaller;}
	</style>
    <?php if (!empty($importjQuery)) : ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <?php endif ?>
</head>
<body>
<?php
// Only show the back to home link on pages that are not the home page
if ($_SERVER['REQUEST_URI'] != '/'): 
?>
<div class="gohome top"><a href="/">&laquo; Back to start</a></div>
<?php endif; ?>

