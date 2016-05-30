<?php

$files = scandir(dirname(__FILE__));
foreach ($files as $file) {
    @include_once($file);
}


$_lang['userprofile2'] = 'UserProfile2';
$_lang['up2_menu_desc'] = 'Профиль пользователя';

$_lang['up2_settings'] = 'Настройки';

$_lang['up2_tabs'] = 'Вкладки';
$_lang['up2_tabs_intro'] = 'Интро';

$_lang['up2_fields'] = 'Поля';
$_lang['up2_fields_intro'] = 'Интро';

$_lang['up2_setting'] = 'Настройки';
$_lang['up2_setting_intro'] = 'Интро';

$_lang['up2_lexicon'] = 'Лексиконы';
$_lang['up2_lexicon_intro'] = 'Интро';

$_lang['up2_type_field'] = 'Тип поля';
$_lang['up2_type_field_intro'] = 'Интро';

$_lang['up2_type_tab'] = 'Тип вкладки';
$_lang['up2_type_tab_intro'] = 'Интро';

$_lang['up2_type_profile'] = 'Тип профиля';
$_lang['up2_type_profile_intro'] = 'Интро';


