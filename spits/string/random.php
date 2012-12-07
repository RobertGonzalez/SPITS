<?php
// Get the string class to work with our code
require_once 'utils/String.php';

// Start with the page title
$pagetitle = 'Random string generator';

// Add in our js files
$importjQuery = true;
$jsFiles = array('string_random');

// Are we a post? 
$ispost = Request::is('post');

// Get our request now, starting with the string length
$length = Request::post('length');

// The chunk size
$cvalue = Request::post('cvalue');
$casarr = Request::post('casarr') !== null;
$cdelim = Request::post('cdelim', ' ');

// Numbers, lower and upper
$nchars = $ispost && Request::post('nchars') !== null;
$lchars = $ispost && Request::post('lchars') !== null;
$uchars = $ispost && Request::post('uchars') !== null;

// Special chars
$schars = $ispost && Request::post('schars') !== null;

// Get the string
$string = String::getRandom($length, $nchars, $lchars, $uchars, $schars);
if ($string) {
    if ($cvalue && $cvalue < $length) {
        $string = String::getChunksAsString($string, $cvalue, $casarr ? "\n" : $cdelim);
    }
}
?>
<h1><?php echo $pagetitle ?></h1>
    <p>
        <?php echo $pagetitle ?>
    </p>
    <p class="small">Generates a random string. Capable of generating the string in chunks.</p>
    
    <fieldset>
        <legend><?php echo $pagetitle ?></legend>
        <form id="string-maker" method="post" action="">
            <p>
                String length: <input type="text" id="length" name="length" value="<?php echo $length ?>" /> 
                Chunk size: <input type="text" id="cvalue" name="cvalue" value="<?php echo $cvalue ?>" />
                <span id="list-option-wrapper">
                    Return as list: <input type="checkbox" name="casarr" id="casarr"<?php if ($casarr): ?> checked="checked"<?php endif; ?> />
                </span>
            </p>
            <p id="checkboxes">
                <strong>Include in string (at least one is required)</strong><br />
                Numbers: <input type="checkbox" name="nchars" id="nchars"<?php if ($nchars): ?> checked="checked"<?php endif; ?> />
                Lowercase: <input type="checkbox" name="lchars" id="lchars"<?php if ($lchars): ?> checked="checked"<?php endif; ?> />
                Uppercase: <input type="checkbox" name="uchars" id="uchars"<?php if ($uchars): ?> checked="checked"<?php endif; ?> />
                Specials: <input type="checkbox" name="schars" id="schars"<?php if ($schars): ?> checked="checked"<?php endif; ?> />
            </p>
            <p><input type="submit" name="submit" id="submit" value="Process" /> <span id="alert" class="error small"></span></p>
        </form>
    </fieldset>
    
    <?php if ($string): ?> 
    <hr />
    <h2 id="output">String:</h2>
    <textarea rows="20" cols="110" id="result"><?php echo $string; ?></textarea>
    <?php endif; ?> 