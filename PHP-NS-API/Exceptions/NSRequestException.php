<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Request Exception
	 * 
	 * @author JKCTech
	 */

	namespace JKCTech\NS\Exception;

	/**
	 * NSRequestException
	 */
	Class NSRequestException extends \Exception
	{
		/**
		 * Create an NSRequestException.
		 *
		 * @param mixed $message
		 * @param integer $code
		 * @param Exception $previous
		 * 
		 * @return void
		 */
		public function __construct($message, $code = 0, Exception $previous = null)
		{
			parent::__construct($message, $code, $previous);
		}

		/**
		 * Exception to string method.
		 *
		 * @return string
		 */
		public function __toString()
		{
			return __CLASS__ . ": [{$this->code}] {$this->message}\n";
		}
	}
?>