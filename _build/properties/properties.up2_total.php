<?php

$properties = array();

$tmp = array(

	'user_id' => array(
		'type' => 'numberfield',
		'value' => '',
	),
	'tplCounts' => array(
		'type' => 'textfield',
		'value' => '@INLINE [[+counts]]',
	),
	'tplCount' => array(
		'type' => 'textfield',
		'value' => '@INLINE ([[+count]])',
	),
	'parents' => array(
		'type' => 'textfield',
		'value' => ''
	),
	'depth' => array(
		'type' => 'numberfield',
		'value' => 10
	),
	'placeholderPrefix' => array(
		'type' => 'textfield'
	,'value' => 'up2.total.'
	),
	'toPlaceholders' => array(
		'type' => 'combo-boolean',
		'value' => true,
	),
	'fastMode' => array(
		'type' => 'combo-boolean',
		'value' => true,
	),

	'processSection' => array(
		'type' => 'textfield',
		'value' => 'tickets,comments,'
	),
	/*'
	'toPlaceholder' => array(
		'type' => 'textfield',
		'value' => ''
	),
	'outputSeparator' => array(
		'type' => 'textfield',
		'value' => "\n"
	),
	'totalVar' => array(
		'type' => 'textfield',
		'value' => 'up.total'
	),*/

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