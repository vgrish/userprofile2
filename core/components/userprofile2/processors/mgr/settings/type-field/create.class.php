<?php

class up2TypeFieldCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'up2TypeField';
    public $languageTopics = array('userprofile2');
    public $permission = 'vpsetting_save';

    /** {@inheritDoc} */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }

    /** {@inheritDoc} */
    public function beforeSet()
    {
        if ($this->modx->getObject('up2TypeField', array('name' => $this->getProperty('name')))) {
            $this->modx->error->addField('name', $this->modx->lexicon('vp_err_ae'));
        }

        return !$this->hasErrors();
    }

    /** {@inheritDoc} */
    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount('up2TypeField')
        ));

        return parent::beforeSave();
    }

}

return 'up2TypeFieldCreateProcessor';