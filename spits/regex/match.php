<?php
// Page title
$pagetitle = 'Regular Expression Match Tester';

// Handle the inputs
$p = Request::post('pattern');
$s = Request::post('subject');
$g = Request::post('grouped') !== null;
$o = Request::post('offsets') !== null;
$m = array();

// Only process if we have a pattern and subject
if ($p && $s) {
    // Set our flags for the return, starting with which type of grouping
    $f = $g ? PREG_SET_ORDER : PREG_PATTERN_ORDER;
    
    // If we want to capture offsets, add those in now
    if ($o) {
        $f = $f | PREG_OFFSET_CAPTURE;
    }
    preg_match_all($p, $s, $m, $f);
}
?>
    <h1><?php echo $pagetitle ?></h1>
    <p>
        It's simple... you provide your regular expression and your subject string, this provides your matches, if there are any.
    </p>
    
    <fieldset>
        <legend><?php echo $pagetitle ?></legend>
        <form id="table-maker" method="post" action="">
            <p>Pattern:<br /> 
                <textarea name="pattern" id="pattern" cols="150" rows="10"><?php echo $p ?></textarea>
            </p>
            <p>Subject:<br /> 
                <textarea name="subject" id="subject" cols="150" rows="10"><?php echo $s ?></textarea>
            </p>
            <p><input type="checkbox" name="grouped"<?php if ($g): ?> checked="checked"<?php endif; ?> /> Group matches together</p>
            <p><input type="checkbox" name="offsets"<?php if ($o): ?> checked="checked"<?php endif; ?> /> Include string position of the match in the subject</p>
            <p><input type="submit" name="submit" value="Process" /></p>
        </form>
    </fieldset>
    
    <?php if ($m && isset($m[0])): ?> 
    <hr />
    <h2 id="output">Matches: <?php echo count($m[0]) ?></h2>
    <pre><?php var_dump($m); ?></pre>
    <?php endif; ?> 
