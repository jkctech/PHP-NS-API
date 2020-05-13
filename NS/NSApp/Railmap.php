<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Railmap API
	 * 
	 * @author JKCTech
	 */

	namespace JKCTech\NS;

	/**
	 * Railmap
	 *
	 * @link https://apiportal.ns.nl/docs/services/Spoorkaart-api
	 */
	Class Railmap extends NSBaseSender
	{
		/**
		 * Use your API key for this specific endpoint.
		 *
		 * @param string $api_key Your NS-App API Key
		 * 
		 * @return void
		 */
		public function __construct(string $api_key)
		{
			parent::__construct($api_key);
		}

		/**
		 * Get global railway map.
		 *
		 * @link https://apiportal.ns.nl/docs/services/Spoorkaart-api/operations/getSpoorkaart
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getRailmap()
		{
			return $this->requestGet("Spoorkaart-API/api/v1/spoorkaart");
		}

		/**
		 * Get global disruptions.
		 * 
		 * Optional with user defined timeframe
		 *
		 * @link https://apiportal.ns.nl/docs/services/Spoorkaart-api/operations/getStoringen
		 *
		 * @param string $startDate (Optional) Datetime in RFC3339
		 * @param string $endDate (Optional) Datetime in RFC3339
		 * @param bool $actual (Optional) Show only current disruptions
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruptions(string $startDate = null, string $endDate = null, bool $actual = null)
		{
			$params = array_filter(array(
				"startDate" => $startDate,
				"endDate" => $endDate,
				"actual" => $actual ? "true" : "false"
			));

			return $this->requestGet("Spoorkaart-API/api/v1/storingen", $params);
		}

		/**
		 * Get specific disruption.
		 * 
		 * Either as json or geojson object
		 *
		 * @link https://apiportal.ns.nl/docs/services/Spoorkaart-api/operations/getStoring
		 *
		 * @param string $id Disruption ID
		 * @param string $extension Output type [.json|.geojson]
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruption(string $id, string $extension)
		{
			return $this->requestGet("Spoorkaart-API/api/v1/storingen/" . $id . $extension);
		}

		/**
		 * Get global disruptions with specific extension.
		 * 
		 * Optional with user defined timeframe
		 *
		 * @link https://apiportal.ns.nl/docs/services/Spoorkaart-api/operations/getStoringenWithExtension
		 *
		 * @param string $extension Output type [.json|.geojson]
		 * @param string $startDate (Optional) Datetime in RFC3339
		 * @param string $endDate (Optional) Datetime in RFC3339
		 * @param bool $actual (Optional) Show only current disruptions
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruptionsWithExtension(string $extension, string $startDate = null, string $endDate = null, bool $actual = null)
		{
			$params = array_filter(array(
				"startDate" => $startDate,
				"endDate" => $endDate,
				"actual" => $actual ? "true" : "false"
			));

			return $this->requestGet("Spoorkaart-API/api/v1/storingen" . $extension, $params);
		}

		/**
		 * Get trainroute.
		 *
		 * @link https://apiportal.ns.nl/docs/services/Spoorkaart-api/operations/getTraject
		 * 
		 * @param string $extension Output type [.json|.geojson]
		 * @param string $stations (Optional) Comma seperated list of stations
		 * 
		 * @return void
		 */
		public function getRoute(string $extension, string $stations = null)
		{
			$params = array_filter(array(
				"stations" => $stations
			));

			return $this->requestGet("Spoorkaart-API/api/v1/traject" . $extension, $params);
		}
	}
?>