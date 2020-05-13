<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * VirtualTrain
	 * https://apiportal.ns.nl/docs/services/virtual-train-api
	 * 
	 * Author: JKCTech
	 * Date: 13-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class VirtualTrain extends NSBaseSender
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
		 * Informations about all shortened trains.
		 *
		 * @param bool $withCrowdForecast (Optional) Return extra crowd forecast data (Using endpoint V2)
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getAllShortenedTrains(bool $withCrowdForecast = false)
		{
			if ($withCrowdForecast)
				return $this->requestGet("virtual-train-api/api/v2/ingekort");
			else
				return $this->requestGet("virtual-train-api/api/v1/ingekort");
		}

		/**
		 * Get train image.
		 *
		 * @param string $image Path of the image including it's extension and optional subdirectory
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrainImage(string $image)
		{
			return $this->requestGet("virtual-train-api/api/v1/images/" . $image);
		}

		/**
		 * Get a VERY BIG list of all stops.
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getAllStops()
		{
			return $this->requestGet("virtual-train-api/api/v1/stop");
		}

		/**
		 * Get information about a specific stop.
		 *
		 * @param string $stopCode Specific stopcode
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getStop(string $stopCode)
		{
			return $this->requestGet("virtual-train-api/api/v1/stop/" . $stopCode);
		}

		/**
		 * Get information about a ridenumber being shortened at a specific station.
		 *
		 * @param string|integer $ridenumber Ridenumber
		 * @param string $station Station abbreviation code
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getShortenedTrain(mixed $ridenumber, string $station)
		{
			return $this->requestGet(sprintf("virtual-train-api/api/v1/ingekort/%s/%s", $ridenumber, $station));
		}

		/**
		 * Get crowd forecast at a specific ridenumber.
		 *
		 * @param string|integer $ridenumber Ridenumber
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getCrowdForecast(mixed $ridenumber)
		{
			return $this->requestGet("virtual-train-api/api/v1/prognose/" . $ridenumber);
		}

		/**
		 * Convert a materialnumber to a ridenumber.
		 *
		 * @param string|integer $materialnumber Materialnumber
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function materialnumberToRidenumber(mixed $materialnumber)
		{
			return $this->requestGet("virtual-train-api/api/v1/ritnummer/" . $materialnumber);
		}

		/**
		 * @param string|integer $ridenumber
		 * @param string $features (Optional) Comma seperated list of features [zitplaats|platformitems|cta|drukte]
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrainInformation(mixed $ridenumber, string $features = null, string $dateTime = null)
		{
			$params = array_filter(array(
				"features" => $features,
				"dateTime" => $dateTime
			));

			return $this->requestGet("virtual-train-api/api/v1/trein/" . $ridenumber, $params);
		}

		/**
		 * @param string $ids (Optional) Comma seperated list of train id's, note that all of the following parameters only work in conjuction with the id parameter
		 * @param string $stations (Optional) Comma seperated list of Station codes
		 * @param string $features (Optional) Comma seperated list of features [zitplaats|platformitems|cta|drukte|druktev2]
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * @param bool $all (Optional) Get information about all the stations
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getAllTrains(string $ids = null, string $stations = null, string $features = null, string $dateTime = null, bool $all = null)
		{
			$params = array_filter(array(
				"ids" => $ids,
				"stations" => $stations,
				"features" => $features,
				"dateTime" => $dateTime,
				"all" => $all ? "true" : "false"
			));

			return $this->requestGet("virtual-train-api/api/v1/trein", $params);
		}

		/**
		 * @param mixed $ridenumber Ridenumber
		 * @param string $station Station abbreviation code
		 * @param string $features (Optional) Comma seperated list of features [zitplaats|platformitems|cta|drukte]
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrainAtStation(mixed $ridenumber, string $station, string $features = null, string $dateTime = null)
		{
			$params = array_filter(array(
				"features" => $features,
				"dateTime" => $dateTime
			));

			return $this->requestGet(sprintf("virtual-train-api/api/v1/trein/%s/%s", $ridenumber, $station), $params);
		}

		/**
		 * Get information about all vehicles.
		 *
		 * @param string|float $lat (Optional) Latitude
		 * @param string|float $lng (Optional) Longitude
		 * @param string|int $radius (Optional) Radius in meters
		 * @param string|int $limit (Optional) Maximum amount to return
		 * @param string $features (Optional) Comma seperated list of types of vehicles to return [bus|trein|materieel]
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getVehicles(mixed $lat = null, mixed $lng = null, mixed $radius = null, mixed $limit = null, string $features = null)
		{
			$params = array_filter(array(
				"lat" => $lat,
				"lng" => $lng,
				"radius" => $radius,
				"limit" => $limit,
				"features" => $features
			));

			return $this->requestGet("irtual-train-api/api/vehicle", $params);
		}
	}
?>