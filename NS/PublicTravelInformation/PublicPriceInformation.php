<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * PublicPriceInformation
	 * https://apiportal.ns.nl/docs/services/public-prijsinformatie-api/
	 * 
	 * Author: JKCTech
	 * Date: 11-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class PublicPriceInformation extends NSBaseSender
	{
		/**
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
		 * @param string $from_station The from station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $to_station The to station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $date (RFC3339 yyyy-MM-dd)
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getPrices(string $fromStation, string $toStation, string $date = null)
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