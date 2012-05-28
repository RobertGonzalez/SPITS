<?php
/**
 * Memory use reporter, borrowed from the Spark collection, records and reports
 * memory usage for a given process
 * 
 * @category utils
 * @package utils
 * @author Robert Gonzalez <robert@robert-gonzalez.com
 */
class MemoryLog {
	/**
	 * Listing of various steps along the memory use trail
	 * 
	 * @access private
	 * @var array Listing of memory reads
	 */
	private $_memory = array();
	
	/**
	 * Adds an entry into the memory use list
	 * 
	 * @access public
	 * @param integer $line The line the stat is being added from
	 * @param string $msg A message to append to the entry line
	 */
	public function log($line, $msg = 'Processing') {
		$this->_memory[] = array('line' => $line, 'message' => $msg, 'mem' => $this->getMemoryUse());
	}
	
	/**
	 * Gets the entire log as an array
	 * 
	 * @access public
	 * @return array Listing of all entered memory stats
	 */
	public function getLog() {
		return $this->_memory;
	}
    
    /**
     * Gets the log as a string
     * 
     * @return string
     */
    public function getLogAsString() {
        return $this->__toString();
    }
	
	/**
	 * Get the memory usage from the current process
	 * 
	 * This includes a hack for Windows systems and for systems that may or may
	 * not have access to the memory_get_usage() function.
	 * 
	 * @access public
	 * @return integer Integer value of the current memory use
	 */
	public function getMemoryUse() {
		// If memory_get_usage is available use it
		if (function_exists('memory_get_usage')) {
			return memory_get_usage();
		} else {
			// If we are running on Windows
			if (substr(PHP_OS, 0, 3) == 'WIN') {
				$output = array();
				// Should check whether tasklist is available, but I'm lazy
				exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);
				// Filter non-numeric characters from output. Why not use substr & strpos?
				// I'm running Windows XP Pro Dutch, and it's output does not match the
				// English variant, as will all other translations. This is a more generic
				// approach, and has a better chance of actually working
				return preg_replace('/[^0-9]/', '', $output[5]) * 1024;
				// Tasklist outputs memory usage in kilobytes, memory_get_usage in bytes.
				// So we multiply by 1024 and in the process convert from string to integer.
			} else {
				//We now assume the OS is UNIX 
				//Tested on Mac OS X 10.4.6 and Linux Red Hat Enterprise 4 
				//This should work on most UNIX systems 
				$pid = getmypid(); 
				exec("ps -eo%mem,rss,pid | grep $pid", $output); 
				$output = explode("  ", $output[0]); 
				//rss is given in 1024 byte units 
				return $output[1] * 1024; 
			}
		}
	}
	
	/**
	 * Magic overload method to output the memory statistics
     * 
	 * @access public
	 * @return string A string built from the internal memory statistic array
	 */
	public function __toString() {
		// Prepare the return string
		$str = '';
		
		// Loop through what we know to this point
		foreach ($this->_memory as $v) {
            $line = 'Line ' . $v['line'] . ': ' . $v['message'] . ' ...<br />Total mem use: ' . $v['mem'];
			$str .= '<div class="memory-use-record">' . $line . '</div>';
		}
		
		// Send it back to the caller
		return $str;
	}
}