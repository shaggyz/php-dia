<?php

class PDConsole{
	
	/**
	* Prints an error message on standard output
	* @param string $msg
	*/
	public static function printError($msg, $newLine = true){
		 
		$nl = $newLine ? "\n" : "";
		echo $nl . "[\033[31mERROR\033[0m] $msg\n";
		 
	}

	/**
	* Prints an information message on standard output
	* @param string $msg
	*/
	public static function printInfo($msg, $newLine = true){
		 
		$nl = $newLine ? "\n" : "";
		echo $nl . "[\033[36mInfo\033[0m] $msg\n";
		 
	}
	
	/**
	 * Prints a message on standard output
	 * @param string $msg
	 */
	public static function printMessage($msg, $newLine = true){
		 
		$nl = $newLine ? "\n" : "";
		echo $nl . "[\033[32mOK\033[0m] $msg\n";
		 
	}
	
	/**
	 * Reads a line of text from standard input.
	 * @return string : null
	 */
	public static function readLine(){
		 
		//$handle = fopen ("php://stdin","r");
		$line = fgets(STDIN);
	
		return $line ? trim($line) : null;
		 
	}
	
	/**
	* Prints a string on one line. The default is to append a newline at the end
	* @param string $cadena
	* @param boolean $newLine
	*/
	public static function printLine($cadena, $newLine = true){
	
		if ($newLine){
			$cadena .= "\n";
		}
		 
		echo $cadena;
	
	}
	
	/**
	* Returns the argument in the key position ($clave)
	* @param string $clave
	*/
	public static function getArg($clave){
	
		global $argv;
	
		if (array_key_exists($clave, $argv)){
			return $argv[$clave];
		}
	
		return null;
	
	}
	
	
	
	
	
	
	
}