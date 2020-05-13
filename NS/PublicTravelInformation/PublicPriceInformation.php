<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Public Price Information API
	 * 
	 * @author JKCTech
	 */

	namespace JKCTech\NS;

	/**
	 * PublicPriceInformation
	 *
	 * @link https://apiportal.ns.nl/docs/services/public-prijsinformatie-api/
	 */
	Class PublicPriceInformation extends NSBaseSender
	{
		/**
		 * Use your API key for this specific endpoint.
		 *
		 * @param string $api_key Your NS Public-Price-Information API Key
		 * 
		 * @return void
		 */
		public function __construct(string $api_key)
		{
			parent::__construct($api_key);
		}

		/**
		 * Get price for a ticket from station A to B.
		 *
		 * @link https://apiportal.ns.nl/docs/services/public-prijsinformatie-api/operations/getPrices
		 *
		 * @param string|integer $fromStation The from station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string|integer $toStation The to station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $date (RFC3339 yyyy-MM-dd)
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getPrices(mixed $fromStation, mixed $toStation, string $date = null)
		{
			$params = array(
				"fromStation" => $fromStation,
				"toStation" => $toStation
			);

			if (!empty($date))
				$params['date'] = $date;

			return $this->requestGet("public-prijsinformatie/prices", $params);
		}
	}
?>