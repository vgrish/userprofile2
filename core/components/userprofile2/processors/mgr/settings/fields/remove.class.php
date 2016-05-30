<?php

class up2FieldsRemoveProcessor extends modObjectRemoveProcessor
{
    public $classKey = 'up2Fields';
    public $languageTopics = array('userprofile2');
    public $permission = 'up2setting_save';

    /** {@inheritDoc} */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }

    public function afterRemove()
    {

        return parent::afterRemove();
    }

}

return 'up2FieldsRemoveProcessor';