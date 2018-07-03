<?php
/**
 * Paybox WooCommerce Module
 *
 * Feel free to contact Paybox at support@paybox.fr for any
 * question.
 *
 * LICENSE: This source file is subject to the version 3.0 of the Open
 * Software License (OSL-3.0) that is available through the world-wide-web
 * at the following URI: http://opensource.org/licenses/OSL-3.0. If
 * you did not receive a copy of the OSL-3.0 license and are unable 
 * to obtain it through the web, please send a note to
 * support@paybox.fr so we can mail you a copy immediately.
 *
 * @author Guillaume - BM Services (http://www.bm-services.com)
 * @copyright 2012-2015 Paybox
 * @license http://opensource.org/licenses/OSL-3.0
 * @link http://www.paybox.com/
 * @since 2
 * */

class PayboxEncrypt {
	/*
	 * You can change this method 
	 if you want to change the way the key is generated.
	 */
	public function generateKey(){
		// generate key, write to KEY_FILE_PATH
		$key = openssl_random_pseudo_bytes(16);
		if(file_exists(WC_PAYBOX_KEY_PATH))unlink(WC_PAYBOX_KEY_PATH);
		$key = bin2hex($key);
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
		$size = mcrypt_enc_get_iv_size($td);
    	$iv = mcrypt_create_iv($size, MCRYPT_RAND);
		$iv = bin2hex($iv);
		file_put_contents(WC_PAYBOX_KEY_PATH,"<?php" . $key.$iv ."?>");
		// Init vector
		
	}
	/**
	 * @return string Key used for encryption
	 */
	 private function _getKey()
	{
		//check whether key on KEY_FILE_PATH exists, if not generate it.
		if(!file_exists(WC_PAYBOX_KEY_PATH)){
			$this->generateKey();
			$_POST['KEY_ERROR'] = __("For some reason, the key has just been generated. please reenter the HMAC key to crypt it.");
		}else{
			$key = file_get_contents(WC_PAYBOX_KEY_PATH);
			$key = substr($key,5,32);
			return $key;
		}
	}
	/**
	 * @return string Key used for encryption
	 */
	 private function _getIv()
	{
		//check whether key on KEY_FILE_PATH exists, if not generate it.
		if(!file_exists(WC_PAYBOX_KEY_PATH)){
			$this->generateKey();
			$_POST['KEY_ERROR'] = __("For some reason, the key has just been generated. please reenter the HMAC key to crypt it.");
		}else{
			$iv = file_get_contents(WC_PAYBOX_KEY_PATH);
			$iv = substr($iv,37,16);
			return $iv;
		}
	}

	/**
	 * Encrypt $data using AES
	 * @param string $data The data to encrypt
	 * @return string The result of encryption
	 */
	public function encrypt($data)
	{
		if (empty($data)) {
			return '';
		}
		// First encode data to base64 (see end of descrypt)
		$data = base64_encode($data);

		// Prepare mcrypt
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

		// Prepare key
		$key = $this->_getKey();
		$key = substr($key, 0, 24);
		while (strlen($key) < 24) {
			$key .= substr($key, 0, 24 - strlen($key));
		}
		// Init vector
		$iv = $this->_getIv();
		mcrypt_generic_init($td, $key, $iv);

		// Encrypt 
    	$result = mcrypt_generic($td, $data);

    	// Encode (to avoid data loose when saved to database or
    	// any storage that does not support null chars)
    	$result = base64_encode($result);
		return $result;
		
	}

	/**
	 * Decrypt $data using 3DES
	 * @param string $data The data to decrypt
	 * @return string The result of decryption
	 * @see PAYBOX_Epayment_Helper_Encrypt::_getKey()
	 */
	public function decrypt($data)
	{
		if (empty($data)) {
			return '';
		}

		// First decode encrypted message (see end of encrypt)
		$data = base64_decode($data);

		// Prepare mcrypt
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

		// Prepare key
		$key = $this->_getKey();
		$key = substr($key, 0, 24);
		while (strlen($key) < 24) {
			$key .= substr($key, 0, 24 - strlen($key));
		}
		// Init vector
		$iv = $this->_getIv();
		mcrypt_generic_init($td, $key, $iv);

		// Decrypt
    	$result = mdecrypt_generic($td, $data);

    	// Remove any null char (data is base64 encoded so no data loose)
    	$result = rtrim($result, "\0");

    	// Decode data
    	$result = base64_decode($result);

    	return $result;
	}
}