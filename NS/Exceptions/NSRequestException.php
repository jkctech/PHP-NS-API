<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * NSRequestException
	 * 
	 * Author: JKCTech
	 * Date: 11-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS\Exception;

	Class NSRequestException extends \Exception
	{
		public function __construct($message, $code = 0, Exception $previous = null)
		{
			parent::__construct($message, $code, $previous);
		}

		public function __toString()
		{
			return __CLASS__ . ": [{$this->code}] {$this->message}\n";
		}
	}
?>