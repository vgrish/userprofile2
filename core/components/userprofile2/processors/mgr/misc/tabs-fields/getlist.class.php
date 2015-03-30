<?php
class up2TabsFieldsGetListProcessor extends modObjectProcessor {
	public $classKey = 'up2TypeProfile';
	/** {@inheritDoc} */
	public function process() {
		$type = $this->getProperty('type');
		$result = $this->modx->userprofile2->getTabsFields($type);

		return $this->modx->userprofile2->success($this->modx->toJSON($result));
		//return $this->modx->toJSON($result);
	}
}
return 'up2TabsFieldsGetListProcessor';