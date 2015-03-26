<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

			$lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
			// type tab
			$tabs = array(
				'1' => array(
					'name_in' => !$lang ? 'Вкладка #1' : 'Tab #1',
					'name_out' => 'tab_1',
				),
				'2' => array(
					'name_in' => !$lang ? 'Вкладка #2' : 'Tab #2',
					'name_out' => 'tab_2',
				),
				'3' => array(
					'name_in' => !$lang ? 'Вкладка #3' : 'Tab #3',
					'name_out' => 'tab_3',
				),
			);

			foreach ($tabs as $id => $properties) {
				if (!$tab = $modx->getCount('up2TypeTab', array('id' => $id))) {
					$tab = $modx->newObject('up2TypeTab', array_merge(array(
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