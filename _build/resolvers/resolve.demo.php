<?php
/**
 * @var modX        $modx
 * @var modTemplate $template
 * @var modResource $resource
 */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $modx = &$object->xpdo;
        $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;

        if ($template = $modx->getObject('modTemplate', array('templatename' => 'userprofile2.inner'))) {

            if (!$resource = $modx->getObject('modResource', array('alias' => 'users'))) {
                $resource = $modx->newObject('modResource');
            }
            $resource->fromArray(array(
                'pagetitle'    => !$lang ? 'Список пользователей' : 'Users list',
                'alias'        => 'users',
                'uri'          => 'users/',
                'uri_override' => 1,
                'published'    => 1,
                'parent'       => 0,
                'richtext'     => 0,
                'template'     => $template->id,
                'content'      => '[[$up2.list.users?]]'
            ));
            $resource->save();
            $parent_id = $resource->id;

        }

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}
return true;