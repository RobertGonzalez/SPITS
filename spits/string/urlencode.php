<?php
// Page title
$pagetitle = 'URL decoder/encoder';

// Handle the input url
$url = Request::post('url');
$urllength = 0;

// Handle the actual request of the URL
$enc = Request::post('encode') !== null;

// Build our output
$out  = '';
$outlength = 0;

// If there was a URL...
if ($url) {
    // Get the url length
    $urllength = strlen($url);
    
    // Clean up our output a little bit
    $url = trim($url);
    
    // Get our output
    $function = $enc ? 'urlencode' : 'urldecode';
    $out = $function($url);
    
    // Output length
    $outlength = strlen($out);
    
    // For display purposes, tells the client what type of function was carried out
    $resulttype = ucfirst(str_replace('url', '', $function)) . 'd';
}
?>
    <h1 id="page-title"><?php echo $pagetitle ?></h1>
    <p>
        This little script encodes or decodes a URL<br /><br />
        <small></small>
    </p>
    
    <fieldset>
        <legend><?php echo $pagetitle ?></legend>
        <form id="table-maker" method="post" action="">
            <p>URL: <input type="text" name="url" id="url" value="<?php echo $url ?>" /></p>
            <p><input type="checkbox" name="encode"<?php if ($enc): ?> checked="checked"<?php endif; ?> /> Encode this URL instead of decode it</p>
            <p><input type="submit" name="submit" value="Process this URL" /></p>
        </form>
    </fieldset>
    
    <?php if ($out): ?> 
    <hr />
    <h2 id="input">Input URL (<?php echo $urllength ?> chars in length)</h2>
    <p><?php echo $url ?></p> 
    <hr />
    <h2 id="output"><?php echo $resulttype ?> Result (<?php echo $outlength ?> chars in length)</h2>
    <p><?php echo $out; ?></p>
    <?php endif; ?> 
