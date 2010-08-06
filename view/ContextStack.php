<?php
/*
 * Copyright (c) 2009 - 2010, Frosted Design
 * All rights reserved.
 */

namespace hydrogen\view;

use hydrogen\view\exceptions\NoSuchVariableException;

class ContextStack {
	protected $stack;
	protected $stackLevel;
	
	public function __construct($initialData=false) {
		$this->stack = array(array());
		$this->stackLevel = array();
		if (is_array($initialData))
			$this->setArray($initilData);
	}
	
	public function push() {
		array_push($this->stack, array());
	}
	
	public function pop() {
		return new ContextStack(array_pop($this->stack));
	}
	
	public function set($key, $value) {
		$level = count($this->stack) - 1;
		for ($i = $level; $i >= 0 ; $i--) {
			if (array_key_exists($key, $this->stack[$i])) {
				$level = $i;
				break;
			}
		}
		$this->stack[$level][$key] = $value;
	}
	
	public function get($key) {
		$level = false;
		for ($i = count($this->stack) - 1; $i >= 0 ; $i--) {
			if (array_key_exists($key, $this->stack[$i])) {
				$level = $i;
				break;
			}
		}
		if ($level === false)
			throw new NoSuchVariableException("Variable does not exist in context: $key");
		return $this->stack[$level][$key];
	}
}

?>