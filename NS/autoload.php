<?php
	/**
	 * Nederlandse Spoorwegen (NS) API
	 *
	 * This file is inteded to work with the NS client API providing various insights in the Dutch (and international) railways.
	 * https://github.com/jkctech/PHP-NS-API
	 * 
	 * Autoloader
	 * 
	 * @author JKCTech
	 */

	// Exceptions
	require_once(__DIR__ . "/Exceptions/NSRequestException.php");

	// BaseSender
	require_once(__DIR__ . "/NSBaseSender.php");

	// PublicTravelInformation
	require_once(__DIR__ . "/PublicTravelInformation/PublicTravelInformation.php");
	require_once(__DIR__ . "/PublicTravelInformation/PublicPriceInformation.php");

	// NSApp
	require_once(__DIR__ . "/NSApp/NSApp.php");
	require_once(__DIR__ . "/NSApp/Places.php");
	require_once(__DIR__ . "/NSApp/TravelInformation.php");
	require_once(__DIR__ . "/NSApp/Railmap.php");
	require_once(__DIR__ . "/NSApp/VirtualTrain.php");
?>