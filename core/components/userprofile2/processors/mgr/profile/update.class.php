<?php
class up2ProfileUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'up2Profile';
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

		$this->modx->log(1, print_r('====================' ,1 ));
		$this->modx->log(1, print_r($this->getProperties() ,1 ));

		$data = $this->getProperty('data');
		if(empty($data)) {
			return $this->success();
		}
		$data = $this->modx->fromJSON($data);
		if(empty($data)) {
			return $this->success();
		}

		$this->modx->log(1, print_r('=====WORK===============' ,1 ));
		$this->modx->log(1, print_r($data ,1 ));

		return !$this->hasErrors();
	}
	/** {@inheritDoc} */
	public function afterSave() {

		return parent::afterSave();
	}
}
return 'up2ProfileUpdateProcessor';