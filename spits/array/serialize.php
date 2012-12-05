<?php
$pagetitle = 'Array (Un)Serializer';

$i = empty($_POST['input']) ? null : $_POST['input'];
$o = null;
$s = !empty($_POST['serialize']);

if ($i) {
	$func = 'serialize';
	if (!$s) $func = 'un' . $func;
	$o = $func($i);
}
?>
<form id="regex_form" method="post" action="">
Input: <textarea name="input" rows="5" style="width:100%;"><?php echo $i ?></textarea>
<br />
Serialize: <input type="checkbox" name="serialize"<?php if($s): ?> checked="checked"<?php endif; ?> />
<br /><br />
<input type="submit" name="submit" value="Process" />
</form>
<?php if ($o): ?>
<hr />
Output:<br /><pre>
<?php var_dump($o) ?> 
</pre>
<?php endif; ?> 
