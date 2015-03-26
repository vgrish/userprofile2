<?php
class up2TypeTabRemoveProcessor extends modObjectRemoveProcessor  {
	public $classKey = 'up2TypeTab';
	public $languageTopics = array('userprofile2');
	public $permission = 'up2setting_save';

	/** {@inheritDoc} */
	public function initialize() {
		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}

		return parent::initialize();
	}

	public function afterRemove() {

		return parent::afterRemove();
	}

}
return 'up2TypeTabRemoveProcessor';