<?php
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
//
if(empty($id)) {return '';}
if(empty($Sections)) {return '';}
//
$Sections = array_map('trim', explode(',', $Sections));
$row = array();
foreach($Sections as $section) {
	if(empty($section)) {continue;}
	$section = str_replace('[id]', $id, $section);
	$section = explode(':', $section);
	if(count($section) !== 2) {continue;}
	$row['link'] = $section[1];
	$row['section'] = $section[0];
	$row['title'] = $modx->lexicon('up2_section_title_'.$section[0]);
	$row['active'] = ($section[0] == $plSection) ? 'active' : '';
	$row['count'] = 1;
	if(!empty($row['count'])) {
		$row['count'] = empty($tplCountWrapper)
			? $userprofile2->pdoTools->getChunk('', $row)
			: $userprofile2->pdoTools->getChunk($tplCountWrapper, $row, $userprofile2->pdoTools->config['fastMode']);
	}
	$row['rows'] .= empty($tplSectionRow)
		? $userprofile2->pdoTools->getChunk('', $row)
		: $userprofile2->pdoTools->getChunk($tplSectionRow, $row, $userprofile2->pdoTools->config['fastMode']);
}
// output
$output = empty($tplSectionOuter)
	? $userprofile2->pdoTools->getChunk('', $row)
	: $userprofile2->pdoTools->getChunk($tplSectionOuter, $row, $userprofile2->pdoTools->config['fastMode']);
if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
	$output = $userprofile2->pdoTools->getChunk($tplWrapper, array('output' => $output), $userprofile2->pdoTools->config['fastMode']);
}
if (!empty($toPlaceholder)) {
	$modx->setPlaceholder($toPlaceholder, $output);
} else {
	return $output;
}