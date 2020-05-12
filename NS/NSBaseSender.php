<?php
	/**
	 * NS (Nederlandse Spoorwegen)
	 * 
	 * Author: JKCTech
	 * Date: 11-07-2020
	 * 
	 */

	namespace nl\JKCTech\NS;

	Class NSBaseSender
	{
		const API = "https://gateway.apiportal.ns.nl/";

		private $api_key;

		/**
		 * @param string $api_key
		 * 
		 * @return void
		 */
		public function __construct (string $api_key)
		{
			$this->api_key = $api_key;
		}

		/**
		 * Send properly formed requests to the NS API.
		 *
		 * @param string $endpoint
		 * @param array $params
		 * 
		 * @return object
		 *
		 * @throws nl\JKCTech\NS\Exception\NSRequestException
		 */
		public function requestGet(string $endpoint, array $params = array())
		{
			$ch = curl_init();
			$url = self::API . $endpoint;

			if (is_array($params) && count($params) > 0)
				$url .= "?" . http_build_query($params);
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Ocp-Apim-Subscription-Key: ' . $this->api_key
			));

			$result = json_decode(curl_exec($ch));
			$info = curl_getinfo($ch);
			$error = curl_error($ch);

			curl_close($ch);

			if ($info['http_code'] !== 200)
			{
				// Field errors
				if (isset($result->fieldErrors) && count($result->fieldErrors) > 0)
				{
					$errors = array();
					foreach($result->fieldErrors as $e)
					{
						$errors[] = "[{$e->field}]: {$e->message}";
					}
					$error = implode(" - ", $errors);
				}

				// Generic errors
				else if (isset($result->errors) && count($result->errors) > 0)
				{
					$errors = array();
					foreach($result->errors as $e)
						$errors[] = $e->type . " -> " . $e->message;
					if(isset($error))
						$error .= " - " . implode("|", $errors);
					else
						$error = implode("|", $errors);
				}
				
				// Single error
				else if (isset($result->message))
					$error = $result->message;

				// Unknown error
				else
				{
					$error = "Unknown error has occured.";
				}

				throw new Exception\NSRequestException($error, $info['http_code']);
			}

			return $result;
		}
	}
?>