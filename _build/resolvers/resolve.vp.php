<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

			$modelPath = $modx->getOption('virtualpage_core_path', null, $modx->getOption('core_path') . 'components/virtualpage/') . 'model/';
			$modx->addPackage('virtualpage', $modelPath);

			$lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;

			// Plugin Events
			$events = array(
				'1' => array(
					'name' => 'OnPageNotFound',
				),
				'2' => array(
					'name' => 'OnHandleRequest',
				)
			);

			foreach ($events as $id => $properties) {
				if (!$event = $modx->getObject('vpEvent', array('name' => $properties['name']))) {
					$event = $modx->newObject('vpEvent', array_merge(array(
						//'name' => $properties['name'],
					), $properties));
				}
				$event->set('active', 1);
				$event->save();
			}
			// Handler
			$handlers = array(
				'1' => array(
					'name' => !$lang ? 'комментарии' : 'comment',
				),
				'2' => array(
					'name' => !$lang ? 'заметки' : 'tickets',
				),
			);

			foreach ($handlers as $id => $properties) {
				if (!$handler = $modx->getObject('vpHandler', array('name' => $properties['name']))) {
					$handler = $modx->newObject('vpHandler', array_merge(array(
						//'name' => $properties['name'],
					), $properties));
				}
				$handler->set('active', 1);
				$handler->save();
			}

			// Routes
			$routes = array(
				'1' => array(
					'description' => !$lang ? 'комментарии' : 'comments',
					'metod' => 'GET,POST',
					'route' => '/users/{comment_user_id:[0-9]+}/comments/',

				),
				'2' => array(
					'description' => !$lang ? 'заметки' : 'tickets',
					'metod' => 'GET,POST',
					'route' => '/users/{ticket_user_id:[0-9]+}/tickets/',

				),

			);

			foreach ($routes as $id => $properties) {
				if (!$route = $modx->getObject('vpRoute', array('route' => $properties['route']))) {
					$route = $modx->newObject('vpRoute', array_merge(array(
						//'name' => $properties['name'],
					), $properties));
					$route->set('active', 1);
					$route->save();
				}
			}

				/*// type field
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

			);*/


/*			foreach ($types as $id => $properties) {
				if (!$type = $modx->getCount('up2TypeField', array('id' => $id))) {
					$type = $modx->newObject('up2TypeField', array_merge(array(
						'active' => 1,
						'rank' => $id - 1,
					), $properties));
					$type->set('id', $id);
					$type->save();
				}
			}*/

			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;