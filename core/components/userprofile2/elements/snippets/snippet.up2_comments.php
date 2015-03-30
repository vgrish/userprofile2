<?php
if (!empty($cacheKey) && $output = $modx->cacheManager->get('userprofile2/tickets/latest.'.$cacheKey)) {
	return $output;
}
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
$isAuthenticated = $modx->user->isAuthenticated($modx->context->key);
$active_section = (!empty($scriptProperties['active_section'])) ? $scriptProperties['active_section'] : 'comments';
$main_url = $userprofile2->config['main_url'];
// where
if (empty($showUnpublished)) {$where['Ticket.published'] = 1;}
if (empty($showHidden)) {$where['Ticket.hidemenu'] = 0;}
if (empty($showDeleted)) {$where['Ticket.deleted'] = 0;}
//
if (!isset($cacheTime)) {$cacheTime = 1800;}
if (!isset($depth)) {$depth = 10;}
if (!empty($parents) && $parents > 0) {
	$pids = array_map('trim', explode(',', $parents));
	$parents = $pids;
	if (!empty($depth) && $depth > 0) {
		foreach ($pids as $v) {
			if (!is_numeric($v)) {continue;}
			$parents = array_merge($parents, $modx->getChildIds($v, $depth));
		}
	}
	if (!empty($parents)) {
		$where['Ticket.parent:IN'] = $parents;
	}
}
//
if (!empty($user_id)) {
	$where['TicketComment.createdby'] = intval($user_id);
}
elseif ($isAuthenticated) {
	$modx->sendRedirect('/'.$main_url.'/'.$modx->user->id.'/');
}
else {
	$modx->sendErrorPage();
}
//
$class = 'TicketComment';
$innerJoin = array();
$innerJoin['Thread'] = array('class' => 'TicketThread', 'on' => '`TicketComment`.`thread` = `Thread`.`id` AND `Thread`.`deleted` = 0');
$innerJoin['Ticket'] = array('class' => 'Ticket', 'on' => '`Ticket`.`id` = `Thread`.`resource`');
$leftJoin = array(
	'Section' => array('class' => 'TicketsSection', 'on' => '`Section`.`id` = `Ticket`.`parent`'),
	'User' => array('class' => 'modUser', 'on' => '`User`.`id` = `TicketComment`.`createdby`'),
	'Profile' => array('class' => 'modUserProfile', 'on' => '`Profile`.`internalKey` = `TicketComment`.`createdby`'),
);
$select = array(
	'TicketComment' => !empty($includeContent)
		? $modx->getSelectColumns('TicketComment', 'TicketComment', '', array('raw'), true)
		: $modx->getSelectColumns('TicketComment', 'TicketComment', '', array('text','raw'), true),
	'Ticket' => !empty($includeContent)
		? $modx->getSelectColumns('Ticket', 'Ticket', 'ticket.')
		: $modx->getSelectColumns('Ticket', 'Ticket', 'ticket.', array('content'), true)
);
$groupby = '`TicketComment`.`id`';
$where['TicketComment.deleted'] = 0;
// Fields to select
$select = array_merge($select, array(
	'Section' => $modx->getSelectColumns('TicketsSection', 'Section', 'section.', array('content'), true),
	'User' => $modx->getSelectColumns('modUser', 'User', '', array('username')),
	'Profile' => $modx->getSelectColumns('modUserProfile', 'Profile', '', array('id'), true),
));
// Add custom parameters
foreach (array('where','select','leftJoin','innerJoin') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $modx->fromJSON($scriptProperties[$v]);
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}
// default
$default = array(
	'class' => $class,
	'where' => $modx->toJSON($where),
	'innerJoin' => $modx->toJSON($innerJoin),
	'leftJoin' => $modx->toJSON($leftJoin),
	'select' => $modx->toJSON($select),
	'sortby' => 'createdon',
	'sortdir' => 'DESC',
	'groupby' => $groupby,
	'return' => 'data',
	'nestedChunkPrefix' => 'tickets_',
);
// Merge all properties and run!
$scriptProperties = array_merge($default, $scriptProperties);
$userprofile2->pdoTools->setConfig($scriptProperties, false);
$rows = $userprofile2->pdoTools->run();
//
$Tickets = $modx->getService('tickets','Tickets',$modx->getOption('tickets.core_path',null,$modx->getOption('core_path').'components/tickets/').'model/tickets/',$scriptProperties);
// Processing rows
$output = array();
if (!empty($rows) && is_array($rows)) {
	foreach ($rows as $k => $row) {
		// Processing main fields
		$row['comments'] = $modx->getCount('TicketComment', array('thread' => $row['thread'], 'published' => 1));
		// Prepare row
		if (empty($row['createdby'])) {
			$row['fullname'] = $row['name'];
			$row['guest'] = 1;
		}
		$row['resource'] = $row['ticket.id'];
		$row = $Tickets->prepareComment($row);
		// Processing chunk
		$row['idx'] = $userprofile2->pdoTools->idx++;
		$tpl = $userprofile2->pdoTools->defineChunk($row);
		$output[] = !empty($tpl)
			? $userprofile2->pdoTools->getChunk($tpl, $row, $userprofile2->pdoTools->config['fastMode'])
			: $userprofile2->pdoTools->getChunk('', $row);
	}
	$userprofile2->pdoTools->addTime('Returning processed chunks');
}
if (empty($outputSeparator)) {$outputSeparator = "\n";}
$output = implode($outputSeparator, $output);
if (!empty($cacheKey)) {
	$modx->cacheManager->set('userprofile2/tickets/latest.'.$cacheKey, $output, $cacheTime);
}
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$output .= '<pre class="up2Log">' . print_r($userprofile2->pdoTools->getTime(), 1) . '</pre>';
}
if (!empty($toPlaceholder)) {
	$modx->setPlaceholder($toPlaceholder, $output);
}
else {
	return $output;
}