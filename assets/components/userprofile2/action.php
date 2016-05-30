<?php
//
if (empty($_REQUEST['action'])) {
	@session_write_close();
	die('Access denied: Action is empty');
}
$_REQUEST['ctx'] = 'web';
define('MODX_API_MODE', true);
if (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/index.php')) {
	require dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/index.php'; // на время разработки
} else {
	require dirname(dirname(dirname(dirname(__FILE__)))).'/index.php'; // на постоянку
}
//
$modx->getService('error','error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;
//
$isAuthenticated = $modx->user->isAuthenticated($modx->context->key);
if($isAuthenticated && $user_id = $modx->user->id) {
	$_SERVER['HTTP_MODAUTH']= $modx->user->getUserToken($modx->context->get('key'));
}
else {
	@session_write_close();
	die('Access denied: User is not logged in the context');
}
//
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';
//
$corePath = $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/');
$userprofile2= $modx->getService('userprofile2', 'userprofile2', $corePath . 'model/userprofile2/');
$modx->lexicon->load('userprofile2:default','userprofile2:manager');
// handle request
$path = $modx->getOption('processorsPath', $userprofile2->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path . 'web/',
	'location' => '',
));
