<?php

/**
 * 	--- php-dia ---
 *
 *  @description 	Dia file generator
 *  @author 		Nicolás Daniel Palumbo <npalumbo@xinax.net>
 *  @license 		GNU/GPL v2.1 (http://www.gnu.org/licenses/lgpl-2.1.html)
 *
 **/
class PDDiaFile{

	/**
	 * File content
	 * @var unknown_type
	 */
	private $_content;
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $_classX = 1;
	

	/**
	 * Sets the .dia file path
	 * @param string $filePath
	 */
	public function __construct($structure){
		
		if(!is_array($structure) || !count($structure)){
			throw new Exception("Empty structure on xml generator");
		}
		
		$this->_setTemplate();
		
		foreach ($structure as $entity){
//  			print_r($entity);
			$this->_addClass($entity['class']);
			$this->_addMethods($entity['methods']);
			
		}
		
	}
	
	/**
	 * 
	 * @param unknown_type $methodsARR
	 */
	private function _addMethods($methodsARR){
		
		$content = '';
	
		$scopeCodesARR = array(
			'public' => 0,
			'private' => 1,
			'protected' => 2,
		);
		
		foreach ($methodsARR as $method){
			
			if (!array_key_exists('name', $method)){
				continue;
			}
				
			// Public by default
			$scope = array_key_exists('scope', $method) ? $method['scope'] : 'public';
			

			$content .= '
				<dia:composite type="umloperation">
		          <dia:attribute name="name">
		            <dia:string>#' . $method['name'] . '#</dia:string>
		          </dia:attribute>
		          <dia:attribute name="stereotype">
		            <dia:string>##</dia:string>
		          </dia:attribute>
		          <dia:attribute name="type">
		            <dia:string>##</dia:string>
		          </dia:attribute>
		          <dia:attribute name="visibility">
		            <dia:enum val="' . $scopeCodesARR[$scope] . '"/>
		          </dia:attribute>
		          <dia:attribute name="comment">
		            <dia:string>##</dia:string>
		          </dia:attribute>
		          <dia:attribute name="abstract">
		            <dia:boolean val="false"/>
		          </dia:attribute>
		          <dia:attribute name="inheritance_type">
		            <dia:enum val="1"/>
		          </dia:attribute>
		          <dia:attribute name="query">
		            <dia:boolean val="false"/>
		          </dia:attribute>
		          <dia:attribute name="class_scope">
		            <dia:boolean val="false"/>
		          </dia:attribute>';
		          
				  $paramsARR = $method['params'];
				  if(is_array($paramsARR) && count($paramsARR)){
			
		          		$content .= '<dia:attribute name="parameters">';
		          		
		          		foreach ($paramsARR as $param){
					          
		          				$content .= '<dia:composite type="umlparameter">
					              <dia:attribute name="name">
					                <dia:string>#' . $param . '#</dia:string>
					              </dia:attribute>
					              <dia:attribute name="type">
					                <dia:string>##</dia:string>
					              </dia:attribute>
					              <dia:attribute name="value">
					                <dia:string>##</dia:string>
					              </dia:attribute>
					              <dia:attribute name="comment">
					                <dia:string>##</dia:string>
					              </dia:attribute>
					              <dia:attribute name="kind">
					                <dia:enum val="0"/>
					              </dia:attribute>
					            </dia:composite>';
		          				
				          
		          		}
		          		
			            $content .= '</dia:attribute>';
		          
				  }
		          
		        $content .= '</dia:composite>';
			
			
		}
		
		$content = '<dia:attribute name="operations">' . $content . '</dia:attribute>';
		$this->_content = str_ireplace('%%OPERATIONS%%', $content, $this->_content);
		
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $classARR
	 */
	private function _addClass($classARR){
		
		$name = $classARR['name'];
		
		$content = '<dia:object type="UML - Class" version="0" id="O0">
				      <dia:attribute name="obj_pos">
				        <dia:point val="' . $this->_classX . '.0,5.2"/>
				      </dia:attribute>
				      <dia:attribute name="obj_bb">
				        <dia:rectangle val="4.15,5.15;7.17,7.45"/>
				      </dia:attribute>
				      <dia:attribute name="elem_corner">
				        <dia:point val="4.2,5.2"/>
				      </dia:attribute>
				      <dia:attribute name="elem_width">
				        <dia:real val="2.9199999999999999"/>
				      </dia:attribute>
				      <dia:attribute name="elem_height">
				        <dia:real val="2.1999999999999997"/>
				      </dia:attribute>
				      <dia:attribute name="name">
				        <dia:string>#' . $name . '#</dia:string>
				      </dia:attribute>
				      <dia:attribute name="stereotype">
				        <dia:string>##</dia:string>
				      </dia:attribute>
				      <dia:attribute name="comment">
				        <dia:string>##</dia:string>
				      </dia:attribute>
				      <dia:attribute name="abstract">
				        <dia:boolean val="false"/>
				      </dia:attribute>
				      <dia:attribute name="suppress_attributes">
				        <dia:boolean val="false"/>
				      </dia:attribute>
				      <dia:attribute name="suppress_operations">
				        <dia:boolean val="false"/>
				      </dia:attribute>
				      <dia:attribute name="visible_attributes">
				        <dia:boolean val="true"/>
				      </dia:attribute>
				      <dia:attribute name="visible_operations">
				        <dia:boolean val="true"/>
				      </dia:attribute>
				      <dia:attribute name="visible_comments">
				        <dia:boolean val="false"/>
				      </dia:attribute>
				      <dia:attribute name="wrap_operations">
				        <dia:boolean val="true"/>
				      </dia:attribute>
				      <dia:attribute name="wrap_after_char">
				        <dia:int val="40"/>
				      </dia:attribute>
				      <dia:attribute name="comment_line_length">
				        <dia:int val="0"/>
				      </dia:attribute>
				      <dia:attribute name="comment_tagging">
				        <dia:boolean val="false"/>
				      </dia:attribute>
				      <dia:attribute name="line_width">
				        <dia:real val="0.10000000000000001"/>
				      </dia:attribute>
				      <dia:attribute name="line_color">
				        <dia:color val="#000000"/>
				      </dia:attribute>
				      <dia:attribute name="fill_color">
				        <dia:color val="#ffffff"/>
				      </dia:attribute>
				      <dia:attribute name="text_color">
				        <dia:color val="#000000"/>
				      </dia:attribute>
				      <dia:attribute name="normal_font">
				        <dia:font family="monospace" style="0" name="Courier"/>
				      </dia:attribute>
				      <dia:attribute name="abstract_font">
				        <dia:font family="monospace" style="88" name="Courier-BoldOblique"/>
				      </dia:attribute>
				      <dia:attribute name="polymorphic_font">
				        <dia:font family="monospace" style="8" name="Courier-Oblique"/>
				      </dia:attribute>
				      <dia:attribute name="classname_font">
				        <dia:font family="sans" style="80" name="Helvetica-Bold"/>
				      </dia:attribute>
				      <dia:attribute name="abstract_classname_font">
				        <dia:font family="sans" style="88" name="Helvetica-BoldOblique"/>
				      </dia:attribute>
				      <dia:attribute name="comment_font">
				        <dia:font family="sans" style="8" name="Helvetica-Oblique"/>
				      </dia:attribute>
				      <dia:attribute name="normal_font_height">
				        <dia:real val="0.80000000000000004"/>
				      </dia:attribute>
				      <dia:attribute name="polymorphic_font_height">
				        <dia:real val="0.80000000000000004"/>
				      </dia:attribute>
				      <dia:attribute name="abstract_font_height">
				        <dia:real val="0.80000000000000004"/>
				      </dia:attribute>
				      <dia:attribute name="classname_font_height">
				        <dia:real val="1"/>
				      </dia:attribute>
				      <dia:attribute name="abstract_classname_font_height">
				        <dia:real val="1"/>
				      </dia:attribute>
				      <dia:attribute name="comment_font_height">
				        <dia:real val="0.69999999999999996"/>
				      </dia:attribute>
				      <dia:attribute name="attributes"/>
				      %%OPERATIONS%%
				      <dia:attribute name="template">
				        <dia:boolean val="false"/>
				      </dia:attribute>
				      <dia:attribute name="templates"/>
			    	</dia:object>';
		
		$this->_addXml($content);
		
		$this->_classX++;
		
	}
	
	
	/**
	 * Sets the file template
	 */
	private function _setTemplate(){
		
		$content = '<?xml version="1.0" encoding="UTF-8"?>
						<dia:diagram xmlns:dia="http://www.lysator.liu.se/~alla/dia/">
						  <dia:diagramdata>
						    <dia:attribute name="background">
						      <dia:color val="#ffffff"/>
						    </dia:attribute>
						    <dia:attribute name="pagebreak">
						      <dia:color val="#000099"/>
						    </dia:attribute>
						    <dia:attribute name="paper">
						      <dia:composite type="paper">
						        <dia:attribute name="name">
						          <dia:string>#A4#</dia:string>
						        </dia:attribute>
						        <dia:attribute name="tmargin">
						          <dia:real val="2.8222000598907471"/>
						        </dia:attribute>
						        <dia:attribute name="bmargin">
						          <dia:real val="2.8222000598907471"/>
						        </dia:attribute>
						        <dia:attribute name="lmargin">
						          <dia:real val="2.8222000598907471"/>
						        </dia:attribute>
						        <dia:attribute name="rmargin">
						          <dia:real val="2.8222000598907471"/>
						        </dia:attribute>
						        <dia:attribute name="is_portrait">
						          <dia:boolean val="true"/>
						        </dia:attribute>
						        <dia:attribute name="scaling">
						          <dia:real val="1"/>
						        </dia:attribute>
						        <dia:attribute name="fitto">
						          <dia:boolean val="false"/>
						        </dia:attribute>
						      </dia:composite>
						    </dia:attribute>
						    <dia:attribute name="grid">
						      <dia:composite type="grid">
						        <dia:attribute name="width_x">
						          <dia:real val="1"/>
						        </dia:attribute>
						        <dia:attribute name="width_y">
						          <dia:real val="1"/>
						        </dia:attribute>
						        <dia:attribute name="visible_x">
						          <dia:int val="1"/>
						        </dia:attribute>
						        <dia:attribute name="visible_y">
						          <dia:int val="1"/>
						        </dia:attribute>
						        <dia:composite type="color"/>
						      </dia:composite>
						    </dia:attribute>
						    <dia:attribute name="color">
						      <dia:color val="#d8e5e5"/>
						    </dia:attribute>
						    <dia:attribute name="guides">
						      <dia:composite type="guides">
						        <dia:attribute name="hguides"/>
						        <dia:attribute name="vguides"/>
						      </dia:composite>
						    </dia:attribute>
						  </dia:diagramdata>
						  <dia:layer name="Fondo" visible="true" active="true">
						  %%CURSOR%%
						  </dia:layer>
						</dia:diagram>';
		
		$this->_content = $content;
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $xml
	 */
	private function _addXml($xml, $token = '%%CURSOR%%'){
		
		$this->_content = str_ireplace($token, $xml . $token, $this->_content);
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $filename
	 * @param unknown_type $path
	 */
	public function writeFile($filename, $path = '.'){
		
		$filepath = realpath($path) . DIRECTORY_SEPARATOR . $filename;
		$content = str_ireplace('%%CURSOR%%', null, $this->_content);

		$f = fopen($filepath, 'w');
		fwrite($f, $content);
		
	}
	
}