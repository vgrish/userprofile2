<?php
//
if (!empty($_REQUEST['action'])) {
	@session_cache_limiter('nocache');
	define('MODX_REQP', false);
}
// Load MODX config
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
	require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
	require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';
//
$isAuthenticated = $modx->user->isAuthenticated($modx->context->key);
if($isAuthenticated && $user_id = $modx->user->id) {

	$modx->log(1, print_r('======' ,1));

	$modx->log(1, print_r($user_id ,1));
}
else {
	@session_write_close();
	die('Access denied');
}

/*if ($modx->user->hasSessionContext($modx->context->get('key'))) {
	$_SERVER['HTTP_MODAUTH'] = $_SESSION["modx." . $modx->context->get('key') . ".user.token"];
} else {
	$_SESSION["modx." . $modx->context->get('key') . ".user.token"] = 0;
	$_SERVER['HTTP_MODAUTH'] = 0;
}*/

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