#!/usr/bin/env php
<?php

/**
 * 	--- php-dia ---
 * 
 *  @description 	Converts php5 code to dia uml diagrams
 *  @author 		Nicolás Daniel Palumbo <npalumbo@xinax.net>
 *  @license 		GNU/GPL v2 (http://www.gnu.org/licenses/lgpl-2.1.html)
 *  
 **/

set_include_path(get_include_path() . PATH_SEPARATOR . 'lib/');

require_once 'PDProgram.inc';
$prog = new PDProgram();

?>