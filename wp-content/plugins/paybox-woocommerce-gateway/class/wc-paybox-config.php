<?php

class WC_Paybox_Config {
	private $_values;
	private $_defaults = array(
		'3ds_enabled' => 'always',
		'3ds_amount' => '',
		'amount' => '',
		'debug' => 'no',
		'delay' => 0,
		'environment' => 'TEST',
		'hmackey' => '0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF',
		'identifier' => 3262411,
		'ips' => '194.2.122.158,195.25.7.166,195.101.99.76',
		'rank' => 77,
		'site' => 1999888,
	);

	public function __construct(array $values, $defaultTitle, $defaultDesc) {
		$this->_values = $values;
		$this->_defaults['title'] = $defaultTitle;
		$this->_defaults['description'] = $defaultDesc;
	}

	protected function _getOption($name) {
		if (isset($this->_values[$name])) {
			return $this->_values[$name];
		}
		if (isset($this->_defaults[$name])) {
			return $this->_defaults[$name];
		}
		return null;
	}

	public function get3DSEnabled() {
		return $this->_getOption('3ds_enabled');
	}

	public function get3DSAmount() {
		$value = $this->_getOption('3ds_amount');
		return empty($value) ? null : floatval($value);
	}

	public function getAmount() {
		$value = $this->_getOption('amount');
		return empty($value) ? null : floatval($value);
	}

	public function getAllowedIps() {
		return explode(',', $this->_getOption('ips'));
	}

	public function getDefaults() {
		return $this->_defaults;
	}

	public function getDelay() {
		return (int)$this->_getOption('delay');
	}

	public function getDescription() {
			return $this->_getOption('description');
	}

	public function getHmacAlgo() {
		return 'SHA512';
	}

	public function getHmacKey() {
		$crypto = new PayboxEncrypt();
		return $crypto->decrypt($this->_values['hmackey']);
	}

	public function getIdentifier() {
		return $this->_getOption('identifier');
	}

	public function getRank() {
		return $this->_getOption('rank');
	}

	public function getSite() {
		return $this->_getOption('site');
	}

	public function getSystemProductionUrls() {
		return array(
			'https://tpeweb.paybox.com/php/',
			'https://tpeweb1.paybox.com/php/',
		);
	}

	public function getSystemTestUrls() {
		return array(
			'https://preprod-tpeweb.paybox.com/php/'
		);
	}

	public function getSystemUrls() {
		if ($this->isProduction()) {
			return $this->getSystemProductionUrls();
		}
		return $this->getSystemTestUrls();
	}

	public function getTitle() {
		return $this->_getOption('title');
	}

	public function isDebug() {
		return $this->_getOption('debug') === 'yes';
	}

	public function isProduction() {
		return $this->_getOption('environment') === 'PRODUCTION';
	}
}
