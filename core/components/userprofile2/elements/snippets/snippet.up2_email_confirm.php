<?php
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
//
$isAuthenticated = $modx->user->isAuthenticated($modx->context->key);
$user_id = 0;
if ($isAuthenticated) {$user_id = $modx->user->id;}
else {$modx->sendErrorPage();}
//
//$row = $userprofile2->getUserFields($user_id);
