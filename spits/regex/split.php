<?php
// Set the page title for handling output in the layouts
$pagetitle = 'Regular Expression Split Tester';

// Handle the request
$p = empty($_POST['pattern']) ? null : $_POST['pattern'];
$t = empty($_POST['target']) ? null : $_POST['target'];
if ($p && $t) {
	$m = preg_split($p, $t);
}
// Grab jQuery
$importjQuery = true;
?>
<form id="regex_form" method="post" action="">
(PERL) Pattern: <textarea name="pattern" rows="5" style="width:100%;"><?php echo $p ?></textarea>
<br /><br />
Target: <textarea name='target' rows="10" style="width:100%;"><?php echo $t ?></textarea>
<br /><br />
<input type="submit" name="submit" value="Check">
</form>
<?php if (isset($m)): ?>
<br /><br />Splits:<br /><pre>
<?php var_dump($m) ?> 
</pre>
<?php endif; ?> 
