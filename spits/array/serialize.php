<?php
$pagetitle = 'Array (Un)Serializer';

// Add in our js files
$importjQuery = true;
$jsFiles = array('array_serialize');

// Handle the request
$i = Request::post('input');
$v = Request::post('varname', 'array', true); // Force 'array' for empty field vals
$o = null;
$s = Request::post('serialize') !== null;

// If there is input...
if ($i) {
	if ($s) {
		// This is a serialize request, so make it 'clean' PHP by removing any
		// variable assignments and ending semicolons. Do this after simple
		// validation of the input
		$p = '#(\$(.*)\s{0,1}=\s{0,1})#';
		$input = rtrim(trim($i), ';');
		preg_match_all($p, $input, $m);

		// We really only want to handle one variable
		if (!empty($m[0]) && count($m[0]) > 1) {
			$o = 'IT IS KINDA DANGEROUS TO ADD MORE THAN ONE VARIABLE TO THIS TESTER. TSK TSK.';
		} else {
			$input = preg_replace($p, '', $input);
			// Now add back in the variable assignment and semicolon
			$input = '$array = ' . $input . ';';

			// Dangerous, yes, but our own manipulation should have made it so that
			// even if something malicious was brought in, this will cause it to be 
			// not executable PHP.
			eval($input);
			$o = serialize($array);
		}
	} else {
		$o = unserialize($i);
		$o = '$' . $v . ' = ' . var_export($o, true) . ';';
	}
}
?>
<form id="regex_form" method="post" action="">
Input: <textarea name="input" rows="5" style="width:100%;"><?php echo $i ?></textarea>
<br />
Serialize: <input type="checkbox" id="serialize" name="serialize"<?php if($s): ?> checked="checked"<?php endif; ?> />
<div id="varname-wrapper">
	PHP variable name: <input type="text" name="varname" id="varname" value="<?php echo $v ?>" />
</div>
<br /><br />
<input type="submit" name="submit" value="Process" />
</form>
<?php if ($o): ?>
<hr />
Output:<br /><pre>
<?php print_r($o) ?> 
</pre>
<?php endif; ?> 
