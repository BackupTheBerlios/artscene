<? 
/*
	date control
	
	Created: js, 2001.08.22
	___________________________________________________________
	This file is part of flexiUpdate, content control framework
	Copyright (c) 2001 UAB "Alternatyvus valdymas"
	http://www.avc.lt <info@avc.lt>
*/



include_once($RELPATH . 'core/avcontrol.class.php');


//!! controls
//! input type date


/*!
	input type date
*/
class avcBrowser_type extends avControl
{
	/*!
		constructor	
	*/
	function avcBrowser_type(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		$this->constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
	}
	
	function constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order)
	{
		avControl::constructor(&$table, $name, $description, $default, $required, $quered, $list, $header, $order);
		$this->visible = true;
	}

	/*!
		show form control
		overwrites 'temp' handle in template
	*/
	function show_edit()
	{
		return '';
	}
	
	function show_list() {
		
		$ua = $this->table->fields;
		$ua = $ua["browser"];
		
		$os_info = $this->which_os($ua);
		$browser_info = $this->which_browser($ua);
		
		
		//return $os_info[0]."-".$browser_info[0];
		$os_img = "<img src='im/stats/".$os_info[1].".gif' border=0>";
		$browser_img = "<img src='im/stats/".$browser_info[1].".gif' border=0>";
		
		return $os_info[0]." ".$os_img."-".$browser_img." ".$browser_info[0];	
	}
	
	function which_os($ua)
    {
	if (eregi("Mac", $ua))
	{
		$os = "MacOS";
		$osimg = "mac";
	}
	else if (eregi("windows nt", $ua))
	{
		$os = "Windows NT";
		$osimg = "windows";
	}
	
	else if (eregi("winnt", $ua))
	{
		$os = "Windows NT";
		$osimg = "windows";
	}
	else if (eregi("windows 98", $ua))
	{
		$os = "Windows 98";
		$osimg = "windows";
	}
	else if (eregi("win98", $ua))
	{
		$os = "Windows 98";
		$osimg = "windows";
	}
	else if (eregi("windows 95", $ua))
	{
		$os = "Windows 95";
		$osimg = "windows";
	}
	else if (eregi("win95", $ua))
	{
		$os = "Windows 95";
		$osimg = "windows";
	}
	else if (eregi("Linux ([0-9.]+)", $ua, $regs))
	{
		$os = "Linux ".$regs[1];
		$osimg = "linux";
	}
	else if (eregi("Linux", $ua, $regs))
	{
		$os = "Linux";
		$osimg = "linux";
	}

	else if (eregi("mdk for ([0-9]\.[0-9])", $ua, $regs))
	{
		$os = "Linux MDK ".$regs[1];
		$osimg = "linux";
	}
	else if (eregi("mdk", $ua, $regs))
	{
		$os = "Linux MDK";
		$osimg = "linux";
	}
	else if (eregi("win|windows", $ua))
	{
		$os = "Windows";
		$osimg = "windows";
	}

	else if (eregi("konqueror/(([0-9]*\.[0-9]*\.[0-9]*)|([0-9]*\.[0-9]*))", $ua, $regs))
	{
		$os = "Linux ?";
		$osimg = "linux";
	}
	else
	{
		$os = "Neþinomas";
		$osimg = "question";
	}
	return(array($os,$osimg));
}

function which_browser($ua)
{
	if (eregi("msie ([0-9.]+)", $ua, $regs))
	{
		$browser = "Explorer ".$regs[1];
		$browserimg = "explorer";
	}
	else if (eregi("konqueror/([0-9.]+)", $ua, $regs))
	{
		$browser = "Konqueror ".$regs[1];
		$browserimg = "konqueror";
	}
	else if (eregi("netscape([0-9]*/[0-9.]+)", $ua, $regs))
	{
		$browser = "Netscape ".$regs[1];
		$browserimg = "navigator";
	}
	else if (eregi("^mozilla/([0-9].?.[0-9][0-9]|[0-9].?.[0-9]|[0-9])", $ua, $regs))
	{
		if( eregi(" (m[0-9]*)", $ua, $regs2)|| eregi("gecko", $ua))
		{
			$browser = "Mozilla ".$regs[1];
			$browserimg = "mozilla";
		}
		else
		{
			$browser = "Netscape ".$regs[1];
			$browserimg = "navigator";
		}
	}
	else if (eregi("mozilla .([0-9]*)", $ua, $regs))
	{
		$browser = "Mozilla ".$regs[1];
		$browserimg = "mozilla";
	}
	else if (eregi("Opera/([0-9.]+)", $ua, $regs))
	{
		$browser = "Opera ".$regs[1];
		$browserimg = "opera";
	}
	else if (eregi("Lynx/([0-9.]+)", $ua, $regs))
	{
		$browser = "Lynx ".$regs[1];
		$browserimg = "lynx";
	}
	else if (eregi("(^[a-zA-Z]+)/([0-9.]+)", $ua, $regs))
	{
		$browser = $regs[1]." ".$regs[2];
		$browserimg = "question";
	}
	else if (eregi("(^[a-zA-Z]+) ([0-9.]+)", $ua, $regs))
	{
		$browser = $regs[1]." ".$regs[2];
		$browserimg = "question";
	}
	else if (eregi("(^[a-zA-Z]+)", $ua, $regs))
	{
		$browser = $regs[1];
		$browserimg = "question";
	}
	else
	{
		$browser = "Neþinomas";
		$browserimg = "question";
	}
	return(array($browser,$browserimg));
 }

}

?>