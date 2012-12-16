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
     * @param  bool   $empty   If true, will check empty value, not just array var set
     * @return mixed
     */
    public static function get($var, $default = null, $empty = false) {
        if ($empty) {
            return empty($_GET[$var]) ? $default : $_GET[$var];
        } else {
            return array_key_exists($var, $_GET) ? $_GET[$var] : $default;
        }
    }
    
    /**
     * Gets a value for a POST argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the POST array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @param  bool   $empty   If true, will check empty value, not just array var set
     * @return mixed
     */
    public static function post($var, $default = null, $empty = false) {
        if ($empty) {
            return empty($_POST[$var]) ? $default : $_POST[$var];
        } else {
            return array_key_exists($var, $_POST) ? $_POST[$var] : $default;
        }
    }
    
    /**
     * Gets a value for a COOKIE argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the COOKIE array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @param  bool   $empty   If true, will check empty value, not just array var set
     * @return mixed
     */
    public static function cookie($var, $default = null, $empty = false) {
        if ($empty) {
            return empty($_COOKIE[$var]) ? $default : $_COOKIE[$var];
        } else {
            return array_key_exists($var, $_COOKIE) ? $_COOKIE[$var] : $default;
        }
    }
    
    /**
     * Gets a value for a REQUEST argument if it exists, otherwise returns a default value
     * 
     * @param  string $var     The index of the REQUEST array to check for
     * @param  mixed  $default The value to use if the requested index is not found
     * @param  bool   $empty   If true, will check empty value, not just array var set
     * @return mixed
     */
    public static function has($var, $default = null, $empty = false) {
        if ($empty) {
            return empty($_REQUEST[$var]) ? $default : $_REQUEST[$var];
        } else {
            return array_key_exists($var, $_REQUEST) ? $_REQUEST[$var] : $default;
        }
    }
    
    /**
     * Detects whether the request is at the root of the application
     * 
     * @return boolean 
     */
    public static function isHome() {
        return self::get('test') === null;
    }
    
    /**
     * Checks the request method to see if it is of $type
     * 
     * @param  string  $type The REQUEST_METHOD
     * @return boolean 
     */
    public static function is($type) {
        return Server::getVar('REQUEST_METHOD') == strtoupper($type);
    }
}