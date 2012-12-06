<?php
/**
 * Simple static accessor to the request
 */
class Request {
    /**
     * Gets a value for a GET argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the GET array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @return mixed
     */
    public static function get($var, $default = null) {
        return array_key_exists($var, $_GET) ? $_GET[$var] : $default;
    }
    
    /**
     * Gets a value for a POST argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the POST array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @return mixed
     */
    public static function post($var, $default = null) {
        return array_key_exists($var, $_POST) ? $_POST[$var] : $default;
    }
    
    /**
     * Gets a value for a COOKIE argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the COOKIE array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @return mixed
     */
    public static function cookie($var, $default = null) {
        return array_key_exists($var, $_COOKIE) ? $_COOKIE[$var] : $default;
    }
    
    /**
     * Gets a value for a REQUEST argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the REQUEST array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @return mixed
     */
    public static function has($var, $default = null) {
        return array_key_exists($var, $_REQUEST) ? $_REQUEST[$var] : $default;
    }
    
    /**
     * Detects whether the request is at the root of the application
     * 
     * @return boolean 
     */
    public static function isHome() {
        return self::get('test') === null;
    }
}