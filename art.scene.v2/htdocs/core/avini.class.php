<?
/*
	implements a simple .ini file parser
	
	Created: Jo Henrik Endrerud
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/

/////////////////////////////////////////////////////////////////////////  
//  
//  class.INIfile.php  -  implements  a  simple  INIFile Parser  
//   
//  Author:  MO 
//   
//  Description:  
//    I just wondered how to save simple parameters not in a database but in a file 
//  So starting every time from scratch isn't comfortable and I decided to write this 
//  small unit for working with ini like files 
//  Some  Examples:  
//     
//    $ini = new INIFile("./ini.ini"); 
//  //Read entire group in an associative array 
//    $grp = $ini->read_group("MAIN"); 
//    //prints the variables in the group 
//    if ($grp) 
//    for(reset($grp); $key=key($grp); next($grp)) 
//    { 
//        echo "GROUP ".$key."=".$grp[$key]."<br>"; 
//    } 
//    //set a variable to a value 
//    $ini->set_var("NEW","USER","JOHN"); 
//  //Save the file 
//    $ini->save_data(); 
//
//    Modified by Jo Henrik Endrerud <jhe@ez.no> for eZ systems
//    Modified by Bård Farstad <bf@ez.no>
//    Modified by Jan Borsodi <jb@ez.no>

//!! core lib
//! This class provides .ini file functions
/*!
  The INI file class supports comments which starts with a # and stops at the end of the line,
  this means that one cannot use these characters in groups, keys or values.

  The INI file can also read MS-DOS text files,
  which has an extra carriage return to signal an end of line.

  \code
  include_once( "classes/phIni.class.php" );
  $ini = new phIni( "site.ini" );

  $PageCaching = $ini->read_var( "eZArticleMain", "PageCaching" );

  $arrayTest = $ini->read_array( "site", "ArrayTest" );

  foreach ( $arrayTest as $test )
  {
    print( "test: ->$test<-<br>" );
  }  
  \endcode
*/

/*

CHANGES:
	2001.11.04, js
	+ var_exists()
		
*/
class avIni
{ 

    var $INI_FILE_NAME =  ""; 
    var $ERROR =  ""; 
    var $GROUPS = array();
    var $CURRENT_GROUP =  "";
    var $WRITE_ACCESS = ""; 

    /*!
      Constructs a new avIni object.
    */
    function avIni( $inifilename="", $write = false )
    {
        $this->load_data( $inifilename, $write );
    } 

