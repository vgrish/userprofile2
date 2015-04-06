<?php
class up2ProfileUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'up2Profile';
	public $languageTopics = array('userprofile2');
	public $permission = 'up2setting_save';

	public $userprofile2;
	/** {@inheritDoc} */
	public function initialize() {
		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}
		$this->userprofile2 = $this->modx->userprofile2;

		return parent::initialize();
	}
	/** {@inheritDoc} */
	public function beforeSet() {
		$data = $this->getProperty('data');
		if(empty($data)) {return $this->success();}
		$data = $this->modx->fromJSON($data);
		if(!$type = $data['type']) {
			echo $this->userprofile2->error('up2_type_profile_err');
			exit;
		}
		$data = $this->userprofile2->sanitizeData($data);
		$realFields = $this->userprofile2->_getRealFields();
		$modUserFields = $this->userprofile2->config['modUserFields'];
		$modUserProfileFields = $this->userprofile2->config['modUserProfileFields'];
		$requiredFields = $this->userprofile2->getRequiredFields($type);
		// required
		foreach($data as $f => $v) {
			if(empty($v) && array_key_exists($f, $requiredFields)) {
				$this->modx->error->addField($f, $this->modx->lexicon('vp_err_ae'));
			}
		}
		if($this->hasErrors()) {
			echo $this->userprofile2->error('up2_required_err');
			exit;
		}


		$this->modx->log(1, print_r('=====----',1 ));
		$this->modx->log(1, print_r($data ,1 ));

		// special fields
		if(isset($data['photo'])) {$photo = $data['photo'];}
		if(isset($data['email'])) {$email = $data['email'];}
		if(isset($data['password'])) {$password = $data['password'];}
		if(isset($data['fullname'])) {$fullname = $data['fullname'];}
		unset(
			$data['photo'],
			$data['email'],
			$data['password'],
			$data['fullname']
		);
		//
		foreach($data as $f => $v) {
			if(array_key_exists($f, $realFields)) {
				$this->object->set($f, $v);
				unset($data[$f]);
				continue;
			}
			if(array_key_exists($f, $modUserFields)) {
				$this->object->User->set($f, $v);
				unset($data[$f]);
				continue;
			}
			if(array_key_exists($f, $modUserProfileFields)) {
				$this->object->UserProfile->set($f, $v);
				unset($data[$f]);
				continue;
			}
		}


		$this->modx->log(1, print_r('=====----',1 ));
		$this->modx->log(1, print_r($data ,1 ));

	/*	$this->modx->log(1, print_r($realFields,1 ));
		$this->modx->log(1, print_r($modUserFields,1 ));
		$this->modx->log(1, print_r($modUserProfileFields,1 ));*/



		// special fields
/*		$photo = $data['photo'];
		$email = $data['email'];
		$password = $data['password'];
		$fullname = $data['fullname'];
		*/


		$data = $this->modx->toJSON($data);
		$this->setProperty('extend', $data);
		$this->setProperty('type', $type);
		//$this->setPhoto($photo);

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