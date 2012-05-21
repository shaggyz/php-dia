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
		
		if(!$this->_haveClass($sourceCodeARR)){
			$this->structure = null;
			return;
		}		
		
		foreach ($sourceCodeARR as $line){
			
			$this->_extractClass($line);
			$this->_extractMethods($line);
			$this->_extractProperties($line);
		}
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $codeARR
	 */
	private function _haveClass($codeARR){
		
		$code = implode('', $codeARR);
		return preg_match('/class.+\n*\{/', $code);
		
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
	 * 
	 * @param unknown_type $code
	 */
	private function _extractParams($code){
		
		if (preg_match_all('/\$([a-zA-Z0-9-_]+)/', $code, $result)) {
			return $result[1];
		}
		
		return null;
		
	}
	
	/**
	 * Extracts methods from a line
	 * @param string $line
	 */
	private function _extractMethods($line){
		
		if (preg_match('/(static\s+)?(public|private|protected)\s+(static\s+)?function\s+([a-zA-Z0-9-_]+)\s*\((.*)\)/', $line, $result)){
			
			$methodItemARR = array();
			
			if(array_key_exists(2, $result)){
				$methodItemARR['scope'] = $result[2];
			}
			
			if(array_key_exists(4, $result)){
				$methodItemARR['name'] = $result[4];
			}
			
			$methodItemARR['params'] = $this->_extractParams($result[5]);
				
			$this->structure['methods'][] = $methodItemARR;
			
		}
	}
		
	/**
	 * 
	 * Enter description here ...
	 */
	private function _extractProperties($line){
		
		if (preg_match('/(static\s+)?(public|private|protected)\s+(static\s+)?\$([a-zA-z0-9-_]+)/', $line, $result)) {
			
			$propItemARR = array();
			$propItemARR['scope'] = $result[2];
			$propItemARR['name'] = $result[4];
			
			$this->structure['properties'][] = $propItemARR;
			
		}
		
	}
	
	
}

?>