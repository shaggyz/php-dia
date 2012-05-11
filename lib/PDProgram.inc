<?php

require_once "PDConsole.inc";
require_once "PDPHPParser.inc";
require_once "PDDiaFile.inc";

class PDProgram{
	
	/**
	 * Target dir
	 * @var string
	 */
	protected $targetPath;

	/**
	 * Php source file paths
	 * @var array
	 */
	protected $phpFilesARR = array();

	/**
	 * 
	 * Enter description here ...
	 * @var array
	 */
	protected $entitiesARR;
	
	
	/**
	 * Starts the application
	 */
	public function __construct(){

		try{
			
			if(!$this->targetPath = PDConsole::getArg(1)){
				$this->showHelp();
				$this->quit();
			}
			
			if(!file_exists($this->targetPath) || !is_dir($this->targetPath)){
				throw new Exception("The given path is not valid ({$this->targetPath})");
				$this->quit(false);
			}
			
			// extract the files .php and .inc recursively
			$this->phpFilesARR = $this->scanFiles();
			
			// parse the php code
			$this->parsePHPCode();
			
			// gen the dia file
			$this->generateDiaFile();
			
			
		} catch (Exception $e){
			
			PDConsole::printError($e->getMessage(), false);
			
		}
		
	}
	
	
	/**
	 * Help
	 */
	public static function showHelp(){
		PDConsole::printLine("Usage: ./php-dia <path_to_php_files>");
	}
	
	
	/**
	 * Ends the app (On unix: 1= error, 0= ok)
	 */
	public function quit($success = true){
		exit(intval(!$success));
	}
	
	
	/**
	 * Extracts the php source files from the working dir 
	 */
	protected function scanFiles(){
		
		PDConsole::startProcess("Scanning files...");
		
		if ('/' == $this->targetPath[(strlen($this->targetPath) -1)]){
			$this->targetPath = substr_replace($this->targetPath ,"",-1);
		}
		
		$path = '';
		
		$stack[] = $this->targetPath;
		
		while ($stack) {
			$thisdir = array_pop($stack);
			if ($dircont = scandir($thisdir)) {
				$i=0;
				while (isset($dircont[$i])) {
					if ($dircont[$i] !== '.' && $dircont[$i] !== '..') {
						$currentFile = "{$thisdir}/{$dircont[$i]}";
						if (is_file($currentFile)) {
							
							// File validation (by extension)
							if (preg_match('/.*(\.php|\.inc)$/', $currentFile)) {
								$path[] = "{$thisdir}/{$dircont[$i]}";
							}
							
						} elseif (is_dir($currentFile)) {
							
							// No dirs
							//$path[] = "{$thisdir}/{$dircont[$i]}";
							$stack[] = $currentFile;
						}
					}
					$i++;
				}
			}
		}
		
		PDConsole::endProcess(count($path) . " files indexed", count($path));
		
		return $path;
		
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	protected function parsePHPCode(){
		
		PDConsole::startProcess("Loading PHP code...");
		
		foreach ($this->phpFilesARR as $phpFile){
			
			$parser = new PDPHPParser(file($phpFile));
			$this->entitiesARR[] = $parser->getScructure();
			
		}
		
		PDConsole::endProcess("Code parsed: " . count($this->entitiesARR) . " entities");
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	protected function generateDiaFile(){
		
		PDConsole::startProcess("Making diagram...");
		
		$diaFile = new PDDiaFile($this->entitiesARR);
		$diaFile->writeFile('caca.dia');
		
		PDConsole::endProcess("File created");
		
	} 
	
	
	
	
}