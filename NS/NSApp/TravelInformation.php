<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 *
	 * TravelInformation
	 * https://apiportal.ns.nl/docs/services/reisinformatie-api/
	 * 
	 * Author: JKCTech
	 * Date: 12-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class TravelInformation extends NSBaseSender
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
		 * Get all stations known in the NS network.
		 *
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getAllStations()
		{
			return $this->requestGet("reisinformatie-api/api/v2/stations");
		}

		/**
		 * Get arrivals at a given station.
		 * Either a station abbreviation or a UIC code is required. 
		 *
		 * @param string $station Station by NS abbreviation/code (e.g. hdr or asd)
		 * @param string $uicCode Station by UIC code (84xxxxx)
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * @param integer $maxJourneys (Optional) Number of departures or arrivals to return
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * @param string $source (Optional) Forces to use a certain source
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getArrivals(string $station = null, string $uicCode = null, string $dateTime = null, int $maxJourneys = null, string $lang = null, string $source = null)
		{
			$params = array_filter(array(
				"station" => $station,
				"uicCode" => $uicCode,
				"dateTime" => $dateTime,
				"maxJourneys" => $maxJourneys,
				"lang" => $lang,
				"source" => $source
			));

			return $this->requestGet("reisinformatie-api/api/v2/arrivals", $params);
		}

		/**
		 * Get list of global calamities.
		 *
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getCalamities(string $lang = nulll)
		{
			$params = array_filter(array(
				"lang" => $lang
			));

			return $this->requestGet("reisinformatie-api/api/v1/calamities", $params);
		}

		/**
		 * Get departures at a given station.
		 * Either a station abbreviation or a UIC code is required. 
		 *
		 * @param string $station Station by NS abbreviation/code (e.g. hdr or asd)
		 * @param string $uicCode Station by UIC code (84xxxxx)
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * @param integer $maxJourneys (Optional) Number of departures or arrivals to return
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * @param string $source (Optional) Forces to use a certain source
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getDepartures(string $station = null, string $uicCode = null, string $dateTime = null, int $maxJourneys = null, string $lang = null, string $source = null)
		{
			$params = array_filter(array(
				"station" => $station,
				"uicCode" => $uicCode,
				"dateTime" => $dateTime,
				"maxJourneys" => $maxJourneys,
				"lang" => $lang,
				"source" => $source
			));

			return $this->requestGet("reisinformatie-api/api/v2/departures", $params);
		}
		
		/**
		 * Get global disruptions.
		 *
		 * @param bool $actual (Optional) Whether to only return disruptions within 2 hours of the request
		 * @param string $type (Optional) If not present, both will be returned [storing|werkzaamheid]
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruptions(bool $actual = null, string $type = null, string $lang = null)
		{
			$params = array_filter(array(
				"actual" => $actual ? "true" : "false",
				"type" => $type,
				"lang" => $lang
			));

			return $this->requestGet("reisinformatie-api/api/v2/disruptions", $params);
		}

		/**
		 * Get specific disruption by ID.
		 * 
		 * @param string $id ID's can be found through getDisruptions()
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruption(string $id)
		{
			return $this->requestGet("reisinformatie-api/api/v2/disruptions/" . $id);
		}

		/**
		 * Get exitside for the given parameters.
		 * Result will either be LEFT, RIGHT or UNKNOWN.
		 *
		 * @param string $originUicCode Station by UIC code (84xxxxx)
		 * @param string $uicCode Station by UIC code (84xxxxx)
		 * @param string $track Tracknumber
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getExitSide(string $originUicCode, string $uicCode, string $track)
		{
			$params = array_filter(array(
				"originUicCode" => $originUicCode,
				"uicCode" => $uicCode,
				"track" => $track
			));

			return $this->requestGet("reisinformatie-api/api/v1/exitside", $params);
		}

		/**
		 * Get international pricing from station A to station B.
		 * 
		 * @param string $fromStation The from station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $toStation The to station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $plannedFromTime Datetime in RFC3339
		 * 
		 * @return object
		 * 
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getInternationalPrice(string $fromStation, string $toStation, string $plannedFromTime)
		{
			$params = array_filter(array(
				"fromStation" => $fromStation,
				"toStation" => $toStation,
				"plannedFromTime" => $plannedFromTime
			));

			return $this->requestGet("reisinformatie-api/api/v2/price/international", $params);
		}

		/**
		 * Get pricing from station A to station B.
		 * Provide EITHER a CTXRecon or a toStation AND fromStation.
		 * 
		 * @param string $fromStation The from station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $toStation The to station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $ctxRecon CTXRecon string
		 * @param string $plannedFromTime (Optional) Planned departure time in RFC3339
		 * @param string $plannedArrivalTime (Optional) Planned arrival time in RFC3339
		 * @param integer $travelClass (Optional) First or second class travel [1|2]
		 * @param string $travelType (Optional) [single|return]
		 * @param integer $adults (Optional) Number of adults to take into account
		 * @param integer $children (Optional) Number of children to take into account
		 * @param string $routeId (Optional) Filter trip by routeId
		 * 
		 * @return object
		 * 
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getPrice(string $fromStation = null, string $toStation = null, string $ctxRecon = null,
			string $plannedFromTime = null, string $plannedArrivalTime = null, int $travelClass = null, string $travelType = null,
			int $adults = null, int $children = null, string $routeId = null)
		{
			$params = array_filter(array(
				"fromStation" => $fromStation,
				"toStation" => $toStation,
				"ctxRecon" => $ctxRecon,
				"plannedFromTime" => $plannedFromTime,
				"plannedArrivalTime" => $plannedArrivalTime,
				"travelClass" => $travelClass,
				"travelType" => $travelType,
				"adults" => $adults,
				"children" => $children,
				"routeId" => $routeId
			));

			return $this->requestGet("reisinformatie-api/api/v2/price", $params);
		}

		/**
		 * Get disruptions at a specific station.
		 *
		 * @param string $code Stationcode or UICcode
		 * 
		 * @return object
		 * 
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getStationDisruption(string $code)
		{
			return $this->requestGet("reisinformatie-api/api/v2/disruptions/station/" . $code);
		}

		/**
		 * Plan a trip from station A to station B.
		 * Due to the huge amount of possible parameters, an associative array with the parameters is used.
		 * 
		 * @param array $params
		 * 
		 * @return object
		 * 
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrips(array $params)
		{
			$params = array_filter($params);

			return $this->requestGet("reisinformatie-api/api/v3/trips", $params);
		}

		/**
		 * Get information about a specific trip.
		 * 
		 * @param string $ctxRecon CTXRecon string
		 * @param string $date (Optional) Datetime in RFC3339
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * @param string $product (Optional) Name / constant of product customer will use in travel, if omitted defaults to ROS
		 * @param string $travelClass (Optional) First or second class travel [1|2]
		 * @param string $discount (Optional) Discount name / constant
		 * @param string $travelRequestType (Optional) With or without directions
		 * 
		 * @return object
		 * 
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrip(string $ctxRecon, string $date = null, string $lang = null, string $product = null,
			string $travelClass = null, string $discount = null, string $travelRequestType = null)
		{
			$params = array_filter(array(
				"ctxRecon" => $ctxRecon,
				"date" => $date,
				"lang" => $lang,
				"product" => $product,
				"travelClass" => $travelClass,
				"discount" => $discount,
				"travelRequestType" => $travelRequestType
			));

			return $this->requestGet("reisinformatie-api/api/v3/trips/trip", $params);
		}
	}
?>