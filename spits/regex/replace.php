<?php
// Set the page title for handling output in the layouts
$pagetitle = 'Regular Expression Replacement Tester';

// Handle the request
$p = empty($_POST['pattern']) ? null : $_POST['pattern'];
$s = empty($_POST['subject']) ? null : $_POST['subject'];
$r = empty($_POST['replace']) ? ''   : $_POST['replace'];
$c = 0;
$o = null;

// If there was a request, handle it
if ($p && $s) {
	$o = preg_replace($p, $r, $s, -1, $c);
}

// Grab jQuery
$importjQuery = true;
?>
<form id="regex_form" method="post" action="">
(PERL) Pattern: <textarea name="pattern" rows="5" style="width:100%;"><?php echo $p ?></textarea>
<br /><br />
Subject: <textarea name='subject' rows="10" style="width:100%;"><?php echo $s ?></textarea>
<br /><br />
Replacement: <textarea name='replace' rows="10" style="width:100%;"><?php echo $r ?></textarea>
<br /><br />
<input type="submit" name="submit" value="Replace" />
</form>
<?php if (isset($o)): ?>
<br /><br />Replacements (<?php echo $c ?>):<br /><pre>
<?php echo htmlentities($o) ?> 
</pre>
<?php endif; ?> 
