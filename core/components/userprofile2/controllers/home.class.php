<?php

/**
 * The home manager controller for userprofile2.
 *
 */
class userprofile2HomeManagerController extends userprofile2MainController {
	/* @var userprofile2 $userprofile2 */
	public $userprofile2;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('userprofile2');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addCss($this->userprofile2->config['cssUrl'] . 'mgr/main.css');
		$this->addCss($this->userprofile2->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/widgets/items.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/widgets/items.windows.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/widgets/home.user.panel.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "userprofile2-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->userprofile2->config['templatesPath'] . 'home.tpl';
	}
}