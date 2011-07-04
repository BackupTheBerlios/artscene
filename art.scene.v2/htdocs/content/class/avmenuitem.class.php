<? 
// 2001.09.11 
  

//!! ***module 
//! ***description 
  
/* 
CREATE TABLE menuitem (
   id int(11) unsigned NOT NULL auto_increment,
   name varchar(255) NOT NULL,
   file varchar(200) NOT NULL,
   type tinyint(4) DEFAULT '0' NOT NULL,
   link varchar(255) NOT NULL,
   html text NOT NULL,
   block_id varchar(200) NOT NULL,
   include varchar(255) NOT NULL,
   column_id varchar(255) NOT NULL,

   visible tinyint(4) DEFAULT '0' NOT NULL,
   sort_number int(11) unsigned NOT NULL,


   pid int(11) unsigned NOT NULL,

   PRIMARY KEY (id)
);
*/ 

include_once($RELPATH . $COREPATH . 'avtable.class.php'); 
include_once($RELPATH . 'control/class/avcid.class.php'); 
include_once($RELPATH . 'control/class/avctext.class.php'); 
include_once($RELPATH . 'control/class/avclinktext.class.php'); 
include_once($RELPATH . 'control/class/avcimage.class.php'); 
include_once($RELPATH . 'control/class/avcselect.class.php'); 
include_once($RELPATH . 'control/class/avctextarea_html.class.php'); 
include_once($RELPATH . 'control/class/avctextarea_bbcode.class.php'); 
include_once($RELPATH . 'control/class/avctextarea.class.php'); 
include_once($RELPATH . 'control/class/avcdbselect.class.php'); 
include_once($RELPATH . 'control/class/avcactions.class.php'); 



class avmenuitem extends avTable 
{ 

    function avmenuitem() 
    { 
        $this->constructor(); 
    } 

    function constructor() 
    { 
        global $g_lang, $g_ini; 
        avTable::constructor(); 

        $this->name = 'menuitem';
        $this->parent = 'avmenuitem'; 
        $this->pid = 'pid'; 

        $this->description = $g_lang['menuitem']; 
		
		$this->default_order = 'sort_number';

         
        $this->controls[] = new avcId( &$this, 'id', 'id', '',  
                0, 1, 1, 'id', 0 ); 
         
		if (!empty($GLOBALS['pid']))
		{
	        $this->controls[] = new avcText( &$this, 'name', $g_lang['menuitem_name'], '',  
		            0, 1, 1, $g_lang['menuitem_name'], 1 , 40); 
		}
		else
		{
	        $this->controls[] = new avcLinkText( &$this, 'name', $g_lang['menuitem_name'], '',  
		            0, 1, 1, $g_lang['menuitem_name'], 1 , 40, 'avmenuitem'); 
		}

		$this->controls[] = new avcText( &$this, 'iname', $g_lang['menuitem_iname'], '',  
	            0, 1, 1, $g_lang['menuitem_iname'], 1 , 40); 

	    $this->controls[] = new avcSelect( &$this, 'page', $g_lang['menuitem_page'], '',  
	            0, 1, 1, $g_lang['menuitem_page'], 1 , $this->list_pages()); 
			 
        $this->controls[] = new avcImage( &$this, 'file', $g_lang['menuitem_image'], '',  
                0, 1, 0, 'file', 1 , $g_ini->read_var('avnews', 'image_dir'), $g_ini->read_var('avnews', 'image_url'), 110, 210); 
         
        $this->controls[] = new avcSelect( &$this, 'type', $g_lang['menuitem_type'], '2',  
                0, 1, 1, $g_lang['menuitem_type'], 1, array('1'=>'nuoroda', '2'=>'html', '3'=>'blokas', '4'=>'failas', '5'=>'komponentas') ); 
         
        $this->controls[] = new avcText( &$this, 'link', $g_lang['menuitem_link'], '',  
                0, 1, 0, $g_lang['menuitem_link'], 1 , 40); 
         
        $this->controls[] = new avcTextArea( &$this, 'html', $g_lang['menuitem_html'], '',  
                0, 1, 0, $g_lang['menuitem_html'], 1 , 60, 20); 
         
        $this->controls[] = new avcDbSelect( &$this, 'block_id', $g_lang['menuitem_block'], '',  
                0, 1, 0, $g_lang['menuitem_block'], 1 , 'avblock', 'name', 'title', '', '0'); 
         
        $this->controls[] = new avcText( &$this, 'include', $g_lang['menuitem_include'], '',  
                0, 1, 0, $g_lang['menuitem_include'], 1 , 40); 
         
        $this->controls[] = new avcText( &$this, 'column_id', $g_lang['menuitem_component'], '',  
                0, 1, 0, $g_lang['menuitem_component'], 1 , 40); 
         
        $this->controls[] = new avcDbSelect( &$this, 'pid', $g_lang['menuitem_parent'], '',  
                0, 1, 1, $g_lang['menuitem_parent'], 1 , 'menuitem', 'id', 'name', '', '0'); 

        $this->controls[] = new avcText( &$this, 'sort_number', $g_lang['menuitem_sort'], '1',  
                0, 1, 1, $g_lang['menuitem_sort'], 1 , 5); 
		
		$this->controls[] = new avcSelect( &$this, 'visible', $g_lang['menuitem_visible'], 1, 0, 1, 1, 
		$g_lang['menuitem_visible'], 1, array('0'=>'ne', '1'=>'taip'));

         
        $this->controls[] = new avcActions( &$this, '', '', '',  
                0, 0, 1, $g_lang['action'], 0 ); 
         
         
    }


	function show_action_list()
	{
		$out = avTable::show_action_list();
		return $out . '<input type="radio" name="action" value="change_visible"> '. $GLOBALS['g_lang']['action_make_selected_records'] . ' <select name="visibility"><option value="1">'. $GLOBALS['g_lang']['action_visible'] .'</option><option value="0" selected>'. $GLOBALS['g_lang']['action_invisible'] .'</option></select><br>';
	}

	function action_change_visible()
	{
		global $id, $g_db, $visibility;

		check_permission('avmenuitem_edit');

		$g_db->query("UPDATE {$this->name} SET visible = $visibility WHERE id = " . implode(" OR id = ",$id));
	}


	function conditions()
	{
		if (empty($GLOBALS['pid'])) { return 'pid=0'; }
	}

	/*!
		list of available pages in ini
	*/
	function list_pages()
	{
		global $g_ini;
		$groups = $g_ini->read_groups();
		$out = array();
		for ($g = 0; isset($groups[$g]); $g++)
		{
			if ($g_ini->var_exists($groups[$g], 'template') && $g_ini->var_exists($groups[$g], 'columns'))
			{
				$out[$groups[$g]] = $groups[$g];
			}
		}
		return $out;
	}
}
?>