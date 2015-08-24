<?php

/**
 * The base class for userprofile2.
 */
class userprofile2 {
	/* @var modX $modx */
	public $modx;

	public $namespace = 'userprofile2';
	public $cache = null;
	public $config = array();
	public $initialized = array();
	public $active = false;

	/* @var pdoTools $pdoTools */
	public $pdoTools;

	public $realFields = array(
		'lastname',
		'firstname',
		'secondname'
	);

	public $forbiddenFields = array(
		'id',
		'cachepwd',
		'class_key',
		'active',
		'remote_key',
		'remote_data',
		'hash_class',
		'salt',
		'primary_group',
		'session_stale',
		'sudo',
		'internalKey',
		'blocked',
		'blockeduntil',
		'blockedafter',
		'logincount',
		'lastlogin',
		'thislogin',
		'failedlogincount',
		'sessionid'
	);

	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$this->namespace = $this->getOption('namespace', $config, 'userprofile2');
		$corePath = $this->modx->getOption('userprofile2_core_path', $config, $this->modx->getOption('core_path') . 'components/userprofile2/');
		$assetsUrl = $this->modx->getOption('userprofile2_assets_url', $config, $this->modx->getOption('assets_url') . 'components/userprofile2/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,
			'actionUrl' => $assetsUrl . 'action.php',

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/',

			'cacheKey' => $this->namespace.'/',
			'jsonResponse' => true,

			'dateFormat' => 'd F Y, H:i',
			'dateNow' => 10,
			'dateDay' => 'day H:i',
			'dateMinutes' => 59,
			'dateHours' => 10,

			'gravatarUrl' => 'https://www.gravatar.com/avatar/',
			'gravatarSize' => 300,
			'gravatarIcon' => 'mm',

			'frontendCss' => $this->modx->getOption('userprofile2_front_css', null, '[[+assetsUrl]]css/web/default.css'),
			'frontendJs' => $this->modx->getOption('userprofile2_front_js', null, '[[+assetsUrl]]js/web/default.js'),

			'avatarParams' => $this->modx->getOption('userprofile2_avatar_params', null, '{"w":274,"h":274,"zc":1,"q":90,"bg":"ffffff","f":"jpg"}'),
			'avatarPath' => $this->modx->getOption('userprofile2_avatar_path', null, 'images/users/'),

			'modUserFields' => array(),
			'modUserProfileFields' => array(),


		), $config);

		$this->modx->addPackage('userprofile2', $this->config['modelPath']);
		$this->modx->lexicon->load('userprofile2:default');

		$this->active = $this->modx->getOption('userprofile2_active', $config, false);
	}

	/**
	 * @param $key
	 * @param array $config
	 * @param null $default
	 * @return mixed|null
	 */
	public function getOption($key, $config = array(), $default = null)
	{
		$option = $default;
		if (!empty($key) && is_string($key)) {
			if ($config != null && array_key_exists($key, $config)) {
				$option = $config[$key];
			} elseif (array_key_exists($key, $this->config)) {
				$option = $this->config[$key];
			} elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
				$option = $this->modx->getOption("{$this->namespace}.{$key}");
			}
		}
		return $option;
	}

	/**
	 * @param string $ctx
	 * @param array $scriptProperties
	 * @return bool
	 */
	public function initialize($ctx = 'web', $scriptProperties = array())
	{
		$this->config = array_merge($this->config, $scriptProperties);
		if (!$this->pdoTools) {
			$this->loadPdoTools();
		}
		$this->pdoTools->setConfig($this->config);
		$this->config['ctx'] = $ctx;
		if (!empty($this->initialized[$ctx])) {
			return true;
		}
		switch ($ctx) {
			case 'mgr':
				break;
			default:
				if (!defined('MODX_API_MODE') || !MODX_API_MODE) {
					if ($css = trim($this->config['frontendCss'])) {
						if (preg_match('/\.css/i', $css)) {
							$this->modx->regClientCSS(str_replace('[[+assetsUrl]]', $this->config['assetsUrl'], $css));
						}
					}
					$config_js = preg_replace(array('/^\n/', '/\t{5}/'), '', '
					userprofile2 = {};
					userprofile2Config = {
						cssUrl: "' . $this->config['cssUrl'] . 'web/"
						,jsUrl: "' . $this->config['jsUrl'] . 'web/"
						,actionUrl: "' . $this->config['actionUrl'] . '"
						,ctx: "' . $this->modx->context->get('key') . '"
						,close_all_message: "' . $this->modx->lexicon('up2_message_close_all') . '"
					};
					');
					$this->modx->regClientStartupScript("<script type=\"text/javascript\">\n" . $config_js . "\n</script>", true);
					if ($js = trim($this->config['frontendJs'])) {
						if (!empty($js) && preg_match('/\.js/i', $js)) {
							$this->modx->regClientScript(preg_replace(array('/^\n/', '/\t{7}/'), '', '
							<script type="text/javascript">
								if(typeof jQuery == "undefined") {
									document.write("<script src=\"' . $this->config['jsUrl'] . 'web/lib/jquery.min.js\" type=\"text/javascript\"><\/script>");
								}
							</script>
							'), true);
							$this->modx->regClientScript(str_replace('[[+assetsUrl]]', $this->config['assetsUrl'], $js));
						}
					}
				}
				$this->initialized[$ctx] = true;
				break;
		}
		return true;
	}

	/**
	 * from https://github.com/bezumkin/Tickets/blob/9c09152ae4a1cdae04fb31d2bc0fa57be5e0c7ea/core/components/tickets/model/tickets/tickets.class.php#L1120
	 *
	 * Loads an instance of pdoTools
	 * @return boolean
	 */
	public function loadPdoTools()
	{
		if (!is_object($this->pdoTools) || !($this->pdoTools instanceof pdoTools)) {
			/** @var pdoFetch $pdoFetch */
			$fqn = $this->modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
			if ($pdoClass = $this->modx->loadClass($fqn, '', false, true)) {
				$this->pdoTools = new $pdoClass($this->modx, $this->config);
			} elseif ($pdoClass = $this->modx->loadClass($fqn, MODX_CORE_PATH . 'components/pdotools/model/', false, true)) {
				$this->pdoTools = new $pdoClass($this->modx, $this->config);
			} else {
				$this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".');
			}
		}
		return !empty($this->pdoTools) && $this->pdoTools instanceof pdoTools;
	}

	/**
	 * from https://github.com/bezumkin/Tickets/blob/9c09152ae4a1cdae04fb31d2bc0fa57be5e0c7ea/core/components/tickets/model/tickets/tickets.class.php#L1147
	 *
	 * Process and return the output from a Chunk by name.
	 * @param string $name The name of the chunk.
	 * @param array $properties An associative array of properties to process the Chunk with, treated as placeholders within the scope of the Element.
	 * @param boolean $fastMode If false, all MODX tags in chunk will be processed.
	 * @return string The processed output of the Chunk.
	 */
	public function getChunk($name, array $properties = array(), $fastMode = false)
	{
		if (!$this->modx->parser) {
			$this->modx->getParser();
		}
		if (!$this->pdoTools) {
			$this->loadPdoTools();
		}
		return $this->pdoTools->getChunk($name, $properties, $fastMode);
	}

	/**
	 * @param $type
	 * @return array|mixed|string
	 */
	public function getTabsFields($type)
	{
		$key = 'tabs_fields/' . $type;
		$data = $this->getCache($key);
		if(!empty($data)) {return $data;}
		//
		$data = $ids = array();
		$q = $this->modx->newQuery('up2Tabs', array(
			'active' => 1,
			'type' => $type,
			));
		$q->sortby('`up2Tabs`.`rank`', 'ASC');
		$q->select('id');
		if ($q->prepare() && $q->stmt->execute()) {
			$ids = $q->stmt->fetchAll(PDO::FETCH_COLUMN);
		}
		if(count($ids) == 0) {return $data;}
		foreach ($ids as $id) {
			if(!$tab = $this->modx->getObject('up2Tabs', $id)) {continue;}
			if(!$typeTab = $tab->getOne('TypeTab')) {continue;}
			if(!$typeTab->get('active')) {continue;}
			//
			$_ids = array();
			$q = $this->modx->newQuery('up2Fields', array(
				'active' => 1,
				'tab' => $typeTab->get('id'),
			));
			$q->sortby('`up2Fields`.`rank`', 'ASC');
			$q->select('id');
			if ($q->prepare() && $q->stmt->execute()) {
				$_ids = $q->stmt->fetchAll(PDO::FETCH_COLUMN);
			}
			if(count($_ids) == 0) {continue;}
			$_dataField = array();
			foreach ($_ids as $_id) {
				if(!$field = $this->modx->getObject('up2Fields', $_id)) {continue;}
				if(!$typeField = $field->getOne('TypeField')) {continue;}
				$_dataField[$field->get('name_out')] = array(
					'name_in' => $field->get('name_in'),
					'name_out' => $field->get('name_out'),
					'required' => $field->get('required'),
					'readonly' => $field->get('readonly'),
					'editable' => $field->get('editable'),
					'value' => $field->get('value'),
					'css' => $field->get('css'),
					'length' => $field->get('length'),
					'type_in' => $typeField->get('type_in'),
					'type_out' => $typeField->get('type_out'),
				);
			}
			$data[$typeTab->get('name_out')] = array(
				'name_in' => $typeTab->get('name_in'),
				'name_out' => $typeTab->get('name_out'),
				'description' => $typeTab->get('description'),
				'fields' => $_dataField,
			);
		}
		if(!$this->setCache($key, $data)) {
			$this->modx->log(1, print_r('[UP2]:Error set cache for key - ' . $key, 1));
		}

		return $data;
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getUserFields($id) {
		$data = array();
		if(!is_array($id)) {
			if(!$user = $this->modx->getObject('modUser', $id)) {
				return $data;
			}
			$data = $user->toArray();
			if ($Profile = $user->getOne('Profile')) {
				$data = array_merge($data, $Profile->toArray());
			}
			if ($up2Profile = $user->getOne('up2Profile')) {
				$data = array_merge($data, $up2Profile->toArray());
			}
		}
		else {$data = $id;}
		$data['extend'] = (array) $data['extend'];
		$data['property'] = (array) $data['property'];
		$data['gravatar'] = $this->config['gravatarUrl'] . md5(strtolower($data['email'])) .'?s=' . $this->config['gravatarSize'] . '&d=' . $this->config['gravatarIcon'];
		$data['avatar'] = !empty($data['photo'])
			? $data['photo']
			: $data['gravatar'];
		$data['fullname'] = !empty($data['fullname'])
			? $data['fullname']
			: $data['email'];
		$data['firstname'] = !empty($data['firstname'])
			? $data['firstname']
			: $data['fullname'];
		$data['registration_format'] = $this->dateFormat($data['registration']);
		$data['lastactivity_format'] = $this->dateFormat($data['lastactivity']);

		unset(
			$data['internalKey'],
			$data['failedlogincount'],
			$data['password'],
			$data['cachepwd'],
			$data['sessionid'],
			$data['hash_class'],
			$data['salt']
		);

		return $data;
	}

	/**
	 * @param $type
	 * @return array
	 */
	public function getRequiredFields($type)
	{
		$requiredFields = array();
		$tabsFields = $this->getTabsFields($type);
		if(count($tabsFields) == 0) {return $requiredFields;}
		foreach ($tabsFields as $tabs) {
			if((count($tabs['fields']) == 0)) {continue;}
			foreach($tabs['fields'] as $field) {
				if(!empty($field['required'])) {
					$requiredFields[$field['name_out']] = 1;
				}
			}
		}
		return $requiredFields;
	}

	/**
	 * @return int
	 */
	public function getProfileTypeDefault()
	{
		$id = 0;
		$q = $this->modx->newQuery('up2TypeProfile');
		$q->sortby('`up2TypeProfile`.`rank`', 'ASC');
		$q->select('`up2TypeProfile`.`id`');
		$q->where(array('up2TypeProfile.active' => 1,'up2TypeProfile.default' => 1));
		$q->limit(1);
		if ($q->prepare() && $q->stmt->execute()) {
			$id = $q->stmt->fetch(PDO::FETCH_COLUMN);
		}
		return (int) $id;
	}

	/**
	 * @return array
	 */
	public function _getRealFields()
	{
		return array_flip($this->realFields);
	}

	/**
	 * Вернет массив имен всех действующих полей
	 *
	 * @return array
	 */
	public function _getAllNamesFields()
	{
		$names = array();
		$allNames = array_keys(array_merge($this->_getUserProfileNamesFields(), $this->_getOutNamesFields()));
		$fieldsNotAllowed = array_map('trim', explode(',', $this->modx->getOption('userprofile2_fields_not_allowed', null, '')));
		$fieldsAllowed = array_unique(array_map('trim', explode(',', $this->modx->getOption('userprofile2_fields_allowed', null, ''))));
		$fieldsAllowed = array_unique(array_merge($fieldsAllowed, $this->realFields));
		$forbiddenFields = array_flip(array_unique(array_merge($this->forbiddenFields, $fieldsNotAllowed)));
		foreach($allNames as $name) {
			if(array_key_exists($name, $forbiddenFields)) {continue;}
			$names[] = $name;
		}

		return array_flip(array_unique(array_merge($names, $fieldsAllowed)));
	}

	/**
	 * @return array
	 */
	public function _getUserProfileNamesFields()
	{
		$this->config['modUserFields'] = $this->modx->getFields('modUser');
		$this->config['modUserProfileFields'] = $this->modx->getFields('modUserProfile');

		return array_flip(array_keys(array_merge($this->config['modUserFields'], $this->config['modUserProfileFields'])));
	}

	/**
	 * @return array
	 */
	public function _getOutNamesFields()
	{
		$names = array();
		$q = $this->modx->newQuery('up2Fields');
		$q->select('name_out');
		$q->limit(0);
		if ($q->prepare() && $q->stmt->execute()) {
			$names = $q->stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		return array_flip($names);
	}

	/**
	 * @return mixed|string
	 */
	public function _getLengthFields()
	{
		$key = 'tabs_fields/length';
		$lengthFields = $this->getCache($key);
		if(!empty($lengthFields)) {return $lengthFields;}
		$q = $this->modx->newQuery('up2Fields');
		$q->select('name_out,length');
		$q->limit(0);
		if ($q->prepare() && $q->stmt->execute()) {
			while ($row = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
				$lengthFields[$row['name_out']] = $row['length'];
			}
		}
		$this->setCache($key, $lengthFields);

		return $lengthFields;
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function sanitizeData(array $data = array())
	{
		$_data = array();
		$allNamesFields = $this->_getAllNamesFields();
		$lengthFields = $this->_getLengthFields();
		foreach($data as $f => $v) {
			if(is_array($f)) {continue;}
			if(!array_key_exists($f , $allNamesFields)) {continue;}
			$_data[$f] = $this->sanitize($v, $lengthFields[$f]);
		}

		return $_data;
	}

	/**
	 * Sanitizes a string
	 *
	 * from https://github.com/bezumkin/Office/blob/master/core/components/office/controllers/profile.class.php#L254
	 *
	 * @param string $string The string to sanitize
	 * @param integer $length The length of sanitized string
	 * @return string The sanitized string.
	 */
	public function sanitize($string = '', $length = 0) {
		$expr = $this->modx->getOption('userprofile2_sanitize_pcre', null, '/[^-_a-z\p{L}0-9@\s\.\,\:\/\\\]+/iu', true);
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$sanitized = trim(preg_replace($expr, '', $string));
		return !empty($length)
			? mb_substr($sanitized, 0, $length, 'UTF-8')
			: $sanitized;
	}

	/**
	 * @param $key
	 * @param array $data
	 * @param int $lifetime
	 * @param array $options
	 *
	 * @return string
	 */
	public function setCache($key, $data = array(), $lifetime= 0, $options = array())
	{
		$cacheKey = $this->config['cacheKey'];
		if(array_key_exists('path', $options)){
			$cacheKey .= $options['path'].'/';
		}
		if(array_key_exists('hash', $options)){
			$key = sha1(serialize($options + array($key)));
		}
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => $cacheKey);
		if (!empty($key) && !empty($cacheOptions) && $this->modx->getCacheManager()) {
			$this->modx->cacheManager->set(
				$key,
				$data,
				(integer) $lifetime,
				$cacheOptions
			);
		}

		return $key;
	}

	/**
	 * @param $key
	 * @param array $options
	 *
	 * @return mixed|string
	 */
	public function getCache($key, $options = array())
	{
		$cacheKey = $this->config['cacheKey'];
		if(array_key_exists('path', $options)){
			$cacheKey .= $options['path'].'/';
		}
		if(array_key_exists('hash', $options)){
			$key = sha1(serialize($options + array($key)));
		}
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => $cacheKey);
		$cached = '';
		if (!empty($key) && !empty($cacheOptions) && $this->modx->getCacheManager()) {
			$cached = $this->modx->cacheManager->get($key, $cacheOptions);
		}

		return $cached;
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	public function clearCache()
	{
		$cacheKey = $this->config['cacheKey'];
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => $cacheKey);
		if (!empty($cacheOptions) && $this->modx->getCacheManager()) {
			$this->modx->cacheManager->clean($cacheOptions);
		}

		return true;
	}

	/**
	 * @param array $params
	 * @param int $id
	 * @return string
	 */
	public function logout($params = array(), $id = 0)
	{
		if($user = $this->modx->getAuthenticatedUser($this->modx->context->key)) {
			$this->modx->user = $user;
			$this->modx->getUser($this->modx->context->key);
		}
		if(!$user) {return '';}
		if(!$response = $this->modx->runProcessor('logout',
			$params
			, array(
				'processors_path' => MODX_CORE_PATH .'model/modx/processors/security/',
			))) {
			return '';
		}
		if($response->isError()) {
			$this->modx->log(1, '[UP2] logout error. Username: ' . $this->modx->user->get('username') . ', uid: ' . $this->modx->user->get('id'));
		}
		$this->modx->sendRedirect($this->modx->makeUrl((!empty($id)) ? $id : $this->modx->getOption('site_start'), '', '', 'full'));

	}

	/**
	 * Formats date to "10 minutes ago" or "Yesterday in 22:10"
	 * This algorithm taken from https://github.com/livestreet/livestreet/blob/7a6039b21c326acf03c956772325e1398801c5fe/engine/modules/viewer/plugs/function.date_format.php
	 * @param string $date Timestamp to format
	 * @param string $dateFormat
	 *
	 * @return string
	 */
	public function dateFormat($date, $dateFormat = null)
	{
		$date = preg_match('/^\d+$/', $date) ? $date : strtotime($date);
		$dateFormat = !empty($dateFormat) ? $dateFormat : $this->config['dateFormat'];
		$current = time();
		$delta = $current - $date;
		if ($this->config['dateNow']) {
			if ($delta < $this->config['dateNow']) {
				return $this->modx->lexicon('up2_date_now');
			}
		}
		if ($this->config['dateMinutes']) {
			$minutes = round(($delta) / 60);
			if ($minutes < $this->config['dateMinutes']) {
				if ($minutes > 0) {
					return $this->declension($minutes, $this->modx->lexicon('up2_date_minutes_back', array('minutes' => $minutes)));
				} else {
					return $this->modx->lexicon('up2_date_minutes_back_less');
				}
			}
		}
		if ($this->config['dateHours']) {
			$hours = round(($delta) / 3600);
			if ($hours < $this->config['dateHours']) {
				if ($hours > 0) {
					return $this->declension($hours, $this->modx->lexicon('up2_date_hours_back', array('hours' => $hours)));
				} else {
					return $this->modx->lexicon('up_date_hours_back_less');
				}
			}
		}
		if ($this->config['dateDay']) {
			switch (date('Y-m-d', $date)) {
				case date('Y-m-d'):
					$day = $this->modx->lexicon('up2_date_today');
					break;
				case date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))):
					$day = $this->modx->lexicon('up2_date_yesterday');
					break;
				case date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'))):
					$day = $this->modx->lexicon('up2_date_tomorrow');
					break;
				default:
					$day = null;
			}
			if ($day) {
				$format = str_replace("day", preg_replace("#(\w{1})#", '\\\${1}', $day), $this->config['dateDay']);
				return date($format, $date);
			}
		}
		$m = date("n", $date);
		$month_arr = $this->modx->fromJSON($this->modx->lexicon('up2_date_months'));
		$month = $month_arr[$m - 1];
		$format = preg_replace("~(?<!\\\\)F~U", preg_replace('~(\w{1})~u', '\\\${1}', $month), $dateFormat);
		return date($format, $date);
	}

	/**
	 * Declension of words
	 * This algorithm taken from https://github.com/livestreet/livestreet/blob/eca10c0186c8174b774a2125d8af3760e1c34825/engine/modules/viewer/plugs/modifier.declension.php
	 *
	 * @param int $count
	 * @param string $forms
	 * @param string $lang
	 *
	 * @return string
	 */
	public function declension($count, $forms, $lang = null)
	{
		if (empty($lang)) {
			$lang = $this->modx->getOption('cultureKey', null, 'en');
		}
		$forms = $this->modx->fromJSON($forms);
		if ($lang == 'ru') {
			$mod100 = $count % 100;
			switch ($count % 10) {
				case 1:
					if ($mod100 == 11) {
						$text = $forms[2];
					} else {
						$text = $forms[0];
					}
					break;
				case 2:
				case 3:
				case 4:
					if (($mod100 > 10) && ($mod100 < 20)) {
						$text = $forms[2];
					} else {
						$text = $forms[1];
					}
					break;
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 0:
				default:
					$text = $forms[2];
			}
		} else {
			if ($count == 1) {
				$text = $forms[0];
			} else {
				$text = $forms[1];
			}
		}
		return $text;
	}

	/**
	 * @param string $message
	 * @param array $data
	 * @param array $placeholders
	 * @return array|string
	 */
	public function error($message = '', $data = array(), $placeholders = array())
	{
		$response = array(
			'success' => false,
			'message' => $this->modx->lexicon($message, $placeholders),
			'data' => $data,
		);
		return $this->config['jsonResponse']
			? $this->modx->toJSON($response)
			: $response;
	}

	/**
	 * @param string $message
	 * @param array $data
	 * @param array $placeholders
	 * @return array|string
	 */
	public function success($message = '', $data = array(), $placeholders = array())
	{
		$response = array(
			'success' => true,
			'message' => $this->modx->lexicon($message, $placeholders),
			'data' => $data,
		);
		return $this->config['jsonResponse']
			? $this->modx->toJSON($response)
			: $response;
	}

	/**
	 * @param array $d
	 * @return bool
	 */
	public function isModeEventNew($d = array())
	{
		return ($d['mode'] == 'new')
			? true
			: false;
	}

	/*
	 * EVENT
	 */

	/**
	 * @param $sp
	 */
	public function OnUserFormPrerender($sp)
	{
		if($this->isModeEventNew($sp)) {return '';}
		$id = $sp['id'];
		$user = $sp['user'];
		if(!$up2Profile = $user->getOne('up2Profile')) {return '';};
		if(!$type = $up2Profile->get('type')) {
			$type = $this->getProfileTypeDefault();
			$up2Profile->set('type', $type);
			$up2Profile->save();
		}
		$data = $this->getUserFields($id);
		$tabsFields = $this->getTabsFields($type);
		//
		$this->modx->controller->addLexiconTopic('userprofile2:default');
		$this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/main.css');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/userprofile2.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/misc/utils.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/misc/up2.combo.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/inject/user.panel.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/inject/tab.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'lib/zepto-1.1.6.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'lib/jquery.serializejson.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'lib/spec.js');
		//
		$config = array(
			'connector_url' => $this->config['connectorUrl'],
			'tabsfields' => $tabsFields,
			'extend' => $data['extend'],
			'data' => $data,
			'type' => $type,
			'user' => $id,
		);
		$data_js = preg_replace(array('/^\n/', '/\t{6}/'), '', '
			userprofile2.config = ' . $this->modx->toJSON($config) . ';
		');
		$this->modx->regClientStartupScript("<script type=\"text/javascript\">\n" . $data_js . "\n</script>", true);
	}

	/**
	 * @param $sp
	 */
	public function OnUserSave($sp)
	{
		if(!$this->isModeEventNew($sp)) {return '';};
		$user = $sp['user'];
		$user->getOne('up2Profile');
	}

	/**
	 * @param $sp
	 */
	public function OnLoadWebDocument($sp)
	{
		if($this->modx->user->isAuthenticated($this->modx->context->get('key'))) {
			if(!$this->modx->user->active || $this->modx->user->Profile->blocked || $_REQUEST['up2action'] == 'auth_logout') {
				$this->logOut();
			}
			elseif($up2Profile = $this->modx->user->getOne('up2Profile')) {
				$ip = $this->modx->request->getClientIp();
				$up2Profile->set('lastactivity', time());
				$up2Profile->set('ip', $ip['ip']);
				$up2Profile->save();
			}
		}
	}

	/**
	 * @param $sp
	 */
	public function OnUserRemove($sp)
	{
		$user = $sp['user'];
		$id = $user->get('id');
		$this->modx->removeCollection('up2Profile', array('id:=' => $id));
	}

	/**
	 * @param $sp
	 */
	public function OnBeforeCacheUpdate($sp)
	{
		$this->clearCache();
	}
}