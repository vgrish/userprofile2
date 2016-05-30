<?php

class up2Profile extends xPDOObject
{

    public static function load(xPDO & $xpdo, $className, $criteria, $cacheFlag = true)
    {

        $instance = parent::load($xpdo, 'up2Profile', $criteria, $cacheFlag);

        if (!is_object($instance) || !($instance instanceof $className)) {
            if (is_numeric($criteria) || (is_array($criteria) && !empty($criteria['id']))) {
                $id = is_numeric($criteria) ? $criteria : $criteria['id'];
                if ($xpdo->getCount('modUser', array('id' => $id))) {
                    $instance = $xpdo->newObject('up2Profile');
                    $instance->set('id', $id);
                    $instance->save();
                }
            }
        }

        return $instance;
    }

    /** {@inheritdoc} */
    public function save($cacheFlag = null)
    {
        if ($this->isNew()) {
            $ip = $this->xpdo->request->getClientIp();
            $this->set('registration', time());
            $this->set('lastactivity', time());
            $this->set('type', $this->xpdo->userprofile2->getProfileTypeDefault());
            $this->set('ip', $ip['ip']);
        }

        return parent:: save($cacheFlag);
    }

}