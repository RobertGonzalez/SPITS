<?php
class String {
    /**
     * Gets a randomly generated string of $length character string
     * 
     * @param int $length The length of the string to generate
     * @param boolean $nums Flag to include numbers
     * @param boolean $lower Flag to include lowercase characters
     * @param boolean $upper Flag to include uppercase characters
     * @param boolean $special Flag to include special characters
     * @return string 
     */
    public static function getRandom($length = 32, $nums = true, $lower = true, $upper = true, $special = false) {
        // Only work on this if there is something to work with
        $process = false;
        if (is_numeric($length) && $length > 0) {
            if ($nums || $lower || $upper || $special) {
                $process = true;
            }
        }
        
        if (!$process) {
            return null;
        }
        
        // Initialize our return
        $chars = '';
        
        // Get lowercase first
        if ($lower) {
            $chars .= implode('', range('a', 'z'));
        }
        
        // Now numbers
        if ($nums) {
            $chars .= implode('', range(0,9));
        }
        
        // Now upper
        if ($upper) {
            $chars .= implode('', range('A', 'Z'));
        }
        
        // Lastly, special chars
        if ($special) {
            // ... add those in as well
            $chars .= '!@#$%^&*()_+-={}|[]\:";?,./' . "\'";
        }
        
        // Set the rand max paramter
        $max = strlen($chars)-1;
        
        // Start the return string build
        $return = '';
        
        // Shrink down length to zero as we build ...
        while ($length-- > 0) {
            // ... random number
            $return .= $chars{mt_rand(0, $max)};
        }
        
        return $return;
    }

    /**
     * Wrapper for str_split
     * 
     * @param string $string The string to chunk
     * @param int    $chunk  The chunk size wanted
     * @return array
     */
    public static function getChunks($string, $chunk) {
        return str_split($string, $chunk);
    }

    /**
     * Chunks a string the glues it back together around a space
     * 
     * @param string $string The string to chunk and glue
     * @param int    $chunk  The size of each chunk of string
     * @param string $delim  The string chunk glue
     * @return string
     */
    public static function getChunksAsString($string, $chunk, $delim = ' ') {
        return implode($delim, self::getChunks($string, $chunk));
    }
}