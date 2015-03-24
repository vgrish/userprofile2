<?php

$files = scandir(dirname(__FILE__));
foreach ($files as $file) {
	@include_once($file);
}


$_lang['userprofile2'] = 'userprofile2';
$_lang['userprofile2_menu_desc'] = 'A sample Extra to develop from.';
$_lang['userprofile2_intro_msg'] = 'You can select multiple items by holding Shift or Ctrl button.';
