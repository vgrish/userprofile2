<?php

require_once dirname(dirname(dirname(__FILE__))) . '/index.class.php';

class ControllersSettingsManagerController extends userprofile2MainController {

	public static function getDefaultController() {
		return 'settings';
	}

}

class userprofile2SettingsManagerController extends userprofile2MainController {

	public function getPageTitle() {
		return $this->modx->lexicon('userprofile2') . ' :: ' . $this->modx->lexicon('up2_settings');
	}

	public function getLanguageTopics() {
		return array('userprofile2:default,setting,lexicon');
	}

	public function loadCustomCssJs() {
		$this->addJavascript(MODX_MANAGER_URL . 'assets/modext/util/datetime.js');
		$this->addJavascript(MODX_MANAGER_URL . 'assets/modext/workspace/lexicon/combos.js');

		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/misc/utils.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/misc/up2.combo.js');

		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/typefield.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/typeprofile.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/fields.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/typetab.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/setting.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/lexicon.grid.js');
		$this->addJavascript($this->userprofile2->config['jsUrl'] . 'mgr/settings/settings.panel.js');

		$this->addHtml(str_replace('			', '', '
			<script type="text/javascript">
				Ext.onReady(function() {
					MODx.load({ xtype: "userprofile2-page-settings"});
				});
			</script>'
		));
	}

	public function getTemplateFile() {
		return $this->userprofile2->config['templatesPath'] . 'mgr/settings.tpl';
	}

}

// MODX 2.3
class ControllersMgrSettingsManagerController extends ControllersSettingsManagerController {

	public static function getDefaultController() {
		return 'mgr/settings';
	}

}

class userprofile2MgrSettingsManagerController extends userprofile2SettingsManagerController {

}
