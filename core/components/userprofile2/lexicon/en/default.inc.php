<?php

$files = scandir(dirname(__FILE__));
foreach ($files as $file) {
	@include_once($file);
}


$_lang['userprofile2'] = 'userprofile2';
