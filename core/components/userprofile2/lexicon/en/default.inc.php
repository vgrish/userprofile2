<?php

$files = scandir(dirname(__FILE__));
foreach ($files as $file) {
    @include_once($file);
}


$_lang['userprofile2'] = 'UserProfile2';
$_lang['up2_menu_desc'] = 'Managing User Profiles';

$_lang['up2_settings'] = 'Settings';

$_lang['up2_tabs'] = 'Profile Tabs';
$_lang['up2_tabs_intro'] = 'Tabs Intro';

$_lang['up2_fields'] = 'Fields';
$_lang['up2_fields_intro'] = 'Fields Intro';

$_lang['up2_setting'] = 'Settings';
$_lang['up2_setting_intro'] = 'Settings Intro';

$_lang['up2_lexicon'] = 'Lexicons';
$_lang['up2_lexicon_intro'] = 'Lexicons Intro';

$_lang['up2_type_field'] = 'Field Types';
$_lang['up2_type_field_intro'] = 'Intro';

$_lang['up2_type_tab'] = 'Tab Types';
$_lang['up2_type_tab_intro'] = 'Tab Types Intro';

$_lang['up2_type_profile'] = 'Profile Types';
$_lang['up2_type_profile_intro'] = 'Profile Types Intro';
