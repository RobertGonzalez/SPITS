<?php
// Quick include path setting
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('..'));

// Handle output
require_once 'utils/OutputController.php';
$oc = new OutputController();
$oc->execute();
