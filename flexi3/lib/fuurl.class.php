<?
/**
	url creation class
	
	Created: js, 2002.11.13
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
*	@package core	
*/

/**
* url container
*
* galbut reiktu jei nera base, tai ri delimiterio nedeti?, kad grazintu itk name=value
* gal dar reiktu & kad butu keiciamas
* @version $Id: fuurl.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuUrl
{
	var $pairs = array();
	var $base = '';
	var $delimiter = '?';
	
	function fuUrl( $base = '', $array = array(), $delimiter = '?')
	{
		$this->pairs = $array;
		$this->setBase($base);
		$this->setDelimiter($delimiter);
	}
	
	/**
	* add pair $name=$value to url
	*/
	function add( $name, $value )
	{
		$this->pairs[$name] = urlencode($value);
	}
	
	/**
	* add array of value pairs to url
	*/
	function addArray( $array )
	{
		$this->pairs = array_merge($this->pairs, $array);
	}
	
	/**
	* delete variable $name from url
	*/
	function delete( $name )
	{
		if (isset($this->pairs[$name])) unset($this->pairs[$name]);
	}
	
	/**
	* set base of url http://...
	*/
	function setBase( $url )
	{
		$this->base = $url;
	}
	
	/**
	*/
	function setDelimiter( $char )
	{
		$this->delimiter = $char;
	}
	
	/**
	*/
	function getUrl()
	{
		$url = $this->base . $this->delimiter;
		foreach ($this->pairs as $name=>$value)
		{
			$url .= "$name=$value&";
		}
		
		return $url;
	}
}

cvs_id('$Id: fuurl.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>