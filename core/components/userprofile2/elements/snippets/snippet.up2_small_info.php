<?php
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
if (!empty($cacheKey) && $output = $userprofile2->getCache('smallinfo/user.'.$cacheKey)) {
	return $output;
}
//
if(empty($user_id)) {return '';}
$row = $userprofile2->getUserFields($user_id);
// output
$output = empty($tplUser)
	? $userprofile2->pdoTools->getChunk('', $row)
	: $userprofile2->pdoTools->getChunk($tplUser, $row, $userprofile2->pdoTools->config['fastMode']);
if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
	$output = $userprofile2->pdoTools->getChunk($tplWrapper, array('output' => $output), $userprofile2->pdoTools->config['fastMode']);
}
if (!empty($cacheKey)) {
	$userprofile2->setCache('smallinfo/user.'.$cacheKey, $output, $cacheTime);
}
if (!empty($toPlaceholder)) {
	$modx->setPlaceholder($toPlaceholder, $output);
} else {
	return $output;
}