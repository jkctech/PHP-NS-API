<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * NSApp
	 * https://apiportal.ns.nl/products/NsApp
	 * 
	 * Author: JKCTech
	 * Date: 12-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class NSApp
	{
		/**
		 * @param string $api_key
		 * 
		 * @return void
		 */
		public function __construct(string $api_key)
		{
			$this->TravelInformation = new TravelInformation($api_key);
		}
	}
?>