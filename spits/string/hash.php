<?php
// Set up the page title right up front
$pagetitle = 'String Hasher';

/* Get the posted value of the form if there is one */
$p = empty($_POST['p']) ? null : $_POST['p'];
?>

<h1><?php echo $pagetitle ?></h1>
<form method="post" action="">
	<p>
		<label for="p">Enter a string to hash:</label><br />
		<input id="p" type="text" name="p" value="<?php echo $p ?>" /><br />
	</p>
	<p><input type="submit" name="submit" value="Hash It" /></p>
</form>

<?php /* If there is an input string handle it */ ?>
<?php if ($p): ?>
<hr />
<h2>Table of hash values for <em>&quot;<?php echo $p ?>&quot;</em> based on algorithm</h2>
<table>
	<tr>
		<th>&nbsp;</th>
		<th>Algorithm</th>
		<th>Char Length</th>
		<th>Hashed value of <em>&quot;<?php echo $p ?>&quot;</em></th>
	</tr>
	<?php $on = false; $x = 0; foreach (hash_algos() as $algo): $hash = hash($algo, $p); ?> 
	<tr<?php if ($on): ?> class="on"<?php endif; ?>>
		<td class="loop"><?php echo ++$x ?></td>
		<td class="algo"><?php echo $algo ?></td>
		<td class="size"><?php echo strlen($hash) ?></td>
		<td class="hash"><?php echo $hash ?></td>
	</tr>
<?php $on = !$on; endforeach; ?> 
</table>
<?php endif; ?>
