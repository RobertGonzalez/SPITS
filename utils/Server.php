<?php
class Server {
    /**
     * The root of the server, for installation of the app
     * 
     * @var string
     */
    protected static $serverRoot;
    
    public static function getProtocol() {
        $proto = 'http';
        if (isset($_SERVER['HTTPS'])) {
            $proto .= 's';
        }
        
        return $proto;
    }
    
    public static function getRequestUri() {
        $requestUri = $_SERVER['REQUEST_URI'];
        if (($test = Request::get('test')) !== null) {
            $requestUri = str_replace("test/$test", '', $requestUri);
        }
        
        return $requestUri;
    }
    
    public static function getVar($var, $default = null) {
        return array_key_exists($var, $_SERVER) ? $_SERVER[$var] : $default;
    }
    
    public static function getRoot() {
        if (!empty(self::$serverRoot)) {
            return self::$serverRoot;
        }
        
        // Send the request off to see if rewrite is working
        $proto = Server::getProtocol();
        
        // Set the cURL request url
        $requestUri = Server::getRequestUri();
        
        self::$serverRoot = $proto . '://' . Server::getVar('HTTP_HOST') . $requestUri;
        
        return self::$serverRoot;
    }
}