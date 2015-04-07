<?php

$properties = array();

$tmp = array(
	'Sections' => array(
		'type' => 'textarea',
		'value' => 'info:/users/[id]/,tickets:/users/[id]/tickets/,comments:/users/[id]/comments/,favorites:/users/[id]/favorites/,'
	),
	'user_id' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'tplSectionRow' => array(
		'type' => 'textfield',
		'value' => '@INLINE <li class="[[+section]] [[+active]]"><a href="[[+link]]">[[+title]] [[+count]]</a></li>',
	),
	'tplSectionOuter' => array(
		'type' => 'textfield',
		'value' => '@INLINE <ul class="nav nav-tabs">[[+rows]]</ul><br>',
	),
	'tplCountWrapper' => array(
		'type' => 'textfield',
		'value' => '@INLINE <sup>([[+count]])</sup>',
	),
	'plSection' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'plCountPrefix' => array(
		'type' => 'textfield',
		'value' => 'up2.total.'
	),
	'toPlaceholder' => array(
		'type' => 'combo-boolean',
		'value' => false,
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