<?php

$properties = array();

$tmp = array(

	'parents' => array(
		'type' => 'textfield',
		'value' => ''
	),
	'depth' => array(
		'type' => 'numberfield',
		'value' => 10
	),
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'tpl.Tickets.comment.list.row',
	),
	'sortby' => array(
		'type' => 'textfield',
		'value' => 'createdon',
	),
	'sortdir' => array(
		'type' => 'list',
		'options' => array(
			array('text' => 'ASC','value' => 'ASC'),
			array('text' => 'DESC','value' => 'DESC'),
		),
		'value' => 'DESC',
	),
	'limit' => array(
		'type' => 'numberfield',
		'value' => 10
	),
	'offset' => array(
		'type' => 'numberfield',
		'value' => 0
	),

	'showLog' => array(
		'type' => 'combo-boolean',
		'value' => false
	),
	'includeContent' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
	'includeTVs' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'where' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'tvPrefix' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'toPlaceholder' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'outputSeparator' => array(
		'type' => 'textfield',
		'value' => "\n",
	),

	'showUnpublished' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
	'showDeleted' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
	'showHidden' => array(
		'type' => 'combo-boolean',
		'value' => true,
	),
	'cacheKey' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'cacheTime' => array(
		'type' => 'numberfield',
		'value' => 1800,
	),
	'gravatarIcon' => array(
		'type' => 'textfield',
		'value' => 'mm',
	),
	'gravatarSize' => array(
		'type' => 'numberfield',
		'value' => '24',
	),

);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;