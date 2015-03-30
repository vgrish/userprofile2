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
		$realFields = array('lastname','firstname','secondname');

		/*$this->modx->log(1, print_r('====================' ,1 ));
		$this->modx->log(1, print_r($this->getProperties() ,1 ));*/


		$data = $this->getProperty('data');
		if(empty($data)) {
			return $this->success();
		}
		$data = $this->modx->fromJSON($data);
		$type = $data['type'];
		if(empty($type)) {
			echo $this->modx->userprofile2->error('up2_type_profile_err');
			exit;
		}
		unset($data['type']);

		$requiredfields = $this->modx->userprofile2->getRequiredFields($type);
		foreach($data as $tab) {
			foreach($tab as $fieldName => $value) {
				if(in_array($fieldName, array_values($requiredfields)) && empty($value)) {
					$this->modx->error->addField($fieldName, $this->modx->lexicon('vp_err_ae'));
				}
				if(in_array($fieldName, array_values($realFields)) && !empty($value)) {
					$this->object->set($fieldName, $value);
				}
			}
		}
		if($this->hasErrors()) {
			//$this->failure();
			echo $this->modx->userprofile2->error('up2_required_err');
			exit;
		}


		$this->modx->log(1, print_r('=====WORK===============' ,1 ));
		$this->modx->log(1, print_r($data ,1 ));

		$data = $this->modx->toJSON($data);
		$this->setProperty('extend', $data);
		$this->setProperty('type', $type);

		return parent::beforeSet();
	}
	/** {@inheritDoc} */
	public function afterSave() {

		return parent::afterSave();
	}
}
return 'up2ProfileUpdateProcessor';