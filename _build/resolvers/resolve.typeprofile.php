<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:

            $lang = $modx->getOption('manager_language') == 'en' ? 1 : 0;
            // type profile
            $profiles = array(
                '1' => array(
                    'name'    => !$lang ? 'Профиль #1' : 'Profile #1',
                    'default' => '1',
                ),
                '2' => array(
                    'name'    => !$lang ? 'Профиль #2' : 'Profile #2',
                    'default' => '0',
                ),

            );

            foreach ($profiles as $id => $properties) {
                if (!$profile = $modx->getCount('up2TypeProfile', array('id' => $id))) {
                    $profile = $modx->newObject('up2TypeProfile', array_merge(array(
                        'active' => 1,
                        'rank'   => $id - 1,
                    ), $properties));
                    $profile->set('id', $id);
                    $profile->save();
                }
            }

            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;