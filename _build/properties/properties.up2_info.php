<?php

$properties = array();

$tmp = array(
	'tplUser' => array(
		'type' => 'textfield',
		'value' => 'tpl.up2User.Info',
	),
	'user_id' => array(
		'type' => 'numberfield',
		'value' => '',
	),

	'tplTabsOuter' => array(
		'type' => 'textfield',
		'value' => '@INLINE <div class="tabbable tabs-left" id="up2-tabs">[[+navtabs]][[+contenttabs]]</div>',
	),
	'tplNavTabsOuter' => array(
		'type' => 'textfield',
		'value' => '@INLINE <ul class="nav nav-tabs">[[+navrows]]</ul>',
	),
	'tplNavTabsRow' => array(
		'type' => 'textfield',
		'value' => '@INLINE <li class="[[+active]] [[+idx]]"><a href="#[[+tabname]]" data-toggle="tab">[[+tabtitle]]</a></li>',
	),
	'tplContentTabsOuter' => array(
		'type' => 'textfield',
		'value' => '@INLINE <div class="tab-content">[[+tabrows]]</div>',
	),
	'tplContentTabPane' => array(
		'type' => 'textfield',
		'value' => '@INLINE <div class="tab-pane [[+active]] [[+idx]]" id="[[+tabname]]">[[+fieldrows]]</div>',
	),
	'tplContentTabPaneRow' => array(
		'type' => 'textfield',
		'value' => '@INLINE <p><b>[[+name]]</b>:<br> [[+value]]</p>',
	),

	'excludeTabs' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'activeTab' => array(
		'type' => 'textfield',
		'value' => '',
	),


	'dateFormat' => array(
		'type' => 'textfield',
		'value' => 'd F Y, H:i',
	),
	'gravatarIcon' => array(
		'type' => 'textfield',
		'value' => 'mm',
	),
	'gravatarSize' => array(
		'type' => 'numberfield',
		'value' => '64',
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