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
$row = $userprofile2->getUserFields($user_id);
$realFields = $userprofile2->_getRealFields();
$row['type'] = !empty($type) ? $type : $row['type'];
if (!empty($_REQUEST['type']) && in_array($_REQUEST['type'], explode(',', $allowedType))) {
	$row['type'] = $_REQUEST['type'];
}
if(!empty($row['type']) && $TabsFields = $userprofile2->getTabsFields($row['type'])) {
	$idx = 1;
	foreach($TabsFields as $tabName => $tab) {
		if(empty($tab['fields'])
			|| !is_array($tab['fields'])
			|| array_key_exists($tabName, explode(',', $excludeTabs))
		) {continue;}
		if(empty($activeTab)) {$row['active'] = ($idx == 1) ? 'active' : '';}
		else {$row['active'] = ($activeTab == $tabName) ? 'active' : '';}
		$row['tabname'] = $tabName;
		$row['tabtitle'] = $tab['name_in'];
		$row['idx'] = $idx ++;
		$row['navrows'] .= empty($tplNavTabsRow)
			? $userprofile2->pdoTools->getChunk('', $row)
			: $userprofile2->pdoTools->getChunk($tplNavTabsRow, $row, $userprofile2->pdoTools->config['fastMode']);
		$row['fieldrows'] =  '';
		foreach($tab['fields'] as $fieldName => $field) {
			if(array_key_exists($fieldName, $realFields)) {$row['value'] = $row[$fieldName];}
			else {$row['value'] = $row['extend'][$fieldName];}
			$row['name'] = $field['name_in'];
			$row['nameout'] = $field['name_out'];
			$row['class'] = $field['css'];
			$row['type_out'] = $field['type_out'];
			$row['required'] = !empty($field['required']) ? $required : '';
			$row['disabled'] = empty($field['editable']) ? 'disabled' : '';
			if($row['type'] == 'textarea') {
				$row['fieldrows'] .= empty($tplContentTabPaneTextareaRow)
					? $userprofile2->pdoTools->getChunk('', $row)
					: $userprofile2->pdoTools->getChunk($tplContentTabPaneTextareaRow, $row, $userprofile2->pdoTools->config['fastMode']);
			}
			else {
				$row['fieldrows'] .= empty($tplContentTabPaneInputRow)
					? $userprofile2->pdoTools->getChunk('', $row)
					: $userprofile2->pdoTools->getChunk($tplContentTabPaneInputRow, $row, $userprofile2->pdoTools->config['fastMode']);
			}
		}
		$row['tabrows'] .= empty($tplContentTabPane)
			? $userprofile2->pdoTools->getChunk('', $row)
			: $userprofile2->pdoTools->getChunk($tplContentTabPane, $row, $userprofile2->pdoTools->config['fastMode']);
	}
	$row['contenttabs'] = empty($tplContentTabsOuter)
		? $userprofile2->pdoTools->getChunk('', $row)
		: $userprofile2->pdoTools->getChunk($tplContentTabsOuter, $row, $userprofile2->pdoTools->config['fastMode']);
	$row['navtabs'] = empty($tplNavTabsOuter)
		? $userprofile2->pdoTools->getChunk('', $row)
		: $userprofile2->pdoTools->getChunk($tplNavTabsOuter, $row, $userprofile2->pdoTools->config['fastMode']);
	$row['tabs'] = empty($tplTabsOuter)
		? $userprofile2->pdoTools->getChunk('', $row)
		: $userprofile2->pdoTools->getChunk($tplTabsOuter, $row, $userprofile2->pdoTools->config['fastMode']);
}
// reg js
$modx->regClientScript(str_replace('[[+assetsUrl]]', $userprofile2->config['assetsUrl'], $js));
// output
$output = empty($tplUser)
	? $userprofile2->pdoTools->getChunk('', $row)
	: $userprofile2->pdoTools->getChunk($tplUser, $row, $userprofile2->pdoTools->config['fastMode']);
if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
	$output = $userprofile2->pdoTools->getChunk($tplWrapper, array('output' => $output), $userprofile2->pdoTools->config['fastMode']);
}
$key = md5($modx->toJSON($userprofile2->config));
$_SESSION['up2form'][$key] = $userprofile2->config;
$output = str_ireplace('</form>', "\n<input type=\"hidden\" name=\"form_key\" value=\"{$key}\" class=\"disable-sisyphus\" />\n</form>", $output);
if (!empty($toPlaceholder)) {
	$modx->setPlaceholder($toPlaceholder, $output);
} else {
	return $output;
}