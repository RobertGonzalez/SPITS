<?php
/**
 * The OutputController class is a dead simple rendering class that takes a 
 * script and imports its processed output before wrapping it in HTML and sending
 * it to the client. The $htmlopen and $htmlclose properties tell this class
 * to render the opening and closing wrappers around the output of the script.
 * This can be overridden by either:
 *  - directly changing the values of these properties to null
 *  - setting a $nohtmlopen, $nohtmlclose or $nohtml variable in your scripts to
 *    a non empty value
 */
class OutputController {
    /**
     * Path to the currently request script
     * 
     * @var string
     */
    protected $path;
    
    /**
     * Opening HTML include. Will only be included if not null or
     * if the $nohtml or $nohtmlopen flag is NOT set in the script.
     * 
     * @var string
     */
    protected $htmlopen  = 'views/htmlopen.php';
    
    /**
     * Path to the closing HTML include. Will only be included if not null or
     * if the $nohtml or $nohtmlclose flag is NOT set in the script.
     * 
     * @var string
     */
    protected $htmlclose = 'views/htmlclose.php';
    
    /**
     * Do we use rewrite or not
     * 
     * @var bool
     */
    protected static $useRewrite = false;
    
    /**
     * Have we checked rewrite or not
     * @var bool
     */
    protected static $useRewriteChecked = false;
    
    /**
     * Class constructor simply sets the path to this script or sets the start
     * page if there is no requested script
     */
    public function __construct() {
        // For rewrite testing
        if (!empty($_GET['_rewriteTest'])) {
            echo "success";
            exit;
        }
        $path = empty($_GET['test']) || $_GET['test'] == '.php' ? 'start.php' : $_GET['test'];
        $this->path = "../spits/$path";
    }
    
    /**
     * Executes the requested script and sends its output to the client
     * 
     * @return void
     */
    public function execute() {
        if (file_exists($this->path)) {
            ob_start();
            require_once $this->path;
            $out = ob_get_clean();
        } else {
            $out = "<h1>ERROR: Script not found</h1><br />\n<p>The script you requested ($this->path) was not found.</p>";
        }
        
        if (!isset($pagetitle)) {
            $pagetitle = 'SPITS - Simple PHP Interaction Test Scripts';
        }
        
        if (empty($nohtml) && empty($nohtmlopen) && $this->htmlopen) {
            require_once $this->htmlopen;
        }
        
        echo $out;
        
        if (empty($nohtml) && empty($nohtmlclose) && $this->htmlclose) {
            require_once $this->htmlclose;
        }
    }
    
    /**
     * Checks the existence of clean urls by sending a simple cURL request to
     * this app looking for a page defined in the .htaccess file.
     * 
     * @static
     * @return bool
     */
    public static function checkRewriteUse() {
        if (self::$useRewriteChecked) {
            return self::$useRewrite;
        }
        
        // Send the request off to see if rewrite is working
        $proto = 'http';
        if (isset($_SERVER['HTTPS'])) {
            $proto .= 's';
        }
        
        // Set the cURL request url
        $url = $proto . '://' . $_SERVER['HTTP_HOST'] . '/rewritetest/';
        
        // Make the request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $reply = curl_exec($ch);
        $info  = curl_getinfo($ch);
        curl_close($ch);
        
        if (isset($info['http_code']) && $info['http_code'] == '200') {
            self::$useRewrite = true;
        }
        
        self::$useRewriteChecked = true;
        return self::$useRewrite;
    }
}