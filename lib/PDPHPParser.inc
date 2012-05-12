<?php

/**
 * 	--- php-dia ---
 *
 *  @description 	Simple PHP code parser (just some oop elements)
 *  @author 		Nicolás Daniel Palumbo <npalumbo@xinax.net>
 *  @license 		GNU/GPL v2.1 (http://www.gnu.org/licenses/lgpl-2.1.html)
 *
 **/
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
	 * Main parser loop
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
	 * Return the entities structure
	 * @return array 
	 */
	public function getScructure(){
		return $this->structure;
	}
	
	/**
	 * Extracts a class definition
	 * @param string $line
	 */
	private function _extractClass($line){
		
		// Just one per file, at moment
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
	
	
	/**
	 * Extracts methods from a line
	 * @param string $line
	 */
	private function _extractMethods($line){
		
			
		
	}
	
	
	
}

?>