<?
/**
	xml parser using expat functions
	
	Created: js, 2002.10.22
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package core	
*/
/**
*	creates tree implemented in arrays from xml source, using expat library
*
*	$root['name']
*		content
*		attributes
*		children = array
*
*	@version $Id: fuxmlsax.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuXmlSax
{
	var $parser = null;
	var $trimspace = true;
	var $tree = array();
	
	var $currNode = array();
	
	var $blankNode =  array(
			'name'=>'', 
			'type'=>'', 
			'attributes'=>array(), 
			'content'=>'',
			'children'=>array()
		);
		
	var $nodeStack = array();
	var $stackPtr = 0;
	var $wasData = false;
	
	function fuXmlSax( $trimspace = true )
	{
		$this->trimspace = $trimspace;
		$this->setXmlParser();
	}
	
	/**
	* setup routines
	*/
	function setXmlParser()
	{
		$this->parser = xml_parser_create();
		xml_set_object($this->parser, &$this);
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
		if ($this->trimspace) xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
		xml_set_element_handler($this->parser, "startElement", "endElement");
        xml_set_character_data_handler($this->parser, "elementData");        
	}
	
	/**
	* parse given xml string and return arrayTree
	*
	* @param string $str - content of file
	* @return array
	*/
	function parse($str)
	{
		$this->tree = array(
			'name'=>'', 
			'type'=>'', 
			'attributes'=>array(), 
			'content'=>'',
			'children'=>array()
		);
		
		xml_parse($this->parser, $str, true);
		
		$this->tree = false;
		if (isset($this->nodeStack[0]['children'])) $this->tree = current($this->nodeStack[0]['children']);
		
		return $this->tree;
	}
	
	function startElement($parser, $tag, $attributes)
	{
		$this->nodeStack[$this->stackPtr] = $this->currNode;
		$this->stackPtr++;
		
		$this->currNode = $this->blankNode;
		$this->currNode['name'] = $tag;
		$this->currNode['attributes'] = $attributes;
		
		$this->wasData = false;
	}
	
	function endElement($parser, $tag)
	{
		if (!$this->wasData && empty($this->currNode['children'])) $this->currNode['type'] = 'oneliner';
		$this->nodeStack[$this->stackPtr] = $this->currNode;
		$this->stackPtr--;
		
		$this->nodeStack[$this->stackPtr]['children'][$this->currNode['name']] = $this->currNode;
		$this->nodeStack[$this->stackPtr]['children_array'][] = $this->currNode;
		$this->currNode = $this->nodeStack[$this->stackPtr];
	}
	
	function elementData($parser, $cdata)
	{
		$this->currNode['content'] .= $cdata;
		$this->wasData = true;
	}
}

cvs_id('$Id: fuxmlsax.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>