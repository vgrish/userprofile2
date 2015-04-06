<?php

$properties = array();

$tmp = array(

	'id' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'tplSectionRow' => array(
		'type' => 'textfield',
		'value' => '@INLINE <li class="[[+section]] [[+active]]"><a href="[[+link]]">[[+title]] [[+count]]</a></li>',
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