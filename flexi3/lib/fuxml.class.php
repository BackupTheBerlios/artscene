<?
/**
	xml parser
	
	Created: js, 2002.03.24
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package core	
*/
//---------------------------------------------------------------------------//
// author: pukomuko <salna@ktl.mii.lt> 
// date:   2002.03.24
// web:    http://pukomuko.esu.lt
// info:   xml parser
//---------------------------------------------------------------------------//
// changes:
//	2002.03.26
//		- got rid of array_pop()
//		+ method writeTree(), returns string with xml from tree structure
//		* v0.4
//
//	2002.03.25
//		* first release v0.2
//		- bugfix: no content and params in certain conditions
//
//---------------------------------------------------------------------------//
// original comment:
//
// Bård Farstad <bf@ez.no>
// Created on: <16-Nov-2001 11:26:01 bf>
//
// This source file is part of eZ publish, publishing software.
// Copyright (C) 1999-2000 eZ systems as
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, US
//---------------------------------------------------------------------------//

/**
*	creates tree implemented in arrays from xml source
*
*	$root['name']
*		content
*		attributes
*		children = array
*
*	@version $Id: fuxml.class.php,v 1.2 2003/04/06 23:02:27 pukomuko Exp $
*/
class fuXml
{

	/**
	*/
	function fuXml()
	{
	}

	/**
	* Builds array tree from xml.
	*
	* @param string $xmlDoc - contains xml document string
	* @param bool $trimspace - should XML parser ignore whitespace between tags.
	* @return array
	*/
	function arrayTree( $xmlDoc, $trimspace = true  )
	{

		// strip header
		$xmlDoc = preg_replace( "#<\?.*?\?".">#", "", $xmlDoc );
		// strip comments
		$xmlDoc = fuXml::stripComments( $xmlDoc );


		// libxml compatible object	creation
		$blankNode = false;
		$blankNode['name'] = false;
		$blankNode['type'] = false;
		$blankNode['attributes'] = array();
		$blankNode['content'] = false;
		$blankNode['children'] = array();


		$currentNode = $blankNode;
		$subNode = $blankNode;
		
		$TagStack = array();
		$tagptr = -1;
		$pos = 0;
		$endTagPos = 0;
		$length_xmlDoc =  strlen($xmlDoc);


		while ( $pos < $length_xmlDoc )
		{
			$char = $xmlDoc[$pos];
			if ( $char == "<" )
			{
				// find tag name
				$endTagPos = strpos( $xmlDoc, ">", $pos );

				// tag name with attributes
				$tagName = substr( $xmlDoc, $pos + 1, $endTagPos - ( $pos + 1 ) );

				// check if	it's an	endtag </tagname>
				if ( $tagName[0] == "/" )
				{

					$lastNode = $TagStack[$tagptr];
					$lastTag = $lastNode['name'];
					$tagptr--;

					$TagStack[$tagptr]['children_array'][] = $lastNode;
					$TagStack[$tagptr]['children'][$lastNode['name']] = $lastNode; // assoc key
					
					$tagName = substr( $tagName, 1, strlen( $tagName ) );

					// strip out namespace; nameSpace:Name
					$colonPos = strpos( $tagName, ":" );

					if ( $colonPos > 0 )
						$tagName = substr( $tagName, $colonPos + 1,	strlen(	$tagName ) );
					
					
					if ( $lastTag != $tagName )
					{
						print( "Error parsing XML, unmatched tags $tagName" );
						return false;
					}
					else
					{
						// print( "endtag name: $tagName ending: $lastTag <br> " );
					}

				}
				else
				{
					$firstSpaceEnd = strpos( $tagName, " " );
					$firstNewlineEnd = strpos( $tagName, "\n" );

					if ( $firstNewlineEnd != false )
					{
						if ( $firstSpaceEnd	!= false )
						{
							$tagNameEnd = min( $firstSpaceEnd, $firstNewlineEnd );
						}
						else
						{
							
							$tagNameEnd = $firstNewlineEnd;
						}
					}
					else
					{
						if ( $firstSpaceEnd != false )
						{
							$tagNameEnd = $firstSpaceEnd;
						}
						else
						{
							$tagNameEnd = 0;
						}
					}
					
					if ( $tagNameEnd > 0 )
					{
						$justName = substr( $tagName, 0, $tagNameEnd );
					}
					else
						$justName = $tagName;


					// strip out namespace; nameSpace:Name
					$colonPos = strpos( $justName, ":" );

					if ( $colonPos > 0 )
						$justName = substr( $justName, $colonPos + 1, strlen( $justName ) );
					
					
					// remove trailing / from the name if exists
					if ( $justName[strlen($justName) - 1]  == "/" )
					{
						$justName = substr( $justName, 0, strlen( $justName	) - 1 );
					}
					
					

					// check for CDATA
					$cdataSection = "";
					$isCDATASection = false;
					$cdataPos = strpos( $xmlDoc, "<![CDATA[", $pos );
					if ( $cdataPos == $pos && $pos > 0)
					{
						$isCDATASection = true;
						$endTagPos = strpos( $xmlDoc, "]]>", $cdataPos );
						$cdataSection = substr( $xmlDoc, $cdataPos	+ 9, $endTagPos - ( $cdataPos + 9 ) );
						

						$TagStack[$tagptr]['content'] = $cdataSection;

						$pos = $endTagPos;
						$endTagPos += 2;
						
					}
					else
					{					 
						// normal start tag
						$subNode = $blankNode;
						$subNode['name'] = $justName;
					}
					
					$taglen = strlen($tagName);

					// find	attributes
					if ( $tagNameEnd > 0 )
					{
						$attributePart = substr( $tagName, $tagNameEnd, $taglen );

						// attributes
						$subNode['attributes'] = fuXml::parseAttributes( $attributePart );
					}

					// check it it's a oneliner: <tagname /> or a cdata section
					if ( ($isCDATASection == false) && ( $tagName[$taglen - 1] != "/" ) )
					{
						$tagptr++;
						$TagStack[$tagptr] = $subNode;

					}
					
					// this is one liner, just add to parent
					if ( $tagName[$taglen - 1] == "/" )
					{
						$TagStack[$tagptr];
						$subNode['type'] = 'oneliner';
						$TagStack[$tagptr]['children_array'][] = $subNode;
						$TagStack[$tagptr]['children'][$subNode['name']] = $subNode;
					}
				}
			}

			
			$pos = strpos( $xmlDoc,	"<", $pos + 1 );
			if ( $pos == false )
			{
				// end of document
				$pos = strlen( $xmlDoc );
			
			}
			else
			{
				// content tag
				$tagContent = substr( $xmlDoc, $endTagPos +	1, $pos - ( $endTagPos + 1 ) );

				if ( $trimspace )
				{
					$tagContent = trim($tagContent);
					$tagContent = str_replace("\n", '', $tagContent);
					$tagContent = str_replace("\r", '', $tagContent);
				}
				// convert special chars

				$tagContent = str_replace("'","&#039;", htmlspecialchars($tagContent));
				
				if ($tagptr > -1)
				{
					$TagStack[$tagptr]['content'] .= $tagContent;
				}
				
			}

		}
		
		$tmp = $TagStack[$tagptr];

		return current($tmp['children']);
	}

