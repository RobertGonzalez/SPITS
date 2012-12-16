<?php
$pagetitle = 'Table Maker';

// Setup form inputs
$text      = Request::post('text');
$summary   = Request::post('summary');
$caption   = Request::post('caption');
$trimlines = Request::post('trimlines', 0);
$headerrow = Request::post('headers') !== null;

// Build our output
$out  = '';

// If there was text presented to tablize...
if ($text) {
	// Clean up our output a little bit
	$text = trim($text);
	
	// Start by handling the table tag and summary if there is one...
	$tabletag = '<table';
	if ($summary) {
		$tabletag .= ' summary="' . $summary . '"';
	}
	$tabletag .= '>';
	
	// Now get each line of the input...
	$lines = explode("\n", $text);
	
	// Open our output with our table tag
	$out = "
	$tabletag";
	
	// Add in the caption if there is one
	if ($caption) {
		$out .= '
	<caption>' . $caption . '</caption>';
	}
	
	// Set the empty row flag to false for now
	$emptyrow = false;
	
	// Set the empty row skip flag
	$emptyrowskip = false;
	
	// Set the ROW ON flag
	$rowon = false;
	
	// Now build the table proper...
	for ($i = 0, $l = count($lines); $i < $l; $i++) {
		// Set the previous row empty flag for use in grouping
		$prevrowempty = $emptyrow;
		
		// Set up an alternating class name
		$rowclass = $rowon ? 'row-off' : 'row-on';
		
		// Open the table row, with alternating class names and HTML formatting...
		$out .= '
		<tr class="' . (($i) ? $rowclass : 'row-heading') . '">';
		
		// Build the cell wrapper for each element in the row
		$wrapper = $i == 0 && $headerrow ? '<th>__T__</th>' : '<td>__T__</td>';
		
		// Get the tab separated parts of each row
		$parts = explode("\t", trim($lines[$i]));
		
		// Get the cell count for this row
		$cellcount = count($parts);
		
		//  Get our column count for the very first row
		if ($i == 0) {
			$colcount = $cellcount;
		}
		
		// See if we are an empty row
		$emptyrow = $cellcount == 1 && $colcount > 1;
		
		// Handle empty rows as per the request
		if ($emptyrow) {
			// If we are to remove empty lines just move to the next row
			if ($trimlines == 2) {
				continue;
			} elseif ($trimlines == 1) {
				// Otherwise if we are to group them, do it
				if ($emptyrowskip) {
					continue;
				} else {
					// Set the skip flag to true to skip future empty consecutive rows
					$emptyrowskip = true;
				}
			}
		} else {
			// If the previous row wasn't empty reset the emtpy row skip flag
			if (!$prevrowempty) {
				$emptyrowskip = false;
			}
		}
		
		// Loop those parts and wrap them in their appropriate cell wrappers
		for ($j = 0; $j < $cellcount; $j++) {
			// If the cell count for subsequent rows is less than the colcount...
			if ($j == 0 && $cellcount < $colcount) {
				// Add in the rows we need, resetting the loop counter too
				while ($cellcount < $colcount) {
					$parts[$cellcount] = '';
					$cellcount++;
				}
			}
			
			// The new line and spacing is just for formatting
			$out .= '
			' . str_replace('__T__', $parts[$j], $wrapper);
		}
		
		// Close out the row, again with HTML formatting
		$out .= '
		</tr>';
		
		// Reset the rowon flag
		$rowon = !$rowon;
	}
	
	// Close out the table, also with HTML formatting
	$out .= '
	</table>';
}
?>

	<h1 id="table-maker">Simple table maker</h1>
	<p>
		This little script will take a tab separated collection of rows of data 
		and make a table from it. Think of copying and pasting from a spreadsheet.
		:)<br /><br />
		<small>
			I tried to make this sorta smart, but honestly, it isn't that robust.
			It will totally make extra cells for data that has headers but no 
			matching cells, but that's about as far as it goes.</small>
	</p>
	
	<fieldset>
		<legend>Table maker</legend>
		<form id="table-maker" method="post" action="">
			<p>Table summary: <input type="text" name="summary" id="summary" value="<?php echo $summary ?>" /></p>
			<p>Table caption: <input type="text" name="caption" id="caption" value="<?php echo $caption ?>" /></p>
			<p>
				Enter in a collection of tab separated rows to make a table out of:<br />
				<textarea name="text" cols="80" rows="12"><?php echo $text ?></textarea>
			</p>
			<p><input type="checkbox" name="headers"<?php if ($headerrow): ?> checked="checked"<?php endif; ?> /> Use first row as column headers</p>
			<p>
				<input type="radio" name="trimlines"value="0"<?php if (!$trimlines || $trimlines == 0): ?> checked="checked"<?php endif; ?> /> <em>Ignore</em> OR
				<input type="radio" name="trimlines"value="1"<?php if ($trimlines == 1): ?> checked="checked"<?php endif; ?> /> <em>Group</em> OR
				<input type="radio" name="trimlines"value="2"<?php if ($trimlines == 2): ?> checked="checked"<?php endif; ?> /> <em>Remove</em> empty lines</p>
			<p><input type="submit" name="submit" value="Make a table" /><?php if ($out): ?> <a href="#table-output" title="Go to table output" class="small">Table output</a> | <a href="#html-output" title="Go to HTML output" class="small">HTML output</a><?php endif; ?></p>
		</form>
	</fieldset>
	
	<?php if ($out): ?> 
	<hr />
	<h2 id="table-output">Table output</h2>
	<?php echo $out ?> 
	<a href="#table-maker" title="Go to the table maker" class="small">Table maker</a> | <a href="#html-output" title="Go to HTML output" class="small">HTML output</a>
	<hr />
	<h2 id="html-output">HTML output</h2>
	<p>Copy and paste (yes, you actually have to select all and copy yourself):</p>
	<textarea rows="30" cols="150"><?php echo htmlentities($out) ?></textarea>
	<a href="#table-maker" title="Go to the table maker" class="small">Table maker</a> | <a href="#table-output" title="Go to table output" class="small">Table output</a>
	<?php endif; ?> 