<?php

class up2TabsCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'up2Tabs';
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
        if (!$this->getProperty('type')) {
            $this->modx->error->addField('type', $this->modx->lexicon('vp_err_ae'));
        }
        if ($this->modx->getObject('up2Tabs', array(
            'tab'  => $this->getProperty('tab'),
            'type' => $this->getProperty('type'),
        ))
        ) {
            $this->modx->error->addField('tab', $this->modx->lexicon('vp_err_ae'));
        }


        return !$this->hasErrors();
    }

    /** {@inheritDoc} */
    public function beforeSave()
    {
        $q = $this->modx->newQuery($this->classKey);
        $q->where(array('type:=' => $this->getProperty('type')));

        $this->object->fromArray(array(
            'rank' => $this->modx->getCount('up2Tabs', $q)
        ));

        return parent::beforeSave();
    }

}

return 'up2TabsCreateProcessor';