    function load_data( $inifilename="", $write = false )
    {
        $this->WRITE_ACCESS = $write;
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

    /*!
      Parses the ini file.
    */
    function parse( $inifilename )
    { 
        $this->INI_FILE_NAME = $inifilename;
        
        if( $this->WRITE_ACCESS )
            $fp = fopen( $inifilename, "r+" ); 
        else
            $fp = fopen( $inifilename, "r" );

        $this->CURRENT_GROUP=false;
        $this->GROUPS=array();
        $contents =& fread($fp, filesize($inifilename)); 
        $ini_data =& split( "\n",$contents); 
         
        while( list($key, $data) = each($ini_data) ) 
        {	
            $this->parse_data($data); 
        }

        fclose( $fp ); 
    } 

    /*!
      Parses the variable.
    */
    function parse_data( $data )
    {
		
        // Remove comments from line
        if ( preg_match( "/([^#]*)#.*/", $data, $m ) )
        {
            $data = $m[1];
        }
        // Remove MS-DOS Carriage return from end of line
		$tmp_index = strlen($data) - 1;
        if ( $tmp_index>-1 && ord( $data[$tmp_index] ) == 13 )
            $data = substr( $data, 0, strlen($data) - 1 );

        if( ereg( "\[([[:alnum:]]+)\]", $data, $out ) )
        {
            $this->CURRENT_GROUP = strtolower( $out[1] ); 
        } 
        elseif (!empty($data)) 
        {
            $split_data =& split( "=", $data ); 
            $this->GROUPS[ $this->CURRENT_GROUP ][ $split_data[0] ] = $split_data[1]; 
        }
    }

    /*!
      Saves the ini file.
    */
    function save_data() 
    {
        $fp = fopen($this->INI_FILE_NAME, "w");

        if ( empty($fp) ) 
        { 
            $this->Error( "Cannot create file $this->INI_FILE_NAME"); 
            return false; 
        } 
         
        $groups = $this->read_groups(); 
        $group_cnt = count($groups); 

		fwrite($fp, "#<?php \n\n");
        for($i=0; $i<$group_cnt; $i++) 
        { 
            $group_name = $groups[$i];
            if ( $i == 0 )
            {
                $res = sprintf( "[%s]\n",$group_name);
            }
            else
            {
                $res = sprintf( "\n[%s]\n",$group_name);
            }
            fwrite($fp, $res); 
            $group = $this->read_group($group_name); 
            for(reset($group); $key=key($group);next($group)) 
            { 
                $res = sprintf( "%s=%s\n",$key,$group[$key]); 
                fwrite($fp,$res); 
            } 
        } 
         
        fclose($fp); 
    } 

    /*!
      Returns the number of groups.
    */
    function get_group_count() 
    { 
        return count($this->GROUPS); 
    } 
     
    /*!
      Returns an array with the names of all the groups.
    */
    function read_groups() 
    { 
        $groups = array(); 
        for (reset($this->GROUPS);$key=key($this->GROUPS);next($this->GROUPS)) 
            $groups[]=$key; 
        return $groups; 
    } 

    /*!
      Checks if a group exists.
    */
    function group_exists( $group_name )
    {
        $group_name = strtolower( $group_name );
        $group =& $this->GROUPS[$group_name];
        if (empty($group)) return false; 
        else return true; 
    } 

    /*!
      Returns an associative array of the variables in one group.
    */
    function read_group($group) 
    {
        $group = strtolower( $group );
        $group_array =& $this->GROUPS[$group]; 
        if(!empty($group_array))  
            return $group_array; 
        else  
        { 
            $this->Error( "Group $group does not exist"); 
            return false; 
        } 
    } 
     
    /*!
      Adds a new group to the ini file.
    */
    function add_group($group_name) 
    {
        $group_name = strtolower( $group_name );
        $new_group = $this->GROUPS[$group_name]; 
        if ( empty($new_group) ) 
        { 
            $this->GROUPS[$group_name] = array(); 
        } 
        else
        {
            $this->Error( "Group $group_name exists");
        }
    } 

    /*!
      Clears a group.
    */
    function empty_group($group_name) 
    {
        $group_name = strtolower( $group_name );
        unset( $this->GROUPS[$group_name] );
        $this->GROUPS[$group_name] = array();
    } 

    /*!
      Reads a variable from a group.
    */
    function read_var( $group, $var_name )
    {
        $group = strtolower( $group );
        if ( !isset( $this->GROUPS[$group] ) or !isset( $this->GROUPS[$group][$var_name] ) )
        {
            $this->Error( "$var_name does not exist in $group");
            return false;
        }
        return $this->GROUPS[$group][$var_name];
    }

    /*!
      Checks if a var exists.
    */
    function var_exists( $group, $var_name )
    {
        $group = strtolower( $group );
        if ( !isset( $this->GROUPS[$group] ) or !isset( $this->GROUPS[$group][$var_name] ) )
        {
            return false;
        }
        return true;
    }


    /*!
      Reads a variable from a group and returns the result as an
      array of strings.

      The variable is splitted on ; characters.
    */
    function read_array( $group, $var_name )
    {
        $var_value =& $this->read_var( $group, $var_name );
        if ( $var_value )
        {
            $var_array =& explode( ";", $var_value );
            return $var_array;
        }
        else
        {
            $this->Error( "array $var_name does not exist in $group");
            return false; 
        }
    }
     
    /*!
      Sets a variable in a group.
    */
    function set_var( $group, $var_name, $var_value )
    {
        $group = strtolower( $group );
		if (!isset($this->GROUPS[$group])) { $this->GROUPS[$group] = array(); }
        $this->GROUPS[$group][$var_name] = $var_value;
    }     


    /*!
      Prints the error message.
    */
    function error($errmsg) 
    {
		global $g_error;
        $this->ERROR = $errmsg; 
		$g_error->error('avIni: ' . $this->ERROR, 'warning');
        return; 
    }

    /*!
      \static
      Returns the global ini file for a given type. Normally the type is the site.ini INI object,
      loaded from the site.ini file. This can be overidden by supplying $type and $file.
      If the ini-file object does not exist it is created before returning.
    */
    function &globalINI( $file = false )
    {
		global $RELPATH;
		empty($file) && $file = $RELPATH . 'global.ini.php';
        $ini =& $GLOBALS['g_ini'];

        if ( get_class( $ini ) != 'avini' )
        {
            $ini = & new avIni( $file );
        }
        return $ini;
    }

    
} 

?>