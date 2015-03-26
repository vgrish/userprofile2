<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

			$lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
			// tabs
			$tabs = array(
				'1' => array(
					'type' => '1',
					'tab' => '1',
					'editable' => '1',
				),
				'2' => array(
					'type' => '1',
					'tab' => '2',
					'editable' => '1',
				),
				'3' => array(
					'type' => '1',
					'tab' => '3',
					'editable' => '0',
				),


				'4' => array(
					'type' => '2',
					'tab' => '1',
					'editable' => '0',
				),
			);


			foreach ($tabs as $id => $properties) {
				if (!$tab = $modx->getCount('up2Tabs', array('id' => $id))) {
					$tab = $modx->newObject('up2Tabs', array_merge(array(
						'active' => 1,
						'rank' => $id - 1,
					), $properties));
					$tab->set('id', $id);
					$tab->save();
				}
			}

			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;