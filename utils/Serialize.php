<?php
/**
 * Adding a namespace to prevent clash with global function names
 */
namespace Utils;

/**
 * Handles basic unserialize functionality
 */
class Serialize
{
    /**
     * Tracks changes made by this class
     * @var array
     */
    public static $mods = array();

    /**
     * Tracks the number of good hits found when unserializing
     * @var integer
     */
    public static $good = 0;

    /**
     * Writes an internal cache of errors
     * @param array $data Match array from a preg_replace callback
     */
    public function writeError($data) {
        $newLen = strlen($data[2]);
        if ($newLen != $data[1]) {
            self::$mods[] = array(
                'original' => $data[0],
                'original_length' => $data[1],
                'original_string' => $data[2],
                'updated_length' => $newLen,
            );
        }
    }

    /**
     * Gets an unserialized string after manipulating the serialized data in case
     * of encoding classh
     * @param string $string The data to unserialize
     * @return mixed
     */
    public function getAlternateUnserialize($string) {
        $string = preg_replace_callback(
            '!s:(\d+):"(.*?)";!s',
            function ($matches) {
                if (isset($matches[2])) {
                    $this->writeError($matches);
                    return 's:'.strlen($matches[2]).':"'.$matches[2].'";';
                }
            },
            $string
        );
        return unserialize($string);
    }

    /**
     * Gets unserialized data for a string
     * @param string $input Input string to unserialize
     * @return mixed
     */
    public function getUnserialized($input) {
        $u = @unserialize($input);
        if ($u === false) {
            $u = $this->getAlternateUnserialize($input);
        } else {
            self::$good++;
        }

        return $u;
    }
}