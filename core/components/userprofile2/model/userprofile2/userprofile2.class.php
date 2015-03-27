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

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/',

			'cache_key' => $this->namespace.'/',

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
	 * @param array $d
	 * @return bool
	 */
	public function isModeEventNew($d = array())
	{
		return ($d['mode'] == 'new')
			? true
			: false;
	}


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
					'editable' => $field->get('editable'),
					'value' => $field->get('value'),
					'css' => $field->get('css'),
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
	 * @param $key
	 * @param array $data
	 * @return mixed
	 */
	public function setCache($key, $data = array())
	{
		if(empty($key)) {return $key;}
		$cacheKey = $this->config['cache_key'];
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => $cacheKey);
		$this->modx->cacheManager->set($key, $data, 0, $cacheOptions);

		return $key;
	}

	/**
	 * @param $key
	 * @return mixed|string
	 */
	public function getCache($key)
	{
		$cached = '';
		if(empty($key)) {return $cached;}
		$cacheKey = $this->config['cache_key'];
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => $cacheKey);
		$cached = $this->modx->getCacheManager()->get($key, $cacheOptions);

		return $cached;
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	public function clearCache($key)
	{
		if(empty($key)) {return $key;}
		$cacheKey = $this->config['cache_key'];
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => $cacheKey);
		$this->modx->cacheManager->clean($cacheOptions);

		return $key;
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
		if(!$extended = $user->getOne('Profile')->get('extended')) {
			$extended = array();
		}
		$tabsFields = $this->getTabsFields($type);


		$this->modx->log(1 , print_r('====DATA======' ,1));
		$this->modx->log(1 , print_r($tabsFields ,1));


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
			'extended' => $extended,
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
	public function OnBeforeCacheUpdate($sp)
	{
		$key = '/';
		if($this->clearCache($key)) {
			$this->modx->log(modX::LOG_LEVEL_INFO, '[UP2] Clearing the cache. Path: ' . $key  );
		}
	}

}