<?php

$properties = array();

$tmp = array(
	'tplUser' => array(
		'type' => 'textfield',
		'value' => 'tpl.up2User.Edit',
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
		'value' => '@INLINE <ul class="nav nav-tabs col-sm-3">[[+navrows]]</ul>',
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
	'tplContentTabPaneInputRow' => array(
		'type' => 'textfield',
		'value' => '@INLINE <div class="form-group col-sm-12 [[+class]]"><label for="[[+nameout]]">[[+name]][[+required]]</label><input type="[[+type_out]]" name="[[+nameout]]" class="form-control" value="[[+value]]" [[+disabled]]><p class="help-block message">[[+error_[[+nameout]]]]</p></div>',
	),
	'tplContentTabPaneTextareaRow' => array(
		'type' => 'textfield',
		'value' => '@INLINE <div class="form-group col-sm-12 [[+class]]"><label for="[[+nameout]]">[[+name]][[+required]]</label><textarea name="[[+nameout]]" class="form-control" [[+disabled]]>[[+value]]</textarea><p class="help-block message">[[+error_[[+nameout]]]]</p></div>',
	),
	'excludeTabs' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'activeTab' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'required' => array(
		'type' => 'textfield',
		'value' => '<sup class="red">*</sup>',
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
	'tplChangeEmail' => array(
		'type' => 'textfield',
		'value' => 'tpl.up2User.Edit.change.email',
	),
	'resAfterChange' => array(
		'type' => 'textfield',
		'value' => '/users/settings/',
	),

	'js' => array(
		'type' => 'textfield',
		'value' => '[[+assetsUrl]]js/web/profile.default.js',
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