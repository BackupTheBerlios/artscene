<? 
// klases konstruktorius
// js, 2001.09.28

$RELPATH = "../";

include_once($RELPATH . 'site.ini.php');
include_once($RELPATH . $LIBPATH . 'header.inc.php');

//check_permission('settings_edit');

$g_tpl->set_file('construcor_file', 'control/tpl/'.$g_theme_dir.'constructor.html', 1);
$g_tpl->set_var('header', 'Klasës konstruktorius');

if (empty($step)) { $step = ''; }


switch ($step) 
{
	case 'step1': // ishsirinkom lentele

			// isprintinam visus laukelius

			$list = $g_db->get_result_array("SHOW COLUMNS FROM " . $table);

			for ($index = 0; isset($list[$index]); $index++)
			{
				$list[$index]['style'] = $index % 2;
				$list[$index]['number'] = $index + 1;
				$list[$index]['select'] = get_control_select( $list[$index]['Field'], $list[$index]['Type']);
			}


			$g_tpl->set_loop('field', $list);
			$g_tpl->set_var('table_name', $table);

			$g_tpl->process('constructor', 'field_list', 2);


		break;

	case 'step2': // suzymejom laukelius
		
			// paruosti reikia sarasa su kiekvieno fieldo parametrais ir dar bendrais lenteles
			
			// susirusiuojam vardus
			for ($i = 0; isset($fields[$i]); $i++)
			{
				$sort[$GLOBALS[ $fields[$i] . '_number' ]] = $fields[$i];
			}

			ksort($sort, SORT_NUMERIC);
			$field_list = implode(', ', $sort);

			// sudedam default reiksmes
			$index = 0;
			while (list ($key, $val) = each ($sort)) 
			{
			    $list[$index]['name'] = $val;
				$list[$index]['control'] = $GLOBALS[$val . '_control'];
			    $list[$index]['style'] = $index % 2;
				$list[$index]['order'] = 'checked';
	
				switch ($list[$index]['control'])
				{
					case 'avcDbSelect':
							$list[$index]['specific'] = 's_table:&nbsp;<input type="text" name="'. $val .'_s_table" value="" size=8> c_value:&nbsp;<input type="text" name="'. $val .'_c_value" value="" size=8> c_name:&nbsp;<input type="text" name="'. $val .'_c_name" value="" size=8> s_order:&nbsp;<input type="text" name="'. $val .'_s_order" value="" size=8>';
						break;

					case 'avcFile':
							$list[$index]['specific'] = 'dir:&nbsp;<input type="text" name="'. $val .'_dir" value="" size=8> url:&nbsp;<input type="text" name="'. $val .'_url" value="" size=8>';
						break;

					case 'avcImage':
							$list[$index]['specific'] = 'dir:&nbsp;<input type="text" name="'. $val .'_dir" value="" size=8> url:&nbsp;<input type="text" name="'. $val .'_url" value="" size=8>';
						break;

					case 'avcLinkText':
							$list[$index]['specific'] = 'size:&nbsp;<input type="text" name="'. $val .'_size" value="" size=4> link:&nbsp;<input type="text" name="'. $val .'_link" value="" size=8> link_module:&nbsp;<input type="text" name="'. $val .'_link_module" value="" size=8>';
						break;

					case 'avcPassword':
							$list[$index]['specific'] = 'size:&nbsp;<input type="text" name="'. $val .'_size" value="" size=4>';
						break;

					case 'avcText':
							$list[$index]['specific'] = 'size:&nbsp;<input type="text" name="'. $val .'_size" value="" size=4>';
						break;

					case 'avcTextArea':
							$list[$index]['specific'] = 'cols:&nbsp;<input type="text" name="'. $val .'_cols" value="" size=8> rows:&nbsp;<input type="text" name="'. $val .'_rows" value="" size=8>';
						break;

					case 'avcTextArea_bbcode':
							$list[$index]['specific'] = 'cols:&nbsp;<input type="text" name="'. $val .'_cols" value="" size=8> rows:&nbsp;<input type="text" name="'. $val .'_rows" value="" size=8>';
						break;

					case 'avcTextArea_html':
							$list[$index]['specific'] = 'cols:&nbsp;<input type="text" name="'. $val .'_cols" value="" size=8> rows:&nbsp;<input type="text" name="'. $val .'_rows" value="" size=8>';
						break;

					default:
							$list[$index]['specific'] = '';
						break;
				}

				if ('avcId' == $list[$index]['control']) { $list[$index]['order'] = ''; }

				$index++;
			}

			$g_tpl->set_loop('control', $list);
			$g_tpl->set_var('table_name', $table);
			$g_tpl->set_var('field_list', $field_list);

			$g_tpl->process('constructor', 'control_list', 2);

		break;

	case 'step3': // suvedam parametrus

			// GENERUOJAM SOURCA!

			// pasidarom inkludinamu klasiu sarasa
			$control = explode(', ', $field_list);
			
			$include = array();
			while(list($key, $val) = each($control))
			{
				$include[$GLOBALS[$val.'_control']] = 1;
			}

			if (isset($avcActions)) $include['avcActions'] = 1;

			while(list($key, $val) = each($include))
			{
				$list[]['name'] = strtolower($key);
			}
			
			$g_tpl->set_loop('include', $list);
			

			$g_tpl->set_var('class_name', $class_name);
			$g_tpl->set_var('parent', $parent);
			$g_tpl->set_var('table_name', $table);
			$g_tpl->set_var('pid', $pid);
			$g_tpl->set_var('description', $description);

			
			// generuojam controlsu sarasa
			unset($list); 
			reset($control);
			$index = 0;

			while(list($key, $val) = each($control))
			{
				$list[$index]['name'] = $val;
				$list[$index]['control'] = $GLOBALS[$val.'_control'];
				$list[$index]['description'] = $GLOBALS[$val.'_descr'];
				$list[$index]['default'] = $GLOBALS[$val.'_default'];

				$list[$index]['required'] = isset($GLOBALS[$val.'_required']) ? '1' : '0';
				$list[$index]['quered'] = '1';
				$list[$index]['list'] = isset($GLOBALS[$val.'_list']) ? '1' : '0';

				$list[$index]['header'] = $GLOBALS[$val.'_header'];
				$list[$index]['order'] = isset($GLOBALS[$val.'_order']) ? '1' : '0';
				$list[$index]['specific'] = '';

				switch ($list[$index]['control'])
				{
					case 'avcDbSelect':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_s_table'], $GLOBALS[$val.'_c_value'], $GLOBALS[$val.'_c_name'], $GLOBALS[$val.'_s_order'])) . "'";
						break;

					case 'avcFile':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_dir'], $GLOBALS[$val.'_url'])) . "'";
						break;

					case 'avcImage':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_dir'], $GLOBALS[$val.'_url'])) . "'";
						break;

					case 'avcLinkText':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_size'], $GLOBALS[$val.'_link'], $GLOBALS[$val.'_link_module'])) . "'";
						break;

					case 'avcPassword':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_size'])) . "'";
						break;

					case 'avcText':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_size'])) . "'";
						break;

					case 'avcTextArea':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_cols'], $GLOBALS[$val.'_rows'])) . "'";
						break;

					case 'avcTextArea_bbcode':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_cols'], $GLOBALS[$val.'_rows'])) . "'";
						break;

					case 'avcTextArea_html':
							$list[$index]['specific'] = ", '" . implode("', '", array($GLOBALS[$val.'_cols'], $GLOBALS[$val.'_rows'])) . "'";
						break;

				}

				$index++;
			}

			if (isset($avcActions))
			{
				$list[$index]['name'] = '';
				$list[$index]['control'] = 'avcActions';
				$list[$index]['description'] = '';
				$list[$index]['default'] = '';

				$list[$index]['required'] = 0;
				$list[$index]['quered'] = 0;
				$list[$index]['list'] = 1;

				$list[$index]['header'] = 'action';
				$list[$index]['order'] = 0;
				$list[$index]['specific'] = '';
			}

			$g_tpl->set_loop('control', $list);

			$g_tpl->process('constructor', 'source', 2);

			// parengiam spausdinimui
			ob_start();
			highlight_string($g_tpl->get_var('constructor'));
			$g_tpl->set_var('source_string', ob_get_contents());
			ob_end_clean();

			$g_tpl->process('constructor', 'source_out');

		break;

	default: // rodom lenteles 
			
			// mysql specific

			$list = $g_db->get_result_array("SHOW TABLES FROM ". $g_ini->read_var('db', 'db_name'));

			for ($index = 0; isset($list[$index]); $index++)
			{
				$list[$index]['name'] = $list[$index][0];
				$list[$index]['style'] = $index % 2;
			}

			$g_tpl->set_loop('table', $list);
			$g_tpl->set_var('db_name', $g_ini->read_var('db', 'db_name'));

			$g_tpl->process('constructor', 'table_list', 2);
			
		break;
}



