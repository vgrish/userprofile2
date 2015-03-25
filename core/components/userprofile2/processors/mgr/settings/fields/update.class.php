<?php
class up2FildsUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'up2Filds';
	public $languageTopics = array('userprofile2');
	public $permission = 'up2setting_save';

	/** {@inheritDoc} */
	public function initialize() {
		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}

		return parent::initialize();
	}
	/** {@inheritDoc} */
	public function beforeSet() {

		return parent::beforeSet();
	}

}
return 'up2FildsUpdateProcessor';