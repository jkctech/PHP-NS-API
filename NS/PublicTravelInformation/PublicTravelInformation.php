<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Public Travel Information endpoint section
	 * 
	 * @author JKCTech
	 */

	namespace JKCTech\NS;

	/**
	 * PublicTravelInformation
	 *
	 * @link https://apiportal.ns.nl/products/PublicNsApi
	 */
	Class PublicTravelInformation
	{
		/**
		 * Use your API key for this specific endpoint.
		 *
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