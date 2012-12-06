<?php
// Set the title
$pagetitle = 'Base64 Decoder/Encoder';

// Handle the input url
$s = Request::post('string');
$l = 0;

// Handle the actual request of encoding
$e = Request::post('encode') !== null;
$z = Request::post('unserialize') !== null;

// Build our output
$o  = '';
$h = 0;

// If there was a string...
if ($s) {
    // Get the url length
    $l = strlen($s);
    
    // Clean up our output a little bit
    $s = trim($s);
    
    // Get our output
    $function = $e ? 'base64_encode' : 'base64_decode';
    $o = $function($s);
    $h = strlen($o);
    
    // Handle unserializing
    if (!$e && $z) {
        $o = unserialize($o);
    }
}
?>
    <h1 id="table-maker"><?php echo $pagetitle ?></h1>
    <p>
        This little script base64 encodes or decodes a string<br /><br />
        <small></small>
    </p>
    
    <fieldset>
        <legend><?php echo $pagetitle ?></legend>
        <form id="table-maker" method="post" action="<?php echo basename(__FILE__) ?>">
            <p>Input string:<br /> 
                <textarea name="string" id="string" cols="150" rows="10"><?php echo $s ?></textarea>
            </p>
            <p><input type="checkbox" name="encode"<?php if ($e): ?> checked="checked"<?php endif; ?> /> Encode this string instead of decode it</p>
            <p><input type="checkbox" name="unserialize"<?php if ($z): ?> checked="checked"<?php endif; ?> /> Unserialize decoded string</p>
            <p><input type="submit" name="submit" value="Process" /></p>
        </form>
    </fieldset>
    
    <?php if ($o): ?> 
    <hr />
    <h2 id="output">Result (<?php echo $h ?> chars in length)</h2>
    <pre><?php var_dump($o); ?></pre>
    <?php endif; ?> 
    