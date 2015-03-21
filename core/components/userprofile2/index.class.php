<?php

/**
 * Class userprofile2MainController
 */
abstract class userprofile2MainController extends modExtraManagerController {
	/** @var userprofile2 $userprofile2 */
	public $userprofile2;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('userprofile2_core_path', null, $this->modx->getOption('core_path') . 'components/userprofile2/');
		require_once $corePath . 'model/userprofile2/userprofile2.class.php';

		$this->userprofile2 = new userprofile2($this->modx);
		$this->addCss($this->userprofile2->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/userprofile2.js');
		$this->addHtml('
		<script type="text/javascript">
			userprofile2.config = ' . $this->modx->toJSON($this->userprofile2->config) . ';
			userprofile2.config.connector_url = "' . $this->userprofile2->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('userprofile2:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends userprofile2MainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}