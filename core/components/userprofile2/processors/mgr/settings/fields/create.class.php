<?php
class up2FieldsCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'up2Fields';
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
		if ($this->modx->getObject('up2Fields',array('name_in' => $this->getProperty('name_in')))) {
			$this->modx->error->addField('name_in', $this->modx->lexicon('vp_err_ae'));
		}
		if (!$this->getProperty('tab')) {
			$this->modx->error->addField('tab', $this->modx->lexicon('vp_err_ae'));
		}

		return !$this->hasErrors();
	}
	/** {@inheritDoc} */
	public function beforeSave() {
		$q = $this->modx->newQuery($this->classKey);
		$q->where(array('tab:=' => $this->getProperty('tab')));

		$this->object->fromArray(array(
			'rank' => $this->modx->getCount('up2Fields', $q)
		));
		return parent::beforeSave();
	}

}
return 'up2FieldsCreateProcessor';