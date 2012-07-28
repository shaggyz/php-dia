<?php

/**
 * 	--- php-dia ---
 *
 *  @description 	Console interface utils
 *  @author 		Nicolás Daniel Palumbo <npalumbo@xinax.net>
 *  @license 		GNU/GPL v2.1 (http://www.gnu.org/licenses/lgpl-2.1.html)
 *
 **/

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
	 * Reads a line from standard input.
	 * @return string : null
	 */
	public static function readLine(){
		 
		//$handle = fopen ("php://stdin","r");
		$line = fgets(STDIN);
	
		return $line ? trim($line) : null;
		 
	}
	
	/**
	* Prints a text line. The default is to append a newline escape at the end
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
	
	
	/**
	 * Prints a process start with a message
	 * @param string $msg
	 */
	public static function startProcess($msg){
		echo "[\033[36m-->\033[0m] $msg ";
	}
	
	/**
	 * Closes a process indicator
	 * @param string $msg
	 * @param boolean $success
	 */
	public static function endProcess($msg, $success = true){
		if ($success){
			echo "[\033[32mOK\033[0m] $msg\n";
		} else {
			echo "[\033[31mERROR\033[0m] $msg\n";
		}
	}	
	
	
}