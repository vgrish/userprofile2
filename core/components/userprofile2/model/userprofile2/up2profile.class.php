<?php
class up2Profile extends xPDOObject {

	/** {@inheritdoc} */
	public function save(array $ancestors= array ()) {
		if($this->isNew()) {
			$ip = $this->xpdo->request->getClientIp();
			$this->set('registration', time());
			$this->set('lastactivity', time());
			$this->set('ip', $ip['ip']);
		}

		return parent::save();
	}
}