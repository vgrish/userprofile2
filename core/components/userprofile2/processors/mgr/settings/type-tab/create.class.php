<?php
class up2TypeTabCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'up2TypeTab';
	public $languageTopics = array('userprofile2');
	public $permission = 'vpsetting_save';

	/** {@inheritDoc} */
	public function initialize() {
		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}
		return parent::initialize();
	}
	/** {@inheritDoc} */
	public function beforeSet() {
		if ($this->modx->getObject('up2TypeTab',array('name_out' => $this->getProperty('name_out')))) {
			$this->modx->error->addField('name_out', $this->modx->lexicon('vp_err_ae'));
		}

		return !$this->hasErrors();
	}
	/** {@inheritDoc} */
	public function beforeSave() {
		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('up2TypeTab')
		));
		return parent::beforeSave();
	}

}
return 'up2TypeTabCreateProcessor';