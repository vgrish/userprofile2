<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/mgr/profile/update.class.php');

class up2WebProfileUpdateProcessor extends up2ProfileUpdateProcessor
{
    public $classKey = 'up2Profile';
    public $languageTopics = array('userprofile2');
    public $permission = '';

    /** {@inheritDoc} */
    public function initialize()
    {
        $data = $this->modx->toJSON($this->getProperties());
        $this->setProperty('data', $data);
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }

}

return 'up2WebProfileUpdateProcessor';