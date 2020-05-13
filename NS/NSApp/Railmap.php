<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * Railmap
	 * https://apiportal.ns.nl/docs/services/Spoorkaart-api
	 * 
	 * Author: JKCTech
	 * Date: 13-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class Railmap extends NSBaseSender
	{
		/**
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
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getRailmap()
		{
			return $this->requestGet("Spoorkaart-API/api/v1/spoorkaart");
		}

		/**
		 * Get global disruptions.
		 * Optional with user defined timeframe
		 *
		 * @param string $startDate (Optional) Datetime in RFC3339
		 * @param string $endDate (Optional) Datetime in RFC3339
		 * @param bool $actual (Optional) Show only current disruptions
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
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
		 * Either as json or geojson object.
		 *
		 * @param string $id Disruption ID
		 * @param string $extension Output type [.json|.geojson]
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruption(string $id, string $extension)
		{
			return $this->requestGet("Spoorkaart-API/api/v1/storingen/" . $id . $extension);
		}

		/**
		 * Get global disruptions with specific extension.
		 * Optional with user defined timeframe
		 *
		 * @param string $extension Output type [.json|.geojson]
		 * @param string $startDate (Optional) Datetime in RFC3339
		 * @param string $endDate (Optional) Datetime in RFC3339
		 * @param bool $actual (Optional) Show only current disruptions
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
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