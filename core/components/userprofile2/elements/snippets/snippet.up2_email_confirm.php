<?php
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
//
$isAuthenticated = $modx->user->isAuthenticated($modx->context->key);
$hash = !empty($_REQUEST['hash']) ? $_REQUEST['hash'] : '';
$user_id = 0;
if ($isAuthenticated && !empty($hash)) {$user_id = $modx->user->id;}
else {$modx->sendErrorPage();}
//
$register = $modx->getService('registry', 'registry.modRegistry')->getRegister('user', 'registry.modDbRegister');
$register->connect();
$register->subscribe('/email/change/' . md5($modx->user->Profile->get('email')));
$msgs = $register->read(array('poll_limit' => 1));
if (!empty($msgs[0])) {
	$msgs = reset($msgs);
	if (@$hash === @$msgs['hash'] && !empty($msgs['email'])) {
		$modx->user->getOne('Profile')->set('email', $msgs['email']);
		$modx->user->save();
	}
}
$redirectConfirm = !empty($redirectConfirm)
	? $this->modx->makeUrl($redirectConfirm, '', array(), 'full')
	: $msgs['res'];
if(!empty($redirectConfirm)) {
	$modx->sendRedirect(@$msgs['res']);
}
return '';