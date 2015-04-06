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
			$entry = 0;
			if($template = $modx->getObject('modTemplate', array('templatename' => 'userprofile2.inner'))) {
				$entry = $template->id;
			}
			$handlers = array(
				'1' => array(
					'name' => !$lang ? 'информация' : 'information',
					'type' => 3,
					'entry' => $entry,
					'content' => '[[$up2.info.user.main?]]',
					'description' => !$lang ? 'Информация' : 'Information',
				),
				'2' => array(
					'name' => !$lang ? 'комментарии' : 'comments',
					'type' => 3,
					'entry' => $entry,
					'content' => '[[$up2.comments.user.main?]]',
					'description' => !$lang ? 'Комментарии' : 'Сomments',
				),
				'3' => array(
					'name' => !$lang ? 'заметки' : 'tickets',
					'type' => 3,
					'entry' => $entry,
					'content' => '[[$up2.tickets.user.main?]]',
					'description' => !$lang ? 'Заметки' : 'Tickets',
				),
				'4' => array(
					'name' => !$lang ? 'избранное' : 'favorites',
					'type' => 3,
					'entry' => $entry,
					'content' => '[[$up2.favorites.user.main?]]',
					'description' => !$lang ? 'Избранное' : 'Favorites',
				),
				'5' => array(
					'name' => !$lang ? 'настройки' : 'settings',
					'type' => 3,
					'entry' => $entry,
					'content' => '[[$up2.edit.user.main?]]',
					'description' => !$lang ? 'Мои настройки' : 'My settings',
				),

			);

			foreach ($handlers as $id => $properties) {
				if (!$handler = $modx->getObject('vpHandler', array('name' => $properties['name']))) {
					$handler = $modx->newObject('vpHandler', array_merge(array(
						'cache' => 1,
					), $properties));
				}
				$handler->set('active', 1);
				$handler->save();
			}

			// Routes
			$routes = array(
				'1' => array(
					'description' => !$lang ? 'информация' : 'information',
					'metod' => 'GET,POST',
					'route' => '/users/{user_id:[0-9]+}/',
					'properties' => '{"section":"info"}'
				),
				'2' => array(
					'description' => !$lang ? 'комментарии' : 'comments',
					'metod' => 'GET,POST',
					'route' => '/users/{user_id:[0-9]+}/comments/',
					'properties' => '{"section":"comments"}'

				),
				'3' => array(
					'description' => !$lang ? 'заметки' : 'tickets',
					'metod' => 'GET,POST',
					'route' => '/users/{user_id:[0-9]+}/tickets/',
					'properties' => '{"section":"tickets"}'
				),
				'4' => array(
					'description' => !$lang ? 'избранное' : 'favorites',
					'metod' => 'GET,POST',
					'route' => '/users/{user_id:[0-9]+}/favorites/',
					'properties' => '{"section":"favorites"}'
				),
				'5' => array(
					'description' => !$lang ? 'настройки' : 'settings',
					'metod' => 'GET,POST',
					'route' => '/users/settings/',
					'properties' => '{"section":"settings"}'
				),
				'6' => array(
					'description' => !$lang ? 'подтверждение email' : 'confirm email',
					'metod' => 'GET,POST',
					'route' => '/emailconfirm/',
					'properties' => '{"section":"emailconfirm"}'
				),

				//emailconfirm/

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

			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;