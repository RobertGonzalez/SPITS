<?php
class Server {
    /**
     * The root of the server, for installation of the app
     * 
     * @var string
     */
    protected static $serverRoot;
    
    /**
     * Gets the protocol for the request
     * 
     * @return string
     */
    public static function getProtocol() {
        $proto = 'http';
        if (isset($_SERVER['HTTPS'])) {
            $proto .= 's';
        }
        
        return $proto;
    }
    
    /**
     * Gets the request URI
     * 
     * @param boolean $root If set, will return only the root request uri
     * @return string
     */
    public static function getRequestUri($root = false) {
        $requestUri = $_SERVER['REQUEST_URI'];
        if ($root) {
            if (($test = Request::get('test')) !== null) {
                $requestUri = str_replace("test/$test", '', $requestUri);
            }
        }
        
        return $requestUri;
    }
    
    /**
     * Gets a SERVER variable
     * 
     * @param  string $var     The variable name to get the value for
     * @param  string $default A default value in the event the request variable isn't found
     * @return string
     */
    public static function getVar($var, $default = null) {
        return array_key_exists($var, $_SERVER) ? $_SERVER[$var] : $default;
    }
    
    /**
     * Gets the server root for this installation
     * 
     * @return string 
     */
    public static function getRoot() {
        if (!empty(self::$serverRoot)) {
            return self::$serverRoot;
        }
        
        // Send the request off to see if rewrite is working
        $proto = Server::getProtocol();
        
        // Set the cURL request url
        $requestUri = Server::getRequestUri(true);
        
        self::$serverRoot = $proto . '://' . Server::getVar('HTTP_HOST') . $requestUri;
        
        return self::$serverRoot;
    }
}