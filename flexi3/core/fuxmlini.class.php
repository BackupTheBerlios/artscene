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

include_once( RELPATH . LIBDIR . 'fuxmlsax.class.php' );

/**
* provides ini functions for xml document
*
* @version $Id: fuxmlini.class.php,v 1.2 2003/04/06 23:02:09 pukomuko Exp $
*/
class fuXmlIni
{
	/// dom tree
	var $xml_tree;

	/// source string
	var $xml_doc = '';

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
        
        $fp = fopen( $inifilename, "r" );

        $this->xml_doc = fread($fp, filesize($inifilename));
        fclose( $fp ); 

       	$parser =& new fuXmlSax();
        $this->xml_tree =& $parser->parse( $this->xml_doc );
       
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
        
		fwrite($fp, $this->xml_tree->toString(), 1);
        fclose($fp); 
    } 

	/**
	* content of the tag at root/tag/subtag
	*/
	function getValue($address, $report_error = false )
	{
		$tmp =& $this->xml_tree->getChildAt($address);
		if ($tmp)
		{
			return $tmp->getContent();
		}
		else
		{
			if ($report_error) $this->error("valute at $address not found");
			return false;
		}
	}

	function getIniValue($group, $name)
	{
		return $this->getValue("$group/$name");
	}

	/**
	* value of param $name at $address
	*/
	function getParam($address, $name, $report_error = false)
	{

		$tmp =& $this->xml_tree->getChildAt($address);

		if ($tmp) 
		{
			$attr = $tmp->getAttributes();
			if (isset($attr[$name]))
			{
				return $attr[$name];
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


    function getSimpleArray($address)
	{
		$node =& $this->xml_tree->getChildAt($address);
		$out = false;
		for( $child = 0; isset($node['children'][$child]); $child++ )
		{
			$out[$node['children'][$child]->getName()] = $node['children'][$child]->getContent();
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

cvs_id('$Id: fuxmlini.class.php,v 1.2 2003/04/06 23:02:09 pukomuko Exp $');

?>