<?php

$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties);
if(!($userprofile2 instanceof userprofile2)) return '';
if(!$userprofile2->active) {return '';}
if(isset($_REQUEST['up2_die']) || isset($modx->event->params['up2_die'])) {return '';}
//
$eventName = $modx->event->name;
if (method_exists($userprofile2, $eventName)) {
	$userprofile2->$eventName($scriptProperties);
}