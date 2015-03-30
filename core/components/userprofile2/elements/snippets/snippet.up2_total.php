<?php

/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
//
$userprofile2->initialize($modx->context->key, $scriptProperties);
//
if(empty($processSection)) {$processSection = 'tickets,comments,favorites';}
if(empty($user_id)) {$user_id = $modx->getPlaceholder('user_id');}
if(empty($pleTickets)) {$pleTickets = 'tickets';}
if(empty($pleComments)) {$pleComments = 'comments';}
if(empty($pleFavorites)) {$pleFavorites = 'favorites';}
//
@list($processTickets, $processComments, $processFavorites) = explode(',', strtolower(trim($processSection)));
//
if(!empty($processTickets) || !empty($processComments)) {
	// Limit by specified parents
	if (!isset($depth)) {$depth = 10;}
	if (!empty($parents)) {
		$pids = array_map('trim', explode(',', $parents));
		$parents = array();
		foreach ($pids as $v) {
			$parents = array_merge($parents, $modx->getChildIds($v, $depth, array('context_key' => $modx->context->key)));
		}
	}
}
if(!empty($processTickets)) {
	// Tickets
	$where = array('createdby' => $user_id, 'deleted' => 0, 'published' => 1, 'class_key' => 'Ticket', 'privateweb' => 0);
	if (!empty($parents)) {$where['parent:IN'] = $parents;}
	$q = $modx->newQuery('Ticket', $where);
	$count[$pleTickets] = $modx->getCount('Ticket', $q);
}
if(!empty($processComments)) {
	// Comments
	$where = array('createdby' => $user_id, 'deleted' => 0);
	if (!empty($parents)) {$where['Ticket.parent:IN'] = $parents;}
	$q = $modx->newQuery('TicketComment', $where);
	$q->leftJoin('TicketThread','Thread','Thread.id = TicketComment.thread');
	$q->leftJoin('Ticket','Ticket','Ticket.id = Thread.resource');
	if (!$modx->hasPermission('ticket_view_private')) {
		$q->where('privateweb = 0');
	}
	$count[$pleComments] = $modx->getCount('TicketComment', $q);
}
if(!empty($processFavorites)) {
	// star
	$where = array('createdby' => $user_id, 'class' => 'Ticket');
	$q = $modx->newQuery('TicketStar', $where);
	$count[$pleFavorites] = $modx->getCount('TicketStar', $q);
}
//
$rows = '';
foreach($count as $k => $c) {
	if(!empty($toPlaceholders)) {$modx->setPlaceholder($placeholderPrefix.$k, $c);}
	else {
		$output[] = empty($tplCount)
			? $userprofile2->pdoTools->getChunk('', array('count' => $c, 'name' => $k))
			: $userprofile2->pdoTools->getChunk($tplCount, array('count' => $c, 'name' => $k), $userprofile2->pdoTools->config['fastMode']);
	}
}
if (empty($outputSeparator)) {$outputSeparator = "\n";}
$output = is_array($output) ? implode($outputSeparator, $output) : $output;
$output = empty($tplCounts)
	? $userprofile2->pdoTools->getChunk('', array('counts' => $output))
	: $userprofile2->pdoTools->getChunk($tplCounts, array('counts' => $output), $userprofile2->pdoTools->config['fastMode']);

return $output;