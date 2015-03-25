<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

			$lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
			// type field
			$types = array(
				'1' => array(
					'name' => !$lang ? 'Текстовое поле' : 'Text',
					'type_in' => 'textfield',
					'type_out' => 'text',
				),
				'2' => array(
					'name' => !$lang ? 'Цифровое поле' : 'Number',
					'type_in' => 'numberfield',
					'type_out' => 'number',
				),
				'3' => array(
					'name' => !$lang ? 'Скрытое поле' : 'Hidden',
					'type_in' => 'textfield',
					'type_out' => 'hidden',
				),
				'4' => array(
					'name' => !$lang ? 'Текстовая область' : 'Textarea',
					'type_in' => 'textarea',
					'type_out' => 'textarea',
				),

			);


			foreach ($types as $id => $properties) {
				if (!$type = $modx->getCount('up2TypeField', array('id' => $id))) {
					$type = $modx->newObject('up2TypeField', array_merge(array(
						'active' => 1,
						'rank' => $id - 1,
					), $properties));
					$type->set('id', $id);
					$type->save();
				}
			}

			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;