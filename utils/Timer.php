<?php
/**
 * Library Timer object, borrowed from the Spark collection, handles timing 
 * 
 * @category utils
 * @package utils
 * @author Robert Gonzalez <robert@robert-gonzalez.com
 */
class Timer {
	/**
	 * Timers list
	 *
	 * @access protected
	 * @var array
	 */
	protected $_timers = array();
	
	/**
	 * Timer starter for entry $name
	 *
	 * @access public
	 * @param string $name
	 */
	public function start($name = '_default') {
        $now = microtime(true);
		// If there isn't a timer for this name already, start one
        if (!isset($this->_timers[$name]['start'])) {
			$this->_timers[$name]['start'] = $now;
            $this->_timers[$name]['total'] = 0;
            $this->_timers[$name]['count'] = 1;
		} else {
            // We have a started timer already. If there is no stop, stop it
            if (!isset($this->_timers[$name]['stop']) || $this->_timers[$name]['stop'] < $now) {
                $this->total($name);
                $this->_timers[$name]['start'] = $now;
                $this->_timers[$name]['count']++;
            }
        }
	}
	
	/**
	 * Timer stopper for entry $name
	 *
	 * @access public
	 * @param string $name
	 */
	public function stop($name = '_default') {
		if (isset($this->_timers[$name]['start'])) {
			$this->_timers[$name]['stop'] = microtime(true);
		}
	}
	
	/**
     * Timer totalizer for entry $name
     * 
     * @access public
     * @param string $name
     */
    public function total($name = '_default') {
		if (isset($this->_timers[$name]['start'])) {
            // Stop this timer if it isn't stopped already
            $this->stop($name);
    
            // Do the math, adding the total to what we already know 
            $this->_timers[$name]['total'] += $this->_timers[$name]['stop'] - $this->_timers[$name]['start'];
        }
    }
	
	/**
	 * Timer total fetcher for entry $name
	 *
	 * @access public
	 * @param string $name
	 * @return float The time, in milliseconds, of execution or false on failure
	 */
	public function getTotal($name = '_default') {
		if (!isset($this->_timers[$name]['start'])) {
			return false;
		}
		
		if (!isset($this->_timers[$name]['total'])) {
			$this->total($name);
		}
		
		return sprintf("%.10f", $this->_timers[$name]['total']);
	}
}