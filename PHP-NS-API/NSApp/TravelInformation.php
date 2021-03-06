<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Travel Information API
	 * 
	 * @author JKCTech
	 */

	namespace JKCTech\NS;

	/**
	 * TravelInformation
	 *
	 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/
	 */
	Class TravelInformation extends NSBaseSender
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
		 * Get all stations known in the NS network.
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getAllStations
		 *
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getAllStations()
		{
			return $this->requestGet("reisinformatie-api/api/v2/stations");
		}

		/**
		 * Get arrivals at a given station.
		 * 
		 * Either a station abbreviation or a UIC code is required. 
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getArrivals
		 *
		 * @param string $station Station by NS abbreviation/code (e.g. hdr or asd)
		 * @param string|integer $uicCode Station by UIC code (84xxxxx)
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * @param string|integer $maxJourneys (Optional) Number of departures or arrivals to return
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * @param string $source (Optional) Forces to use a certain source
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getArrivals(string $station = null, $uicCode = null, string $dateTime = null, $maxJourneys = null, string $lang = null, string $source = null)
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
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getCalamities
		 *
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getCalamities(string $lang = null)
		{
			$params = array_filter(array(
				"lang" => $lang
			));

			return $this->requestGet("reisinformatie-api/api/v1/calamities", $params);
		}

		/**
		 * Get departures at a given station.
		 * 
		 * Either a station abbreviation or a UIC code is required. 
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getDepartures
		 *
		 * @param string $station Station by NS abbreviation/code (e.g. hdr or asd)
		 * @param string|integer $uicCode Station by UIC code (84xxxxx)
		 * @param string $dateTime (Optional) Datetime in RFC3339
		 * @param string|integer $maxJourneys (Optional) Number of departures or arrivals to return
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * @param string $source (Optional) Forces to use a certain source
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getDepartures(string $station = null, $uicCode = null, string $dateTime = null, $maxJourneys = null, string $lang = null, string $source = null)
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
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getDisruptions
		 *
		 * @param bool $actual (Optional) Whether to only return disruptions within 2 hours of the request
		 * @param string $type (Optional) If not present, both will be returned [storing|werkzaamheid]
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
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
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getDisruption
		 * 
		 * @param string $id ID's can be found through getDisruptions()
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getDisruption(string $id)
		{
			return $this->requestGet("reisinformatie-api/api/v2/disruptions/" . $id);
		}

		/**
		 * Get exitside for the given parameters.
		 * 
		 * Result will either be LEFT, RIGHT or UNKNOWN.
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getExitSide
		 *
		 * @param string|integer $originUicCode Station by UIC code (84xxxxx)
		 * @param string|integer $uicCode Station by UIC code (84xxxxx)
		 * @param string|integer $track Tracknumber
		 * 
		 * @return object
		 *
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getExitSide($originUicCode, $uicCode, $track)
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
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getInternationalPrice
		 * 
		 * @param string|integer $fromStation The from station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string|integer $toStation The to station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $plannedFromTime Datetime in RFC3339
		 * 
		 * @return object
		 * 
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getInternationalPrice($fromStation, $toStation, string $plannedFromTime)
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
		 * 
		 * Provide EITHER a CTXRecon or a toStation AND fromStation.
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getPrice
		 * 
		 * @param string|integer $fromStation The from station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string|integer $toStation The to station stationcode, short name, middle name, long name, UIC code or varcode
		 * @param string $ctxRecon CTXRecon string
		 * @param string $plannedFromTime (Optional) Planned departure time in RFC3339
		 * @param string $plannedArrivalTime (Optional) Planned arrival time in RFC3339
		 * @param string|integer $travelClass (Optional) First or second class travel [1|2]
		 * @param string $travelType (Optional) [single|return]
		 * @param string|integer $adults (Optional) Number of adults to take into account
		 * @param string|integer $children (Optional) Number of children to take into account
		 * @param string|integer $routeId (Optional) Filter trip by routeId
		 * 
		 * @return object
		 * 
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getPrice($fromStation = null, $toStation = null, string $ctxRecon = null,
			string $plannedFromTime = null, string $plannedArrivalTime = null, $travelClass = null, string $travelType = null,
			$adults = null, $children = null, $routeId = null)
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
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getStationDisruption
		 *
		 * @param string|integer $code Stationcode or UICcode
		 * 
		 * @return object
		 * 
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getStationDisruption($code)
		{
			return $this->requestGet("reisinformatie-api/api/v2/disruptions/station/" . $code);
		}

		/**
		 * Plan a trip from station A to station B.
		 * 
		 * Due to the huge amount of possible parameters, an associative array with the parameters is used.
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getTrips
		 * 
		 * @param array $params
		 * 
		 * @return object
		 * 
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrips(array $params)
		{
			$params = array_filter($params);

			return $this->requestGet("reisinformatie-api/api/v3/trips", $params);
		}

		/**
		 * Get information about a specific trip.
		 *
		 * @link https://apiportal.ns.nl/docs/services/reisinformatie-api/operations/getTrip
		 * 
		 * @param string $ctxRecon CTXRecon string
		 * @param string $date (Optional) Datetime in RFC3339
		 * @param string $lang (Optional) Language to translate in, note that not all messages are translated [nl|en]
		 * @param string $product (Optional) Name / constant of product customer will use in travel, if omitted defaults to ROS
		 * @param string|integer $travelClass (Optional) First or second class travel [1|2]
		 * @param string $discount (Optional) Discount name / constant
		 * @param string $travelRequestType (Optional) With or without directions
		 * 
		 * @return object
		 * 
		 * @throws JKCTech\NS\Exception\NSRequestException
		 */
		public function getTrip(string $ctxRecon, string $date = null, string $lang = null, string $product = null,
			$travelClass = null, string $discount = null, string $travelRequestType = null)
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