<?
/**
	xml file to ini interface
	
	Created: js, 2002.04.04
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package core	
*/
/**
*/

include_once( RELPATH . LIBDIR . 'fuxml.class.php' );
include_once( RELPATH . LIBDIR . 'fuxmlsax.class.php' );

/**
* provides ini functions for xml document
*
* @version $Id: fuxmlini.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuXmlIni
{
	/// dom tree
	var $xmlTree;

	/// source string
	var $xmlDoc = '';

    var $filename =  ""; 

	/// instance of fuerror
    var $kernel = false; 

    var $write_access = "";
    

    /**
    * Constructs a new fuIni object.
    */
    function fuXmlIni( &$kernel, $inifilename="", $write = false )
    {
		$this->kernel =& $kernel;
        $this->loadData( $inifilename, $write );
    } 

    function loadData( $inifilename="", $write = false )
    {
        $this->write_access = $write;
        if ( !empty($inifilename) )
        {
            if ( !file_exists($inifilename) )
            { 
                $this->error( "This file ($inifilename) does not exist!"); 
                return; 
            }
            $this->parse($inifilename);
        }
    }

    /**
    * Parses the ini file.
    */
    function parse( $inifilename )
    {
        $this->filename = $inifilename;
        
        if( $this->write_access )
            $fp = fopen( $inifilename, "r+" ); 
        else
            $fp = fopen( $inifilename, "r" );

        $this->xmlDoc = fread($fp, filesize($inifilename));
        fclose( $fp ); 

        if (function_exists('xml_parser_create'))
        {
        	$parser =& new fuXmlSax();
        	$this->xmlTree = $parser->parse( $this->xmlDoc );
        }
        else 
        {
        	
        	$this->xmlTree = fuXml::arrayTree( $this->xmlDoc );
        }
        
        
	} 

    /**
    * Saves the ini file.
    */
    function saveData() 
    {
        $fp = fopen($this->filename, "w");

        if ( empty($fp) ) 
        { 
            $this->error( "Cannot create file $this->filename"); 
            return false; 
        } 
        
		include_once(RELPATH . LIBDIR . 'fuxml.class.php');
		fwrite($fp, fuXML::writeTree($this->xmlTree, 1));
        fclose($fp); 
    } 

	/**
	* content of the tag at root/tag/subtag
	*/
	function getValue($address, $report_error = false )
	{
		$tags = explode('/', $address);
		$tmp =& $this->xmlTree;
		$i = 0;
		while ( isset($tags[$i]) && isset($tmp['children'][$tags[$i]]))
		{
			$tmp =& $tmp['children'][$tags[$i]];
			$i++;
		}

		if ($tmp['name'] == $tags[count($tags)-1]) 
		{
			return $tmp['content'];
		}
		else
		{
			if ($report_error) $this->error("valute at $address not found");
			return false;
		}
		
	}

	function getIniValue($group, $name)
	{
		if (isset($this->xmlTree) && isset($this->xmlTree)
			&& isset($this->xmlTree['children'][$group])
			&& isset($this->xmlTree['children'][$group]['children'][$name]))
		{
			return $this->xmlTree['children'][$group]['children'][$name]['content'];
		}
		else
		{
			$this->error("no such record $group-$name");
			return false;
		}
	}

	/**
	* value of param $name at $address
	*/
	function getParam($address, $name, $report_error = false)
	{
		$tags = explode('/', $address);
		$tmp =& $this->xmlTree;
		$i = 0;
		while ( isset($tags[$i]) && isset($tmp['children'][$tags[$i]]))
		{
			$tmp =& $tmp['children'][$tags[$i]];
			$i++;
		}

		if ($tmp['name'] == $tags[count($tags)-1]) 
		{
			if (isset($tmp['attributes'][$name]))
			{
				return $tmp['attributes'][$name];
			}
			else
			{
				if ($report_error) $this->error("no param $name at $address");
				return false;
			}
		}
		else
		{
			if ($report_error) $this->error("valute at $address not found");
			return false;
		}

	}

	/**
	* return reference to the branch of xmlTree at $address
	*/
	function &getNode($address, $report_error = false)
	{
		$tags = explode('/', $address);
		$tmp =& $this->xmlTree;
		$i = 0;
		while ( isset($tags[$i]) && isset($tmp['children'][$tags[$i]]))
		{
			$tmp =& $tmp['children'][$tags[$i]];
			$i++;
		}

		if ($tmp['name'] == $tags[count($tags)-1]) 
		{
			return $tmp;
		}
		else
		{
			if ($report_error) $this->error("valute at $address not found");
			return false;
		}
	}

    function getSimpleArray($address)
	{
		$node =& $this->getNode($address);
		$out = false;
		for( $child = 0; isset($node['children'][$child]); $child++ )
		{
			foreach($node['children'][$child]['children'] as $item)
			{
				$out[$child][$item['name']] = $item['content'];
			}
		}
		return $out;
	}

    /**
    * Sets a variable in a group.
    */
    function set_var( $group, $var_name, $var_value )
    {
		//~! not implemented
    }     


    /**
    * Prints the error message.
    */
    function error($errmsg) 
    {
		$this->kernel->error->report( eWARNING, 'fuXmlIni: ' . $errmsg);
        return; 
    }

} 

cvs_id('$Id: fuxmlini.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>