	/**
	  \static
	* @access private
	* @return string
	*/
	function stripComments(	$str )
	{
		$str = preg_replace( "#<\!--.*?-->#s", "", $str );
		return $str;
	}

	/**
	* Parses the attributes. Returns asssoc	array.
	  \static
	* @access private
	* @return array
	*/
	function parseAttributes( $attributeString )
	{
		$ret = array();
		
		preg_match_all( "/([a-zA-Z:]+=\".*?\")/", $attributeString, $attributeArray );

		foreach ( $attributeArray[0] as $attributePart )
		{
			$attributePart = $attributePart;

			if ( trim( $attributePart ) != "" && trim( $attributePart ) != "/" )
			{
				$attributeTmpArray = explode( '="', $attributePart );

				$attributeName = $attributeTmpArray[0];

				// strip out namespace; nameSpace:Name
				$colonPos = strpos( $attributeName, ":");

				if ( $colonPos > 0 )
					$attributeName = substr( $attributeName, $colonPos + 1, strlen( $attributeName ) );

				$attributeValue	= $attributeTmpArray[1];

				// remove " from value part
				$attributeValue	= substr( $attributeValue, 0, strlen( $attributeValue ) - 1);
				
				$ret[$attributeName] = $attributeValue;

			}
		}
		return $ret;
	}


	/**
	* write suplied xml dom tree structure to xml string
	* @return string
	*/
	function writeTree($xmlDom = false)
	{
		$out = '<?xml version="1.0"?'.">\n<!-- <?php -->\n";
		if (!$xmlDom) return $out;
		
		$out .= fuXml::writeTag($xmlDom, 0);

		return $out;
	}

	/**
	* recursive function for xml output
	* @return string
	*/
	function writeTag($xmlNode, $depth)
	{
		$tabs = '';
		if ($depth) $tabs = str_repeat("\t", $depth);
		$out = $tabs;
		
		$childs = count($xmlNode['children']);

		// open tag
		$out .= fuXml::openTag($xmlNode['name'], $xmlNode['attributes'], 'oneliner' == $xmlNode['type'], $childs);
		
		// content
		if (('oneliner' != $xmlNode['type']) && $xmlNode['content'])
		{
			$out .= $xmlNode['content'];
			if ($childs) { $out .= "\n"; }
		}

		// childs
		if ($childs)
		{
			for ($i = 0; isset($xmlNode['children'][$i]); $i++)
			{
				$out .= fuXml::writeTag($xmlNode['children'][$i], $depth+1);
			}
		}

		// close
		if ('oneliner' != $xmlNode['type'])
		{
			if ($childs) $out .= "$tabs";
			$out .= '</' . $xmlNode['name'] . ">\n";

		}
		
		return $out;

	}

	/**
	* return string with opening tag
	* @return string
	*/
	function openTag($name, $params = false, $oneliner = false, $newline = true)
	{
		$out = "<$name";
		if ($params)
		{
			foreach($params as $key=>$val)
			{
				$out .= " $key=\"$val\"";
			}
		}
		if ($oneliner) $out .= '/';
		$out .= '>';
		if ($newline || $oneliner) $out .= "\n";

		return $out;
	}
}

cvs_id('$Id: fuxml.class.php,v 1.2 2003/04/06 23:02:27 pukomuko Exp $');

?>