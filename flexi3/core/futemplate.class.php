<?
/**
	template engine
	
	Created: js, 2001.03.15
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package core	
*/
//---------------------------------------------------------------------------//
// author: pukomuko <salna@ktl.mii.lt> 
// date:   2001.03.15
// web:    http://pukomuko.esu.lt
// info:   template engine
//---------------------------------------------------------------------------//
// copyleft license
//
// this software is provided 'as-is', without any express or implied
// warranty. in no event will the authors be held liable for any damages
// arising from the use of this software.
//
// permission is granted to anyone to use this software for any purpose,
// including commercial applications, and to alter it and redistribute it
// freely, subject to the following restrictions: 
//
// 1. the origin of this software must not be misrepresented;
//    you must not claim that you wrote the original software. 
//    if you use this software in a product, an acknowledgment 
//    in the product documentation would be appreciated but is not required.
//
// 2. altered source versions must be plainly marked as such, 
//    and must not be misrepresented as being the original software.
//
// 3. mail about the fact of using this class in production 
//    would be very appreciated.
//
// 4. this notice may not be removed or altered from any source distribution.
//
//---------------------------------------------------------------------------//
// changes:
//
//	2003.03.14
//		+ process() now accepts parameters as bits
//		+ set_params() set default parameters for process()
//		* v.1.8.1
//		
//	2003.03.14
//		+ phpdoc comments
//		* v1.8
//
//  2002.11.13
//		- $block_names no more
//		- bug in extract blocks
//
//	2002.09.24
//		* parse now accpets string instead of handle
//		+ optional() <opt>
//		* root change
//		* <!--block syntax
//
//	2002.03.23
//		- bug with templates caintaining { a { b }
//		* v1.7.1
//
//	2002.03.03
//		* fopen fread fclose instead of implode(file()), up to 3x faster
//		+ remove_nonjs - remove only variables that have no spaces in them
//		* speed improvements, got rid of list() = each()
//		+ license :]
//		* v1.7
//
//	2002.03.02
//		- deleted space before each line in the parsed template.
//		- error in method error() :]
//		* v1.6.2 note released :]
//
//	2001.12.06
//		- bug then text had only }
//		* v1.6.1
//
//  2001.10.31
//		+ error on unclosed block
//		+ nested blocks
//		* v1.6
//		
//	2001.09.17
//		- fixed bug with 'keep'
//
//  2001.09.02
//		+ get_var_silent()
//
//  2001.08.09
//		+ error handler
//
//  2001.07.04
//		+ one pass substitution
//
//	2001.05.28
//		+ block name recording
//		* v1.5.1
//
//	2001.05.10
//		- bug in documentation
//
//	2001.05.08
//		* first public release v1.5
//
//	2001.04.04
//		* changed blocks setup, constructor parameters change
//		- error bug
//		- some warnings

/**
*/
define('TPL_LOOP',		1);
define('TPL_NOLOOP',	2);
define('TPL_INCLUDE',	4);
define('TPL_APPEND',	8);
define('TPL_FINISH',	16);
define('TPL_OPTIONAL',	32);
define('TPL_LOOPOPT',	64);

define('TPL_BLOCK',		1);
define('TPL_BLOCKREC',	2);

