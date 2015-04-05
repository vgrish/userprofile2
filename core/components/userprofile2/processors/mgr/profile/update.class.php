<?php
class up2ProfileUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'up2Profile';
	public $languageTopics = array('userprofile2');
	public $permission = 'up2setting_save';
	/** {@inheritDoc} */
	public function initialize() {

		$this->modx->log(1, print_r($this->getProperties() ,1));

		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}
		return parent::initialize();
	}
	/** {@inheritDoc} */
	public function beforeSet() {
		$realFields = array('lastname','firstname','secondname');
		$userFields = array('fullname','email','phone','mobilephone','blocked','blockeduntil',
			'blockedafter','logincount','lastlogin','thislogin','dob','gender','address',
			'country','city','state','zip','fax','photo','comment','website','extended'
		);

		$data = $this->getProperty('data');
		if(empty($data)) {
			return $this->success();
		}
		$data = $this->modx->fromJSON($data);


		$this->modx->log(1, print_r($data ,1 ));


		$type = $data['type'];
		$photo = $data['photo'];
		if(empty($type)) {
			echo $this->modx->userprofile2->error('up2_type_profile_err');
			exit;
		}
		unset(
			$data['type'],
			$data['photo']
		);
		$requiredfields = $this->modx->userprofile2->getRequiredFields($type);

		$this->modx->log(1, print_r('req' ,1 ));
		$this->modx->log(1, print_r($requiredfields ,1 ));

/*		foreach($data as $tab) {
			foreach($tab as $fieldName => $value) {
				if(in_array($fieldName, array_values($requiredfields)) && empty($value)) {
					$this->modx->error->addField($fieldName, $this->modx->lexicon('vp_err_ae'));
				}
				if(in_array($fieldName, array_values($realFields)) && !empty($value)) {
					$this->object->set($fieldName, $value);
				}
			}
		}*/

		if($this->hasErrors()) {
			//$this->failure();
			echo $this->modx->userprofile2->error('up2_required_err');
			exit;
		}
		$data = $this->modx->toJSON($data);
		$this->setProperty('extend', $data);
		$this->setProperty('type', $type);
		$this->setPhoto($photo);

		return parent::beforeSet();
	}
	/** {@inheritDoc} */
	public function setPhoto($photo) {
		if(strpos($photo, '://') == true) {return false;}
		$path = trim($this->modx->userprofile2->config['avatarPath']);
		if(strpos($photo, $path) == true) {return false;}
		$params = $this->modx->fromJSON(trim($this->modx->userprofile2->config['avatarParams']));
		$file = strtolower(md5($this->getProperty('data').time()). '.' . $params['f']);
		$currentPhoto = $this->object->UserProfile->get('photo');

		$this->modx->log(1, print_r($path ,1));
		$this->modx->log(1, print_r($params ,1));
		$this->modx->log(1, print_r($file ,1));
		$this->modx->log(1, print_r($_FILES ,1));

		$url = MODX_ASSETS_URL . $path . $file;
		$dst = MODX_ASSETS_PATH . $path . $file;
		// Check image dir
		$tmp = explode('/', str_replace(MODX_BASE_PATH, '', MODX_ASSETS_PATH . $path));
		$dir = rtrim(MODX_BASE_PATH, '/');
		foreach ($tmp as $v) {
			if (empty($v)) {continue;}
			$dir .= '/' . $v;
			if (!file_exists($dir) || !is_dir($dir)) {
				@mkdir($dir);
			}
		}
		if(!file_exists(MODX_ASSETS_PATH . $path) || !is_dir(MODX_ASSETS_PATH . $path)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[UP2] Could not create images dir "'.MODX_ASSETS_PATH . $path.'"');
			return false;
		}
		// Remove image
		if(empty($photo) && $currentPhoto) {
			if($this->removeCurrentPhoto($currentPhoto, $path)) {
				$this->object->UserProfile->set('photo', '');
				return true;
			}
		}
		// Upload a new from mgr
		elseif(!empty($photo) && empty($_FILES['photo'])) {
			$cur = MODX_BASE_PATH . $photo ;
			if(!empty($cur) && file_exists($cur)) {
				copy($cur, $dst);
			}
		}
		// Upload a new one
		elseif(!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
			move_uploaded_file($_FILES['photo']['tmp_name'], $dst);
		}
		if(!empty($dst)) {
			$phpThumb = $this->modx->getService('modphpthumb','modPhpThumb', MODX_CORE_PATH . 'model/phpthumb/', array());
			$phpThumb->setSourceFilename($dst);
			foreach ($params as $k => $v) {
				$phpThumb->setParameter($k, $v);
			}
			if ($phpThumb->GenerateThumbnail()) {
				if ($phpThumb->renderToFile($dst)) {
					if (!empty($cur) && file_exists($cur) && !empty($_FILES['photo'])) {@unlink($cur);}
					$this->object->UserProfile->set('photo', $url);
					$this->removeCurrentPhoto($currentPhoto, $path);
				}
				else {
					$this->modx->log(1, '[UP2] Could not save rendered image to "'.$dst.'"');
				}
			}
			else {
				$this->modx->log(1, '[UP2] ' . print_r($phpThumb->debugmessages, true));
			}
		}

		return true;
	}
	/** {@inheritDoc} */
	public function removeCurrentPhoto($currentPhoto, $path) {
		$tmp = explode('/', $currentPhoto);
		if(!empty($tmp[1])) {
			$cur = MODX_ASSETS_PATH . $path . end($tmp);
			if(!empty($cur) && file_exists($cur)) {
				@unlink($cur);
			}
			return true;
		}
		return false;
	}
	/** {@inheritDoc} */
	public function afterSave() {

		return parent::afterSave();
	}

}
return 'up2ProfileUpdateProcessor';