<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_UPGRADE:
		case xPDOTransport::ACTION_INSTALL:
			$modelPath = $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/';
			$modx->addPackage('userprofile2', $modelPath);

			$manager = $modx->getManager();
			$objects = array(
				'up2TypeProfile',
				'up2Profile',
				'up2TypeField',
				'up2Fields',
				'up2TypeTab',
				'up2Tabs',

			);
			foreach ($objects as $tmp) {
				$manager->createObjectContainer($tmp);
			}

			$level = $modx->getLogLevel();
			$modx->setLogLevel(xPDO::LOG_LEVEL_FATAL);

			$manager->addField('up2Fields', 'length', array('after' => 'value'));

			$modx->setLogLevel($level);


			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;