/**
* template engine
* @version $Id: futemplate.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuTemplate
{

	/**
	* variables and blocks
	*/
	var $vars = array();
	
	/**
	* loops container
	*/
	var $loops = array();

	/**
	* dir of template files
	*/
	var $root = '';

	/**
	* what to do with unknown variables in template?
	*/
	var $unknowns = 'keep';

	/**
	* default parameters for process() loop, append, finish
	*/
	var $parameters = 0;
	
	/**
	*	constructor
	*/
	function fuTemplate( &$kernel, $root_dir = '', $unknowns = 'keep', $params = 0)
	{
		$this->kernel =& $kernel;
		$this->set_root($root_dir);
		$this->set_unknowns($unknowns);
		$this->set_params($params);

		debug('fuTemplate: started.');
	}

	/**
	*	check and set template root dir
	*/
	function set_root($root)
	{
		if (!is_dir($root)) 
		{
			$this->error("set_root(): $root is not a directory.");
			return false;
		}
		
		$this->root = $root;
		return true;
	}

	/**
	*	what to do with unknown variables in template?
	*	keep
	*	remove
	*	remove_nonjs
	*	comment
	*	space
	*/
	function set_unknowns($unk)
	{
		$this->unknowns = $unk;
	}

	/**
	* set default parameters for process()
	*/
	function set_params($params)
	{
		$this->parameters = $params;
	}

	/**
	*	read file template into $vars, no array of files
	*	@param string $handle - name of handle for file contents
	*	@param int $blocks - 1 for <block> search, 2 for nested blocks
	*
	*/
	function set_file($handle, $filename = "", $blocks = false)
	{
			if ($filename == "") 
			{
				$this->error("set_file(): for handle $handle filename is empty.", FU_E_FATAL);
				return false;
			}
			$this->vars[$handle] = $this->read_file($filename);
			if ($blocks) { $this->extract_blocks($handle, $blocks & TPL_BLOCKREC); }
			return true;

	}


	/**
	*	set handle and value,
	*	if value is array, all elements will be named: handle.key.subkey
	*/
	function set_var($var_name, $var_value)
	{
		if (is_array($var_value)) 
		{
			foreach($var_value as $key=>$value)
			{
				$this->set_var($var_name . '.' . $key, $value); // recursion for array branches
			}
		}
		else // normal variable
		{
			$this->vars[$var_name] = $var_value;
		}
	}


	/**
	*	value of $handle
	*	raises error if $handle undefined
	*/
	function get_var($handle)
	{
		if (!isset($this->vars[$handle])) { $this->error("no such handle '$handle'"); }
		return $this->vars[$handle];
	}

	/**
	*	value of $handle, no error if no handle
	*/
	function get_var_silent($handle)
	{
		if (!isset($this->vars[$handle])) { $this->vars[$handle] = ''; return ''; }
		return $this->vars[$handle];
	}

	/**
	*	assign array to loop handle
	*	@param string $loop_name - name for a loop
	*	@param int $loop - loop data
	*/
	function set_loop($loop_name, $loop)
	{
		if (!$loop) $loop = 0;
		$this->loops[$loop_name] = $loop;
	}


	/**
	*	extracts blocks from handle, and returns cleaned up version
	*
	*	must be quite fast, because every found block is imediately taken out of string
	*
	*	won't work for nested blocks
	*
	*	@since 2001.10.31 works with nested blocks [js]
	*
	*/
	function extract_blocks($bl_handle, $recurse = false)
	{

		$str = $this->get_var($bl_handle);
		if (!$str) return $str;
		$bl_start = 0;

		// extract and clean them from parent handle
		while(is_long($bl_start = strpos($str, '<!--block name="', $bl_start)))
		{
			$pos = $bl_start + 16;

			$endpos = strpos($str, '"-->', $pos);
			$handle = substr($str, $pos, $endpos-$pos);

			$tag = '<!--block name="'.$handle.'"-->';
			$endtag = '<!--/block name="'.$handle.'"-->';

			$start_pos = $bl_start + strlen($tag);
			$end_pos = strpos($str, $endtag, $bl_start);
			if (!$end_pos) { $this->error("block '$handle' has no ending tag", FU_E_FATAL); }
			$bl_end = $end_pos + strlen($endtag);

			$block_code = substr($str, $start_pos, $end_pos-$start_pos);
			
			$this->set_var($handle, $block_code);

			$part1 = substr($str, 0, $bl_start);
			$part2 = substr($str, $bl_end, strlen($str));
			
			$str = $part1 . $part2;


			if ($recurse) { $this->extract_blocks($handle, 1); }

		}
		
		$this->set_var($bl_handle, $str);

	}


	/**
	*	search for <include> tags in $handle
	*	be carefull with paths
	*/
	function include_files($handle)
	{
		$str = $this->get_var($handle);

		while(is_long($pos = strpos($str, '<include filename="')))
		{
			$pos += 19;
			$endpos = strpos($str, '">', $pos);
			$filename = substr($str, $pos, $endpos-$pos);
			$tag = '<include filename="'.$filename.'">';

			
			$include = $this->read_file($filename);

			$str = str_replace($tag, $include, $str);
		}

		return $str;
	}


	/**
	*	searches for all set loops in $handle, returns text of $handle with parsed loops
	*	@param bool $noloop - must be true, if you want noloop statement
	*	@return string
	*/
	function parse_loops($handle, $noloop = false)
	{
		$str = $this->get_var($handle);
		
		reset($this->loops);

		while ( list($loop_name, $loop_ar) = each($this->loops) )
		{

			$start_tag = strpos($str, '<loop name="'.$loop_name.'">');

			$start_pos = $start_tag + strlen('<loop name="'.$loop_name.'">');
			if (!$start_pos) continue;
			$end_pos = strpos($str, '</loop name="'.$loop_name.'">');

			$loop_code = substr($str, $start_pos, $end_pos-$start_pos);
			$org_loop_code = $loop_code;
			
			$start_tag = substr($str, $start_tag, strlen('<loop name="'.$loop_name.'">'));
			$end_tag = substr($str, $end_pos, strlen('</loop name="'.$loop_name.'">'));

			if($loop_code != ''){
					
					$new_code = '';

					// clean <noloop... statement from loopcode
					if ($noloop)
					{
						
						$nl_start_tag = strpos($loop_code, '<noloop name="'.$loop_name.'">');
						$nl_start_pos = $nl_start_tag + strlen('<noloop name="'.$loop_name.'">');

						if ($nl_start_pos)
						{
							
							$nl_end_pos = strpos($loop_code, '</noloop name="'.$loop_name.'">');

							$noloop_code = substr($loop_code, $nl_start_pos, $nl_end_pos - $nl_start_pos);
	 
							
							$nl_start_tag = substr($loop_code, $nl_start_tag, strlen('<noloop name="'.$loop_name.'">'));
							$nl_end_tag = substr($loop_code, $nl_end_pos, strlen('</noloop name="'.$loop_name.'">'));
							$loop_code = str_replace($nl_start_tag.$noloop_code.$nl_end_tag, '', $loop_code);
						}

					}

					if (is_array($loop_ar))
					{
						// repeat for every row in array
						// for (reset($loop_ar); $row = current($loop_ar); next($loop_ar)) 
						$ar_keys = array_keys($loop_ar);
						$ar_size = count($ar_keys);
						for($i = 0; ($i< $ar_size); $i++)

						{	
							$temp_code = $loop_code;

							foreach( $loop_ar[$ar_keys[$i]] as $k=>$v)
							{
								$temp_code = str_replace( '{'. $loop_name. '.' .$k. '}', $v, $temp_code);
							}
							$new_code .= $temp_code;

						} // for loop
						
					} elseif ($noloop)
					{	
							$new_code = $noloop_code;
					}
					
					
					$str = str_replace($start_tag.$org_loop_code.$end_tag, $new_code, $str);
			} // if loop code
			
		} // repeat for loop names
	
		return $str;
	}
	

	/**
	*	substitute text and returns parsed string
	*/
	function parse($string)
	{
		//$str = $this->get_var($handle);

/*
		// old code for doing vars substitution very inefficient
		reset($this->vars);
		while ( list($k, $v) = each($this->vars) )
		{
			$str = str_replace ('{'. $k .'}', $v, $str);
		}
*/


		$str  = explode('{', $string);
		

		for ($i = 0; isset($str[$i]); $i++)
		{
			$line = explode('}', $str[$i]);
			
			if (count($line) == 1)
			{
				$out[$i]['key'] = '';
				$out[$i]['str'] = $line[0];
				$out[$i]['close'] = 0;
			}
			elseif (0 == $i)
			{
				$out[$i]['key'] = '';
				$out[$i]['str'] = implode('}', $line);
				$out[$i]['close'] = 0;
			}
			else
			{
				$out[$i]['key'] = $line[0];
				unset($line[0]);
				$out[$i]['str'] = implode('}', $line);
				$out[$i]['close'] = 1;
			}
			
		}

		if (isset($out[0]))
		{
			$str = $out[0]['str'];
		}
		else
		{
			$str = '';
		}

		for ($i = 1; isset($out[$i]); $i++)
		{
			if ( $out[$i]['key'] && isset($this->vars[$out[$i]['key']]) )
			{
				$out[$i]['key'] = $this->vars[$out[$i]['key']]; 
			}
			else
			{
				switch ($this->unknowns)
				{
					case "keep":
							if ($out[$i]['close'])
							{
								$out[$i]['key'] = '{' . $out[$i]['key'] . '}';
							}
							else
							{
								$out[$i]['key'] = '{' . $out[$i]['key'];
							}

					break;

					case "remove":
							$out[$i]['key'] = '';
					break;

					case "remove_nonjs":
							if ($out[$i]['key'] && (false === strpos($out[$i]['key'], ' ')))
							{
								$out[$i]['key'] = '';
							}
							else
							{
								if ($out[$i]['close'])
								{
									$out[$i]['key'] = '{' . $out[$i]['key'] . '}';
								}
								else
								{
									$out[$i]['key'] = '{' . $out[$i]['key'];
								}
							}
					break;

					case "comment":
							$out[$i]['key'] = '<!--'. $out[$i]['key'] .'-->';
					break;
					
					case "space":
							$out[$i]['key'] = '&nbsp;';
					break;

				}

			}
			$str .= $out[$i]['key'] . $out[$i]['str'];
		}

		return $str;
	}


	/**
	*	process left variables
	*	@deprecated parse() now handles unknown variables
	*/
	function finish($str)
	{
		switch ($this->unknowns)
		{
			case "keep":
			break;

			case "remove":
			$str = preg_replace('/{[^ \t\r\n}]+}/', "", $str);
			break;

			case "comment":
			$str = preg_replace('/{([^ \t\r\n}]+)}/', "<!-- {\\1} -->", $str);
			break;
			
			case "space":
			$str = preg_replace('/{([^ \t\r\n}]+)}/', "&nbsp;", $str);
			break;

		}

		return $str;
	}

	/**
	*	search for optional tag
	*	@param string $str  text
	*	@return string
	*/
	function optional($str)
	{
		$bl_start = 0;

		// extract and clean them from parent handle
		while(is_long($bl_start = strpos($str, '<opt name="', $bl_start)))
		{
			$pos = $bl_start + 11;

			$endpos = strpos($str, '">', $pos);
			$varname = substr($str, $pos, $endpos-$pos);
			
			$tag = '<opt name="'.$varname.'">';
			$endtag = '</opt name="'.$varname.'">';

			$end_pos = strpos($str, $endtag, $bl_start);
			if (!$end_pos) { $this->error("optional '$varname' has no ending tag", FU_E_FATAL); }

			$bl_end = $end_pos + strlen($endtag);


			$part1 = substr($str, 0, $bl_start);
			$part2 = substr($str, $bl_end, strlen($str));

			if ($this->get_var_silent($varname))
			{
				$start_pos = $bl_start + strlen($tag);

				$block_code = substr($str, $start_pos, $end_pos-$start_pos);
				
				$str = $part1 . $this->parse($block_code) . $part2;
			}
			else
			{
				$str =  $part1 . $part2;
			}

		}

		return $str;
	}

	/**
	*	does everything: loops, includes, variables, concatenation
	*   if $loop is 0 (not false, but 0) default parameters are used
	*   thanks ShiVAs for idea to have $loop as parameters.
	*
	*	@param $loop - loop, noloop or all parameters ored.	
	*	@param $append - append processed stuff to target, else $target is overwritten
	*	@return string
	*/
	function process($target, $handle, $loop = false, $include = false, $append = false, $finish = false, $optional = false)
	{
		if ($loop === 0) $loop = $this->parameters;
		
		$noloop = false;
		if ($loop > 1)
	        {
			$noloop = $loop & TPL_NOLOOP;
			$include = $loop & TPL_INCLUDE;
			$append = $loop & TPL_APPEND;
			$finish = $loop & TPL_FINISH;
			$optional = $loop & TPL_OPTIONAL;
		}
		
		if ($append and isset($this->vars[$target]))
		{
			$app = $this->get_var($target); // preserve old info
		}
		else
		{
			$app = '';
		}

		$this->set_var($target, $this->get_var($handle)); // copy contents

		if ($include) { $this->set_var($target, $this->include_files($target)); }

		
		if ($noloop) { $this->set_var($target, $this->parse_loops($target, 2)); }
		elseif ($loop) { $this->set_var($target, $this->parse_loops($target)); }

		if ($optional) { $this->set_var($target, $this->optional($this->get_var_silent($target))); }

		if ($append) { $this->set_var($target, $app . $this->parse($this->get_var_silent($target))); }
				else { $this->set_var($target, $this->parse($this->get_var($target))); }

		if ($finish) { $this->set_var($target, $this->finish($this->get_var($target))); }

		
		return $this->get_var($target);
	}


	/**
	*	spits out file contents
	*	@access private
	*/
	function read_file($filename) 
	{
		$filename = $this->root . $filename;

		if (!file_exists($filename))
		  $this->error("read_file(): file $filename does not exist.", FU_E_FATAL);

		$tmp = fread($fp = fopen($filename, 'r'), filesize($filename));
		fclose($fp);
		return $tmp;
	}



	/** 
	*	free mem used by loop
	*/
	function drop_loop($loop_handle)
	{
		if (isset($this->loops[$loop_handle])) unset($this->loops[$loop_handle]);
	}


	/** 
	*	free mem used by var
	*/
	function drop_var($handle)
	{
		if (isset($this->vars[$handle])) unset($this->vars[$handle]);
	}

	/**
	*	error report
	*/
	function error( $msg, $level = FU_E_WARNING)
	{
		$this->kernel->error->report($level, 'fuTemplate: ' . $msg);
	}

}

cvs_id('$Id: futemplate.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>