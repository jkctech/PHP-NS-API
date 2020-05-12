<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * PublicTravelInformation
	 * https://apiportal.ns.nl/products/PublicNsApi
	 * 
	 * Author: JKCTech
	 * Date: 12-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class PublicTravelInformation
	{
		/**
		 * @param string $api_key
		 * 
		 * @return void
		 */
		public function __construct(string $api_key)
		{
			$this->PublicPriceInformation = new PublicPriceInformation($api_key);
		}
	}
?>