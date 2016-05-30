<?php

class up2ProfileUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'up2Profile';
    public $languageTopics = array('userprofile2');
    public $permission = 'up2setting_save';

    public $userprofile2;
    public $config;
    public $type;
    public $ctx;
    public $message;

    /** {@inheritDoc} */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        $this->userprofile2 = $this->modx->userprofile2;
        $this->userprofile2->initialize($this->modx->context->key);
        $this->config = $this->userprofile2->config;
        // get data
        $data = $this->getProperty('data');
        if (empty($data)) {
            return $this->success();
        }
        $data = $this->modx->fromJSON($data);
        if (!$this->type = $data['type']) {
            echo $this->userprofile2->error('up2_type_profile_err');
            exit;
        }
        // get properties
        if (isset($data['form_key'])) {
            $formKey = $data['form_key'];
        }
        if (!empty($formKey) && isset($_SESSION['up2form'][$formKey])) {
            $this->config = array_merge($this->config, $_SESSION['up2form'][$formKey]);
        }
        $this->ctx = $this->config['ctx'];

        return parent::initialize();
    }

    /** {@inheritDoc} */
    public function beforeSet()
    {
        $data = $this->getProperty('data');
        $data = $this->modx->fromJSON($data);
        // special fields
        if (isset($data['photo'])) {
            $photo = $data['photo'];
            unset($data['photo']);
        }
        $removephoto = false;
        if ($data['removephoto'] == 1) {
            $removephoto = true;
            $this->message = array('msg' => 'up2_msg_avatar_is_remove', 'data' => array('removeavatar' => 1));
        }
        // change password
        if (!empty($data['specifiedpassword']) || !empty($data['confirmpassword'])) {
            $params = array(
                'id'                   => $this->object->id,
                'username'             => $this->object->User->get('username'),
                'email'                => $this->object->UserProfile->get('email'),
                'specifiedpassword'    => $data['specifiedpassword'],
                'confirmpassword'      => $data['confirmpassword'],
                'passwordnotifymethod' => 's',
                'passwordgenmethod'    => 'spec',
                'newpassword'          => '',
            );
            if (!$response = $this->modx->runProcessor('update',
                $params
                , array(
                    'processors_path' => MODX_CORE_PATH . 'model/modx/processors/security/user/',
                ))
            ) {
                return '';
            }
            $response = $response->getResponse();
            if ($response['success']) {
                $this->modx->error->reset();
            }
        }
        //
        $data = $this->userprofile2->sanitizeData($data); // first
        $realFields = $this->userprofile2->_getRealFields();
        $modUserFields = $this->userprofile2->config['modUserFields'];
        $modUserProfileFields = $this->userprofile2->config['modUserProfileFields'];
        $requiredFields = $this->userprofile2->getRequiredFields($this->type);
        // required
        foreach ($data as $f => $v) {
            if (empty($v) && array_key_exists($f, $requiredFields)) {
                $this->modx->error->addField($f, $this->modx->lexicon('up2_required_field')); // !
            }
        }
        if ($this->hasErrors()) {
            $_errFields = array();
            foreach ($this->modx->error->errors as $err) {
                $_errFields[$err['id']] = $err['msg'];
            }
            echo $this->userprofile2->error('up2_required_err', $_errFields);
            exit;
        }
        // special fields
        if (isset($data['email'])) {
            $email = $data['email'];
        }
        if (isset($data['username'])) {
            $username = $data['username'];
        }
        unset(
            $data['email'],
            $data['username'],
            $data['password']
        );
        //
        foreach ($data as $f => $v) {
            if (array_key_exists($f, $realFields)) {
                $this->object->set($f, $v);
                unset($data[$f]);
                continue;
            }
            if (array_key_exists($f, $modUserFields)) {
                $this->object->User->set($f, $v);
                unset($data[$f]);
                continue;
            }
            if (array_key_exists($f, $modUserProfileFields)) {
                if ($f == 'extended') {
                    $v = array_merge($this->object->UserProfile->get('extended'), $v);
                }
                $this->object->UserProfile->set($f, $v);
                unset($data[$f]);
                continue;
            }
        }
        // change email
        $changeEmail = false;
        if (!empty($email) && ($this->ctx != 'mgr')) {
            $currentEmail = $this->object->UserProfile->get('email');
            $newEmail = trim($email);
            $changeEmail = strtolower($currentEmail) != strtolower($newEmail);
        }
        if ($changeEmail && !empty($newEmail)) {
            $change = $this->changeEmail($newEmail);
            $this->message = array(
                'msg'  => ($change === true)
                    ? 'up2_msg_save_email'
                    : 'up2_msg_save_noemail'
            ,
                'data' => array('changeemail' => 1)
            );
        }
        // change photo
        $changePhoto = false;
        if (isset($photo) && ($this->ctx == 'mgr')) {
            $changePhoto = strtolower($this->object->UserProfile->get('photo')) != strtolower(trim($photo));
        } elseif (isset($photo) && ($this->ctx != 'mgr')) {
            if (isset($photo['name'])) {
                $photo = $photo['name'];
                $changePhoto = true;
            } elseif (!isset($photo['name']) && $removephoto) {
                $photo = '';
                $changePhoto = true;
            }
        }
        if ($changePhoto) {
            $change = $this->changePhoto($photo);
        }
        $data = $this->modx->toJSON($data);
        $this->setProperty('extend', $data);
        $this->setProperty('type', $this->type);

        return parent::beforeSet();
    }

    /** {@inheritDoc} */
    public function changePhoto($photo)
    {
        $currentPhoto = $this->object->UserProfile->get('photo');
        $params = $this->modx->fromJSON(trim($this->config['avatarParams']));
        $path = trim($this->config['avatarPath']);
        if (empty($photo) && strpos($currentPhoto, '://')) {
            $this->object->UserProfile->set('photo', '');
        } elseif (empty($photo) && !strpos($currentPhoto, '://')) {
            $this->object->UserProfile->set('photo', '');
            $this->removeCurrentPhoto($currentPhoto, $path);
        } elseif (!empty($photo)) {
            $file = strtolower(md5($this->getProperty('data') . time()) . '.' . $params['f']);
            $url = MODX_ASSETS_URL . $path . $file;
            $dst = MODX_ASSETS_PATH . $path . $file;
            // Check image dir
            $tmp = explode('/', str_replace(MODX_BASE_PATH, '', MODX_ASSETS_PATH . $path));
            $dir = rtrim(MODX_BASE_PATH, '/');
            foreach ($tmp as $v) {
                if (empty($v)) {
                    continue;
                }
                $dir .= '/' . $v;
                if (!file_exists($dir) || !is_dir($dir)) {
                    @mkdir($dir);
                }
            }
            if (!file_exists(MODX_ASSETS_PATH . $path) || !is_dir(MODX_ASSETS_PATH . $path)) {
                $this->modx->log(1, '[UP2] Could not create images dir "' . MODX_ASSETS_PATH . $path . '"');

                return false;
            }
            // upload a new foto from mgr
            if ($this->ctx == 'mgr') {
                $cur = MODX_BASE_PATH . $photo;
                if (!empty($cur) && file_exists($cur)) {
                    copy($cur, $dst);
                }
            } // upload a new foto from web
            elseif (($this->ctx != 'mgr') && !empty($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                move_uploaded_file($_FILES['photo']['tmp_name'], $dst);
            }
            if (!empty($dst)) {
                $phpThumb = $this->modx->getService('modphpthumb', 'modPhpThumb', MODX_CORE_PATH . 'model/phpthumb/',
                    array());
                $phpThumb->setSourceFilename($dst);
                foreach ($params as $k => $v) {
                    $phpThumb->setParameter($k, $v);
                }
                if ($phpThumb->GenerateThumbnail()) {
                    if ($phpThumb->renderToFile($dst)) {
                        if (!empty($cur) && file_exists($cur) && !empty($_FILES['photo'])) {
                            @unlink($cur);
                        }
                        $this->object->UserProfile->set('photo', $url);
                        $this->removeCurrentPhoto($currentPhoto, $path);
                    } else {
                        $this->modx->log(1, '[UP2] Could not save rendered image to "' . $dst . '"');
                    }
                } else {
                    $this->modx->log(1, '[UP2] ' . print_r($phpThumb->debugmessages, true));
                }
            }
        }
        if (!isset($this->message['data']['removeavatar'])) {
            $this->message = array('data' => array('removeavatar' => $url));
        }

        return true;
    }

    /** {@inheritDoc} */
    public function removeCurrentPhoto($currentPhoto, $path)
    {
        $tmp = explode('/', $currentPhoto);
        if (!empty($tmp[1])) {
            $cur = MODX_ASSETS_PATH . $path . end($tmp);
            if (!empty($cur) && file_exists($cur)) {
                @unlink($cur);

                return true;
            }
        }

        return false;
    }

    /**
     * Method for change email of user
     *
     * from
     * https://github.com/bezumkin/Office/blob/97d3e6112aa9868e7d848efd4345052ed103850b/core/components/office/controllers/profile.class.php#L273
     *
     * @param $email
     * @param $id
     *
     * @return bool
     */
    public function changeEmail($email)
    {
        if ($this->modx->getCount('modUserProfile', array('email' => $email, 'internalKey:!=' => $this->object->id))) {
            echo $this->userprofile2->error('up2_email_already_exists');
            exit;
        }
        $config = $this->config;
        $userId = $this->object->id;
        $res = is_numeric($config['redirectConfirm'])
            ? $this->modx->makeUrl($config['redirectConfirm'], '', array(), 'full')
            : $this->modx->makeUrl($this->modx->getOption('site_start'), '', array(),
                'full') . $config['redirectConfirm'];
        $activationHash = md5(uniqid(md5($this->object->User->get('email') . '/' . $userId), true));
        /** @var modDbRegister $register */
        $register = $this->modx->getService('registry', 'registry.modRegistry')->getRegister('user',
            'registry.modDbRegister');
        $register->connect();
        $register->subscribe('/email/change/');
        $register->send('/email/change/',
            array(
                md5($this->object->User->get('email')) => array(
                    'hash'  => $activationHash,
                    'email' => $email,
                    'res'   => $res
                )
            ), array('ttl' => 86400));
        $request = array(
            'hash' => $activationHash,
        );
        $link = $this->modx->makeUrl($this->modx->getOption('site_start'), '', array(), 'full');
        $link .= 'emailconfirm/?' . http_build_query($request);
        $chunk = $this->modx->getChunk($config['tplChangeEmail'],
            array_merge(
                $this->userprofile2->getUserFields($userId)
                , array('link' => $link)
            )
        );
        /** @var modPHPMailer $mail */
        $mail = $this->modx->getService('mail', 'mail.modPHPMailer');
        $mail->set(modMail::MAIL_BODY, $chunk);
        $mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
        $mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
        $mail->set(modMail::MAIL_SENDER, $this->modx->getOption('emailsender'));
        $mail->set(modMail::MAIL_SUBJECT, $this->modx->lexicon('up2_email_subject'));
        $mail->address('to', $email);
        $mail->address('reply-to', $this->modx->getOption('emailsender'));
        $mail->setHTML(true);
        $response = !$mail->send()
            ? $mail->mailer->ErrorInfo
            : true;
        $mail->reset();

        return $response;
    }

    /** {@inheritDoc} */
    public function afterSave()
    {
        $msg = !empty($this->message['msg'])
            ? $this->message['msg']
            : 'up2_profile_success_save';

        echo $this->userprofile2->success($msg, $this->message['data']);
        exit;
        //return parent::afterSave();
    }

}

return 'up2ProfileUpdateProcessor';