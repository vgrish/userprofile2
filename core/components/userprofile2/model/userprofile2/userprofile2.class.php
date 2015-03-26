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
			'processorsPath' => $corePath . 'processors/'
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
		if(!$typeProfile = $up2Profile->get('type')) {
			$typeProfile = $this->getProfileTypeDefault();
			$up2Profile->set('type', $typeProfile);
			$up2Profile->save();
		}

		$this->modx->log(1, print_r($up2Profile->toArray() ,1));


		$this->modx->log(1 , print_r('OnUserFormPrerender' ,1));

		$this->modx->controller->addLexiconTopic('userprofile2:default');
		$this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/main.css');

		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/userprofile2.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/misc/utils.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/misc/up2.combo.js');

		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/inject/user.panel.js');
		$this->modx->regClientStartupScript($this->getOption('jsUrl') . 'mgr/inject/tab.js');


		//$typeProfile =

		$config = array(
			'connector_url' => $this->config['connectorUrl'],
			'type' => $typeProfile,
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
}