<?php
class ScriptsList {
    /**
     * Static listing of script directories and their php contents. Made static
     * because eventually it will be used to build the header quick nav too.
     * 
     * @static
     * @access public
     * @var array
     */
    public static $scriptsList = array();

    /**
     * Gets the listing of scripts that can be run
     * 
     * @static
     * @return array
     */
    public static function getScriptsList() {
        if (!empty(self::$scriptsList)) {
            return self::$scriptsList;
        }
        
        // Check our linkage
        require_once 'utils/OutputController.php';
        $rewrite = OutputController::checkRewriteUse();
        
        // Grab our directory listing
        $dirs = glob('../spits/*', GLOB_ONLYDIR);
        
        // Get our file listing
        $files = array();
        foreach ($dirs as $dir) {
            // We only want to get PHP files
            $items = glob($dir . '/*.php');
            
            // Clean up the directory name
            $dir = basename($dir);
            
            // Create the listing by directory
            $files[$dir] = array();
            
            // Add items to the listing now
            foreach ($items as $file) {
                $name = basename($file);
                $path = "$dir/$name";
                $link = $rewrite ? "test/$path" : '?test=' . $path;
                $files[$dir][] = array('link' => $link, 'path' => $path, 'name' => $name);
            }
        }
        
        self::$scriptsList = $files;
        return self::$scriptsList;
    }
}