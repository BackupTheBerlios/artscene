<?
/**
	benchmark
	
	Created: dzhibas, 2002.10.24
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	
* @package lib	
*/

/**
* FU benchmark class by Nikolajus Krauklis <nikolajus@avc.lt>
* Main idea - benchmark with checkpoints
*
* @version $Id: fubench.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $
*/
class fuBench 
{
	
	var $checkPoints = array();
	var $loopInt = 0;
	var $lastPoint = '';
	var $round = 3;
	
	var $debug = false;
	
	function getmicrotime()
	{ 
    	list($usec, $sec) = explode(" ",microtime()); 
    	return ((float)$usec + (float)$sec); 
	} 
	
	function addPoint($name = '')
	{
		if ($name == '') {
			$this->checkPoints['noName'.$this->loopInt]['start'] = $this->getmicrotime();
			$this->lastPoint = 'noName'.$this->loopInt;
			$this->loopInt++;
			return true;
		} else {
			$this->checkPoints[$name]['start'] = $this->getmicrotime();
			$this->lastPoint = $name;
			return true;
		}
	}
	
	function endPoint($name = '')
	{
		if ($name == '') 
		{
			if ($this->lastPoint != '')	
					$this->checkPoints[$this->lastPoint]['end'] = $this->getmicrotime();			
		} else {
			$this->checkPoints[$name]['end'] = $this->getmicrotime();
		}
	}
	
	function endBench()
	{
		// Pereinam per checkpointus ir paskaichiuojame skirtumus (roundinam tikslumu - 2)
		while (list($key,$value) = each($this->checkPoints)) {
			if (isset($this->checkPoints[$key]['end'])) 
				$this->checkPoints[$key]['skirtumas'] = round($this->checkPoints[$key]['end'] - $this->checkPoints[$key]['start'],$this->round);
		}
		
		// Jei ijungtas debug'as tada printina visus checkPointus
		$this->debug && print_r($this->checkPoints);
		$this->printOut();	
	}
	
	function printOut()
	{
		echo '<br><br>
		<table cellpadding="0" cellspacing="0" border="0" bgcolor=black>
		<tr>
			<td>
				<table cellpadding="3" cellspacing="1" border="0">
				<tr bgcolor="#B6D0DA">
					<td align="center"><font face=verdana size=2><b>Taðko pavadinimas</b></font></td>
					<td align="center"><font face=verdana size=2><b>laikas</b></font></td>
				</tr>
		';
		reset($this->checkPoints);
		while (list($key,$value) = each($this->checkPoints)) {
			if (isset($this->checkPoints[$key]['skirtumas'])) {
				echo "
					<tr bgcolor='white'>
						<td><font face=verdana size=2>$key</font></td>
						<td><font face=verdana size=2>{$this->checkPoints[$key]['skirtumas']} sek.</font></td>
					</tr>
				";
			} else {
				echo "
					<tr bgcolor='#F4D5CA'>
						<td><font face=verdana size=2>$key</font></td>
						<td><font face=verdana size=2>neuþbaigtas pointas</font></td>
					</tr>
				";				
			}
		}
		
		echo '
			</table>
			</td>
		</tr>
		</table>
		<br>';	
	}
	
} //end of class

cvs_id('$Id: fubench.class.php,v 1.1 2003/03/20 17:55:31 pukomuko Exp $');

?>