<?php

$settings = array();

$tmp = array(

	'active' => array(
		'xtype' => 'combo-boolean',
		'value' => true,
		'area' => 'userprofile2_main',
	),

	//временные

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
