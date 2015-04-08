<?php

$settings = array();

$tmp = array(

	'active' => array(
		'xtype' => 'combo-boolean',
		'value' => true,
		'area' => 'userprofile2_main',
	),

	'front_css' => array(
		'type' => 'textfield',
		'value' => '[[+assetsUrl]]css/web/default.css',
		'area' => 'userprofile2_script',
	),
	'front_js' => array(
		'type' => 'textfield',
		'value' => '[[+assetsUrl]]js/web/default.js',
		'area' => 'userprofile2_script',
	),


	'avatar_params' => array(
		'type' => 'textfield',
		'value' => '{"w":274,"h":274,"zc":1,"q":90,"bg":"ffffff","f":"jpg"}',
		'area' => 'userprofile2_avatar',
	),
	'avatar_path' => array(
		'type' => 'textfield',
		'value' => 'images/users/',
		'area' => 'userprofile2_avatar',
	),


	// добавить запретить поле
	// поля разрешенные к изменению
	'fields_allowed' => array(
		'type' => 'textfield',
		'value' => '',
		'area' => 'userprofile2_editor',
	),
	// поля не разрешенные к изменению
	'fields_not_allowed' => array(
		'type' => 'textfield',
		'value' => '',
		'area' => 'userprofile2_editor',
	),


	//временные
/*
					'assets_path' => array(
						'xtype' => 'textfield',
						'value' => '{base_path}userprofile2/assets/components/userprofile2/',
						'area' => 'userprofile2_temp',
					),
					'assets_url' => array(
						'xtype' => 'textfield',
						'value' => '/userprofile2/assets/components/userprofile2/',
						'area' => 'userprofile2_temp',
					),
					'core_path' => array(
						'xtype' => 'textfield',
						'value' => '{base_path}userprofile2/core/components/userprofile2/',
						'area' => 'userprofile2_temp',
					),
*/

	//временные

/*
	'some_setting' => array(
		'xtype' => 'combo-boolean',
		'value' => true,
		'area' => 'userprofile2_main',
	),
	*/
);

foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => 'userprofile2_' . $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
