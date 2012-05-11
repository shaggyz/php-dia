<?php

class PDDiaFile{

	/**
	 * Path to .dia file 
	 * @var string
	 */
	protected $diaFilePath; 
	
	/**
	 * Sets the .dia file path
	 * @param string $filePath
	 */
	public function __construct($filePath = null){
		
		if(!is_null($filePath) && !file_exists($filePath)){
			throw new Exception("The file '$fielPath' no exists!");
		}
		
	}
	
}