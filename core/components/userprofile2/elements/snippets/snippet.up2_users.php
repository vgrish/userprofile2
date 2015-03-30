<?php
/** @var array $scriptProperties */
/** @var userprofile2 $userprofile2 */
if (!$userprofile2 = $modx->getService('userprofile2', 'userprofile2', $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/userprofile2/', $scriptProperties)) {
	return 'Could not load userprofile2 class!';
}
$userprofile2->initialize($modx->context->key, $scriptProperties);
if (empty($tpl)) {$tpl = 'tpl.us2User.Row';}
//
$class = 'modUser';
$profile = 'modUserProfile';
$member = 'modUserGroupMember';
// Start building "Where" expression
$where = array();
if (empty($showInactive)) {$where[$class.'.active'] = 1;}
if (empty($showBlocked)) {$where[$profile.'.blocked'] = 0;}
// Add users profiles and groups
$innerJoin = array(
	$profile => array('alias' => $profile, 'on' => "$class.id = $profile.internalKey"),
);
// Filter by users, groups and roles
$tmp = array(
	'users' => array(
		'class' => $class,
		'name' => 'username',
		'join' => $class.'.id',
	),
	'groups' => array(
		'class' => 'modUserGroup',
		'name' => 'name',
		'join' => $member.'.user_group',
	),
	'roles' => array(
		'class' => 'modUserGroupRole',
		'name' => 'name',
		'join' => $member.'.role',
	)
);

foreach ($tmp as $k => $p) {
	if (!empty($$k)) {
		$$k = array_map('trim', explode(',', $$k));
		${$k.'_in'} = ${$k.'_out'} = $fetch_in = $fetch_out = array();
		foreach ($$k as $v) {
			if (is_numeric($v)) {
				if ($v[0] == '-') {${$k.'_out'}[] = abs($v);}
				else {${$k.'_in'}[] = abs($v);}
			}
			else {
				if ($v[0] == '-') {$fetch_out[] = $v;}
				else {$fetch_in[] = $v;}
			}
		}
		if (!empty($fetch_in) || !empty($fetch_out)) {
			$q = $modx->newQuery($p['class'], array($p['name'].':IN' => array_merge($fetch_in, $fetch_out)));
			$q->select('id,'.$p['name']);
			$tstart = microtime(true);
			if ($q->prepare() && $q->stmt->execute()) {
				$modx->queryTime += microtime(true) - $tstart;
				$modx->executedQueries++;
				while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
					if (in_array($row[$p['name']], $fetch_in)) {
						${$k.'_in'}[] = $row['id'];
					}
					else {
						${$k.'_out'}[] = $row['id'];
					}
				}
			}
		}
		if (!empty(${$k.'_in'})) {
			$where[$p['join'].':IN'] = ${$k.'_in'};
		}
		if (!empty(${$k.'_out'})) {
			$where[$p['join'].':NOT IN'] = ${$k.'_out'};
		}
	}
}
if (!empty($groups_in) || !empty($groups_out) || !empty($roles_in) || !empty($roles_out)) {
	$innerJoin[$member] = array('alias' => $member, 'on' => "$class.id = $member.member");
}
// Fields to select
$select = array(
	$class => implode(',', array_keys($modx->getFieldMeta($class)))
	,$profile => implode(',', array_keys($modx->getFieldMeta($profile)))
);
// Add up2Profile param
$where_up2 = array();
$innerJoin_up2 = array(
	array('class' => 'up2Profile', 'alias' => 'up2Profile', 'on' => '`up2Profile`.`id`=`modUser`.`id`'),
);
$select_up2 = array(
	array('userProfile' => $modx->getSelectColumns('up2Profile', 'up2Profile', '', array('id'), true) ),
);
$where = array_merge($where, $where_up2);
$innerJoin = array_merge($innerJoin, $innerJoin_up2);
$select = array_merge($select, $select_up2);
// Add custom parameters
foreach (array('where','innerJoin','select') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $modx->fromJSON($scriptProperties[$v]);
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}
$userprofile2->pdoTools->addTime('Conditions prepared');
$default = array(
	'class' => $class,
	'innerJoin' => $modx->toJSON($innerJoin),
	'where' => $modx->toJSON($where),
	'select' => $modx->toJSON($select),
	'groupby' => $class.'.id',
	'sortby' => $class.'.id',
	'sortdir' => 'ASC',
	'fastMode' => false,
	'return' => !empty($returnIds) ? 'ids' : 'data',
	'nestedChunkPrefix' => 'up2_',
	'disableConditions' => true
);
//
if (!empty($users_in) && (empty($scriptProperties['sortby']) || $scriptProperties['sortby'] == $class.'.id')) {
	$scriptProperties['sortby'] = "find_in_set(`$class`.`id`,'".implode(',', $users_in)."')";
	$scriptProperties['sortdir'] = '';
}
//
$scriptProperties['return'] = 'data';
// Merge all properties and run!
$userprofile2->pdoTools->addTime('Query parameters ready');
$userprofile2->pdoTools->setConfig(array_merge($default, $scriptProperties), false);
$rows = $userprofile2->pdoTools->run();
// Processing rows
$output = array();
if (!empty($rows) && is_array($rows)) {
	foreach ($rows as $k => $row) {
		// def
		$row = $userprofile2->getUserFields($row);
		$row['idx'] = $userprofile2->pdoTools->idx++;
		$tpl = $userprofile2->pdoTools->defineChunk($row);
		$output[] .= empty($tpl)
			? $userprofile2->pdoTools->getChunk('', $row)
			: $userprofile2->pdoTools->getChunk($tpl, $row, $userprofile2->pdoTools->config['fastMode']);
	}
	$userprofile2->pdoTools->addTime('Returning processed chunks');
}
$log = '';
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$log .= '<pre class="up2Log">' . print_r($userprofile2->pdoTools->getTime(), 1) . '</pre>';
}
// Return output
if (!empty($toSeparatePlaceholders)) {
	$modx->setPlaceholders($output, $toSeparatePlaceholders);
	$modx->setPlaceholder($log, $toSeparatePlaceholders.'log');
}
else {
	if (empty($outputSeparator)) {$outputSeparator = "\n";}
	$output = is_array($output) ? implode($outputSeparator, $output) : $output;
	$output .= $log;
	if (!empty($tplWrapper) && (!empty($wrapIfEmpty) || !empty($output))) {
		$output = $userprofile2->pdoTools->getChunk($tplWrapper, array('output' => $output), $userprofile2->pdoTools->config['fastMode']);
	}
	if (!empty($toPlaceholder)) {
		$modx->setPlaceholder($toPlaceholder, $output);
	}
	else {
		return $output;
	}
}