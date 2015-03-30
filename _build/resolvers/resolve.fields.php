<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

			$lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
			// fields
			$fields = array(
				'1' => array(
					'name_in' => !$lang ? 'Фамилия' : 'Lastname',
					'name_out' => 'lastname',
					'tab' => '1',
					'type' => '1',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),
				'2' => array(
					'name_in' => !$lang ? 'Имя' : 'firstname',
					'name_out' => 'firstname',
					'tab' => '1',
					'type' => '1',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),
				'3' => array(
					'name_in' => !$lang ? 'Отчество' : 'secondname',
					'name_out' => 'secondname',
					'tab' => '1',
					'type' => '1',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),


				'4' => array(
					'name_in' => !$lang ? 'поле #4' : 'field #4',
					'name_out' => 'field_4',
					'tab' => '2',
					'type' => '4',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),
				'5' => array(
					'name_in' => !$lang ? 'поле #5' : 'field #5',
					'name_out' => 'field_5',
					'tab' => '2',
					'type' => '2',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),
				'6' => array(
					'name_in' => !$lang ? 'поле #6' : 'field #6',
					'name_out' => 'field_6',
					'tab' => '2',
					'type' => '2',
					'css' => 'required',
					'required' => '1',
					'editable' => '1',
				),
				'7' => array(
					'name_in' => !$lang ? 'поле #7' : 'field #7',
					'name_out' => 'field_7',
					'tab' => '2',
					'type' => '3',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),


				'8' => array(
					'name_in' => !$lang ? 'поле #8' : 'field #8',
					'name_out' => 'field_8',
					'tab' => '3',
					'type' => '2',
					'css' => '',
					'required' => '',
					'editable' => '1',
				),
				'9' => array(
					'name_in' => !$lang ? 'поле #9' : 'field #9',
					'name_out' => 'field_9',
					'tab' => '3',
					'type' => '2',
					'css' => '',
					'required' => '1',
					'editable' => '1',
				),

			);



			foreach ($fields as $id => $properties) {
				if (!$field = $modx->getCount('up2Fields', array('id' => $id))) {
					$field = $modx->newObject('up2Fields', array_merge(array(
						'active' => 1,
						'rank' => $id - 1,
					), $properties));
					$field->set('id', $id);
					$field->save();
				}
			}

			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;