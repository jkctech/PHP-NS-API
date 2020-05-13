<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * Places
	 * https://apiportal.ns.nl/docs/services/Places-API/
	 * 
	 * Author: JKCTech
	 * Date: 13-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class Places extends NSBaseSender
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
		 * The syntax and meaning of this endpoint are unknown.
		 * Custom parameters can be set.
		 *
		 * @param array $params (Optional) Associative array with custom paramters
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getIncorrectlyFilledLocations(array $params = array())
		{
			$params = array_filter($params);

			return $this->requestGet("places-api/v2/places/incorrect", $params);
		}

		/**
		 * Return a list of places according to the given parameters.
		 * Due to the huge amount of possible parameters, an associative array with the parameters is used.
		 * 
		 * @param array $params
		 * 
		 * @return object
		 * 
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function listPlaces(array $params)
		{
			$params = array_filter($params);

			return $this->requestGet("places-api/v2/places", $params);
		}

		/**
		 * The syntax and meaning of this endpoint are unknown.
		 * Custom parameters can be set.
		 *
		 * @param array $params (Optional) Associative array with custom paramters
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function mailUnreliable(array $params = array())
		{
			$params = array_filter($params);

			return $this->requestGet("places-api/v2/places/ovfiets/mailunreliable", $params);
		}

		/**
		 * Perform an autosuggest.
		 *
		 * @param string $q Full text search string
		 * @param string $type (Optional) Comma seperated list of place types
		 * @param string $session_token (Optional) A session token, used to group the query and selection phases of a user autocomplete search into a discrete session for billing purposes
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function autoSuggest(string $q, string $type = null, string $session_token = null)
		{
			$params = array_filter(array(
				"q" => $q,
				"type" => $type,
				"session_token" => $session_token
			));

			return $this->requestGet("places-api/v2/autosuggest", $params);
		}

		
		/**
		 * Get a specific autosuggest resource.
		 *
		 * @param string $type
		 * @param string $id
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function autoSuggestSpecific(string $type, string $id)
		{
			return $this->requestGet(sprintf("places-api/v2/autosuggest/%s/%s", $type, $id));
		}

		/**
		 * Get information about ovFiets (Public bikes) locations and availability.
		 *
		 * @param string $station_code (Optional) Station abbreviation code to limit the information
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function ovFiets(string $station_code = null)
		{
			$params = array_filter(array(
				"station_code" => $station_code
			));

			return $this->requestGet("places-api/v2/ovfiets", $params);
		}

		/**
		 * Get a specific place resource.
		 *
		 * @param string $type Type of place
		 * @param string $id ID of place
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getPlace(string $type, string $id, string $lang = null)
		{
			$params = array_filter(array(
				"lang" => $lang
			));

			return $this->requestGet(sprintf("places-api/v2/places/%s/%s", $type, $id), $params);
		}

		/**
		 * Get place images.
		 *
		 * @param string $type Type of place
		 * @param string $resource Resource you are trying to access
		 * @param float $blur (Optional) Blur the image
		 * 
		 * @return void
		 */
		public function getPlaceImage(string $type, string $resource, float $blur = null)
		{
			$params = array_filter(array(
				"blur" => $blur
			));

			return $this->requestGet(sprintf("places-api/v2/places/%s/resource/%s", $type, $resource), $params);
		}
	}
?>