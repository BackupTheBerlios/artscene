<?
/**
	xml parser using expat functions
	
	Created: js, 2002.10.22
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package core	
*/


/**
*/
include_once( RELPATH . LIBDIR . 'fuxmlnode.class.php' );

/**
*	@version $Id: fuxmlsax.class.php,v 1.2 2003/04/06 23:02:09 pukomuko Exp $
*/

class fuXmlSax
{
	var $parser = null;
	var $trimspace = true;
	var $tree = array();
	
		
	var $vals = false;
	var $valcount = false;

	
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

	}
	
	/**
	* parse given xml string and return xmlnode tree
	*
	* @param string $str - content of file
	* @return fuXmlNode
	*/
	function &parse($str)
	{
		xml_parse_into_struct($this->parser, $str, &$this->vals, $index);
		xml_parser_free($this->parser);

		$this->valcount = count($this->vals);
		$i = 0;


	    $this->tree =& new fuXmlNode($this->vals[$i]['tag']);
		if ( isset($this->vals[$i]['attributes']) )
		{
			$this->tree->setAttributes( $this->vals[$i]['attributes'] );
		} 

		$this->xml_depth(&$this->tree, $i);

		unset($this->vals);

		return $this->tree;
	}


	/**
	* returns array(children, content)
	*/
	function xml_depth(&$parent, &$i)
	{

		if ( isset($this->vals[$i]['value']) )
		{
			$parent->setContent($this->vals[$i]['value']);
		}


		while (++$i < $this->valcount) 
		{ 

			switch ($this->vals[$i]['type']) 
			{ 

			   case 'open':

					if ( isset ( $this->vals[$i]['tag'] ) )
					{
						$tagname = $this->vals[$i]['tag'];
					} 
					else 
					{
						$tagname = '';
					}

				    $node =& new fuXmlNode($tagname);

					if ( isset ( $this->vals[$i]['attributes'] ) ) 
					{
						$node->setAttributes($this->vals[$i]['attributes']);
					}
					
					$parent->addChild(&$node);

					$this->xml_depth(&$node, &$i);

				break; 


				case 'cdata':
					$parent->addContent( $this->vals[$i]['value'] );
				break; 

				case 'complete':
					
					$node =& new fuXmlNode($this->vals[$i]['tag']);

					if( isset($this->vals[$i]['value']) )
					{
						$node->setContent($this->vals[$i]['value']);
					} 
					else 
					{
						$node->setType('oneliner');
					}

					if ( isset($this->vals[$i]['attributes']) ) 
					{
						$node->setAttributes($this->vals[$i]['attributes']);
					}

					$parent->addChild(&$node);

				break; 

				case 'close':
					return true; 
				break;
			} 

		} 

		return true;

	}
	
}

cvs_id('$Id: fuxmlsax.class.php,v 1.2 2003/04/06 23:02:09 pukomuko Exp $');

?>