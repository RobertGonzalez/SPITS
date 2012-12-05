<?php
/**
 * If you want to add anything prior to the HTML closing out, this is the place
 * to do it.
 */
?>
<?php
// Only show the back to home link on pages that are not the home page
if ($_SERVER['REQUEST_URI'] != '/'): 
?>
<div id="gohome"><a href="/">&laquo; Back to start</a></div>
<?php endif; ?>
</body></html>