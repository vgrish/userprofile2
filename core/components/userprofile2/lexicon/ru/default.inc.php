<?php

$files = scandir(dirname(__FILE__));
foreach ($files as $file) {
	@include_once($file);
}


$_lang['userprofile2'] = 'UserProfile2';
$_lang['userprofile2_menu_desc'] = 'Пример расширения для разработки.';
$_lang['userprofile2_intro_msg'] = 'Вы можете выделять сразу несколько предметов при помощи Shift или Ctrl.';

