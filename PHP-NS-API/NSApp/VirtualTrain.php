<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Virtual Train API
	 * 
	 * @author JKCTech
	 */

	namespace JKCTech\NS;

	/**
	 * VirtualTrain
	 *
	 * @link https://apiportal.ns.nl/docs/services/virtual-train-api
	 */
	Class VirtualTrain extends NSBaseSender
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
		 * Informations about all shortened trains.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getAll
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getAll_1
		 *
		 * @param bool $withCrowdForecast (Optional) Return extra crowd forecast data (Using endpoint V2)
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
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
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getImage
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getImageFromSubdirectory
		 *
		 * @param string $image Path of the image including it's extension and optional subdirectory
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrainImage(string $image)
		{
			return $this->requestGet("virtual-train-api/api/v1/images/" . $image);
		}

		/**
		 * Get a VERY BIG list of all stops.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getStops
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getAllStops()
		{
			return $this->requestGet("virtual-train-api/api/v1/stop");
		}

		/**
		 * Get information about a specific stop.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getStop
		 *
		 * @param string $stopCode Specific stopcode
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getStop(string $stopCode)
		{
			return $this->requestGet("virtual-train-api/api/v1/stop/" . $stopCode);
		}

		/**
		 * Get information about a ridenumber being shortened at a specific station.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getTreinInfo
		 *
		 * @param string|integer $ridenumber Ridenumber
		 * @param string $station Station abbreviation code
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getShortenedTrain($ridenumber, string $station)
		{
			return $this->requestGet(sprintf("virtual-train-api/api/v1/ingekort/%s/%s", $ridenumber, $station));
		}

		/**
		 * Get crowd forecast at a specific ridenumber.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getTreinInfo_1
		 *
		 * @param string|integer $ridenumber Ridenumber
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getCrowdForecast($ridenumber)
		{
			return $this->requestGet("virtual-train-api/api/v1/prognose/" . $ridenumber);
		}

		/**
		 * Convert a materialnumber to a ridenumber.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getTreinInformatie
		 *
		 * @param string|integer $materialnumber Materialnumber
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function materialnumberToRidenumber($materialnumber)
		{
			return $this->requestGet("virtual-train-api/api/v1/ritnummer/" . $materialnumber);
		}

		/**
		 * Get information about a specific train.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getTreinInformatie_1
		 *
		 * @param string|integer $ridenumber
		 * @param string $features (Optional) Comma seperated list of features [zitplaats|platformitems|cta|drukte]
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrainInformation($ridenumber, string $features = null, string $dateTime = null)
		{
			$params = array_filter(array(
				"features" => $features,
				"dateTime" => $dateTime
			));

			return $this->requestGet("virtual-train-api/api/v1/trein/" . $ridenumber, $params);
		}

		/**
		 * Get all trains with optional search parameters.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getTreinInformatie_2
		 *
		 * @param string $ids (Optional) Comma seperated list of train id's, note that all of the following parameters only work in conjuction with the id parameter
		 * @param string $stations (Optional) Comma seperated list of Station codes
		 * @param string $features (Optional) Comma seperated list of features [zitplaats|platformitems|cta|drukte|druktev2]
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * @param bool $all (Optional) Get information about all the stations
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
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
		 * Get traindata of train at specific station.
		 *
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getTreinInformatie_3
		 *
		 * @param $ridenumber Ridenumber
		 * @param string $station Station abbreviation code
		 * @param string $features (Optional) Comma seperated list of features [zitplaats|platformitems|cta|drukte]
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrainAtStation($ridenumber, string $station, string $features = null, string $dateTime = null)
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
		 * @link https://apiportal.ns.nl/docs/services/virtual-train-api/operations/getVehicles
		 *
		 * @param string|float $lat (Optional) Latitude
		 * @param string|float $lng (Optional) Longitude
		 * @param string|int $radius (Optional) Radius in meters
		 * @param string|int $limit (Optional) Maximum amount to return
		 * @param string $features (Optional) Comma seperated list of types of vehicles to return [bus|trein|materieel]
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getVehicles($lat = null, $lng = null, $radius = null, $limit = null, string $features = null)
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