$g_tpl->process('form', 'constructor', 2);

echo $g_tpl->process('out', 'main');





// -- util functions
function get_control_select($name, $type)
{
	$out = '<select name="' . $name .'_control">';

	$selected = ('date' == $type) ? 'selected' : '';
	$out .= '<option name="avcDate" '. $selected .'>avcDate</option>';

	$selected = '';
	$out .= '<option name="avcDbSelect" '. $selected .'>avcDbSelect</option>';

	$selected = ('file' == $name) ? 'selected' : '';
	$out .= '<option name="avcFile" '. $selected .'>avcFile</option>';

	$selected = '';
	$out .= '<option name="avcHidden" '. $selected .'>avcHidden</option>';

	$selected = ('id' == $name) ? 'selected' : '';
	$out .= '<option name="avcId" '. $selected .'>avcId</option>';

	$selected = '';
	$out .= '<option name="avcImage" '. $selected .'>avcImage</option>';

	$selected = '';
	$out .= '<option name="avcLinkText" '. $selected .'>avcLinkText</option>';

	$selected = ('password' == $name) ? 'selected' : '';
	$out .= '<option name="avcPassword" '. $selected .'>avcPassword</option>';

	$selected = '';
	$out .= '<option name="avcSelect" '. $selected .'>avcSelect</option>';

	$selected = ('password' == $name) ? 'selected' : '';
	$out .= '<option name="avcPassword" '. $selected .'>avcPassword</option>';

	$selected = !strpos($out, 'selected') ? 'selected' : '';
	$out .= '<option name="avcText" '. $selected .'>avcText</option>';

	$selected = ('text' == $type) ? 'selected' : '';
	$out .= '<option name="avcTextArea" '. $selected .'>avcTextArea</option>';
	
	$selected = '';
	$out .= '<option name="avcTextArea_bbcode" '. $selected .'>avcTextArea_bbcode</option>';

	$selected = '';
	$out .= '<option name="avcTextArea_html" '. $selected .'>avcTextArea_html</option>';

	$selected = (strpos('blah' . $type, 'timestamp')) ? 'selected' : '';
	$out .= '<option name="avcTimeStamp" '. $selected .'>avcTimeStamp</option>';

	/*
	avcDate
	avcDbSelect
	avcFile
	avcHidden
	avcId
	avcImage
	avcLinkText
	avcPassword
	avcSelect
	avcText
	avcTextArea
	avcTextArea_bbcode
	avcTextArea_html
	avcTimeStamp
	*/
	
	$out .= '</select>';

	return $out;
}

?>