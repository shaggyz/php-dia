<?php

class PDPHPParser{
	
	/**
	 * File structure
	 * @var array
	 */
	protected $structure = array(
		'class' => null,
		'methods' => null,
		'properties' => null,
		'constants' => null,
	);
	
	/**
	 * 
	 */
	public function __construct($sourceCodeARR){

		if(!is_array($sourceCodeARR)){
			throw new Exception("Php parser expects an array as code");
		}
		
		foreach ($sourceCodeARR as $line){
			$this->_extractClass($line);
		}
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getScructure(){
		return $this->structure;
	}
	
	private function _extractClass($line){
		
		if(!is_null($this->structure['class'])){
			return;
		}
		
		if (preg_match('/class\s([a-zA-Z0-9-_]+)(\s+extends\s+([a-zA-Z0-9-_]+))?(\s+implements\s+([a-zA-Z0-9-_]+))?/', $line, $result)) {
			
			$classItemARR = array();
			if(array_key_exists(1, $result)){
				$classItemARR['name'] = $result[1];
			}
			if(array_key_exists(3, $result)){
				$classItemARR['extends'] = $result[3];
			}
			if(array_key_exists(5, $result)){
				$classItemARR['implements'] = $result[5];
			}
			
			$this->structure['class'] = $classItemARR;
			
		} 
		
		
	}
	
	
	
}

?>