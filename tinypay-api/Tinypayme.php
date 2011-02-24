<?php
require_once("mashapebase/mashapeClient.php");

class Tinypayme
{
	private $apiKey;
	function __construct($apiKey)
	{
		$this->apiKey=$apiKey;
	}

	public function contactUser($access_token, $user_id, $name, $email, $message, $subject = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "user_id" => $user_id,
		                    "name" => $name,
		                    "email" => $email,
		                    "message" => $message,
		                    "subject" => $subject);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::POST, "contactUser", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function createItem($access_token, $title, $currency, $price, $description, $tags = null, $quantity = null, $require_shipment_address = null, $shipment_countries = null, $shipment_costs = null, $shipment_costs_per_item = null, $geo_latitude = null, $geo_longitude = null, $image_tokens = null, $file_token = null, $video_url = null, $charity_id = null, $charity_percentage = null, $language = null, $country = null, $marketplace_category_id = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "title" => $title,
		                    "currency" => $currency,
		                    "price" => $price,
		                    "description" => $description,
		                    "tags" => $tags,
		                    "quantity" => $quantity,
		                    "require_shipment_address" => $require_shipment_address,
		                    "shipment_countries" => $shipment_countries,
		                    "shipment_costs" => $shipment_costs,
		                    "shipment_costs_per_item" => $shipment_costs_per_item,
		                    "geo_latitude" => $geo_latitude,
		                    "geo_longitude" => $geo_longitude,
		                    "image_tokens" => $image_tokens,
		                    "file_token" => $file_token,
		                    "video_url" => $video_url,
		                    "charity_id" => $charity_id,
		                    "charity_percentage" => $charity_percentage,
		                    "language" => $language,
		                    "country" => $country,
		                    "marketplace_category_id" => $marketplace_category_id);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::POST, "createItem", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function createMarketplace($access_token, $title, $description, $sales_fee, $tags = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "title" => $title,
		                    "description" => $description,
		                    "sales_fee" => $sales_fee,
		                    "tags" => $tags);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::POST, "createMarketplace", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function createOrder($item_id, $name, $email, $address_line_1 = null, $address_line_2 = null, $postal_zip_code = null, $state_province = null, $city = null, $country = null, $comment = null, $quantity = null, $cancel_url = null, $return_url = null, $marketplace_id = null)
	{
		$parameters = array("item_id" => $item_id,
		                    "name" => $name,
		                    "email" => $email,
		                    "address_line_1" => $address_line_1,
		                    "address_line_2" => $address_line_2,
		                    "postal_zip_code" => $postal_zip_code,
		                    "state_province" => $state_province,
		                    "city" => $city,
		                    "country" => $country,
		                    "comment" => $comment,
		                    "quantity" => $quantity,
		                    "cancel_url" => $cancel_url,
		                    "return_url" => $return_url,
		                    "marketplace_id" => $marketplace_id);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::POST, "createOrder", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function deleteItem($access_token, $item_id)
	{
		$parameters = array("access_token" => $access_token,
		                    "item_id" => $item_id);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::DELETE, "deleteItem", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getCharities()
	{
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getCharities", TokenUtil::requestToken($this->apiKey), null);
		return $response;
	}

	public function getCountries()
	{
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getCountries", TokenUtil::requestToken($this->apiKey), null);
		return $response;
	}

	public function getCountriesByRegion($region)
	{
		$parameters = array("region" => $region);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getCountriesByRegion", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getCurrencies()
	{
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getCurrencies", TokenUtil::requestToken($this->apiKey), null);
		return $response;
	}

	public function getItem($item_id, $select = null, $not_select = null)
	{
		$parameters = array("item_id" => $item_id,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getItem", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getLanguages()
	{
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getLanguages", TokenUtil::requestToken($this->apiKey), null);
		return $response;
	}

	public function getMarketplace($marketplace_id, $select = null, $not_select = null)
	{
		$parameters = array("marketplace_id" => $marketplace_id,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMarketplace", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getMarketplaceCategorySearch($marketplace_id, $category_id, $q = null, $items = null, $start = null, $file = null, $charity = null, $image = null, $video = null, $shipment = null, $min_price = null, $max_price = null, $country = null, $currency = null, $lang = null, $tag = null, $tags = null, $sort_by = null, $sort_dir = null, $select = null, $not_select = null)
	{
		$parameters = array("marketplace_id" => $marketplace_id,
		                    "category_id" => $category_id,
		                    "q" => $q,
		                    "items" => $items,
		                    "start" => $start,
		                    "file" => $file,
		                    "charity" => $charity,
		                    "image" => $image,
		                    "video" => $video,
		                    "shipment" => $shipment,
		                    "min_price" => $min_price,
		                    "max_price" => $max_price,
		                    "country" => $country,
		                    "currency" => $currency,
		                    "lang" => $lang,
		                    "tag" => $tag,
		                    "tags" => $tags,
		                    "sort_by" => $sort_by,
		                    "sort_dir" => $sort_dir,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMarketplaceCategorySearch", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getMarketplaceSearch($marketplace_id, $q = null, $items = null, $start = null, $file = null, $charity = null, $image = null, $video = null, $shipment = null, $min_price = null, $max_price = null, $country = null, $currency = null, $lang = null, $tag = null, $tags = null, $sort_by = null, $sort_dir = null, $select = null, $not_select = null)
	{
		$parameters = array("marketplace_id" => $marketplace_id,
		                    "q" => $q,
		                    "items" => $items,
		                    "start" => $start,
		                    "file" => $file,
		                    "charity" => $charity,
		                    "image" => $image,
		                    "video" => $video,
		                    "shipment" => $shipment,
		                    "min_price" => $min_price,
		                    "max_price" => $max_price,
		                    "country" => $country,
		                    "currency" => $currency,
		                    "lang" => $lang,
		                    "tag" => $tag,
		                    "tags" => $tags,
		                    "sort_by" => $sort_by,
		                    "sort_dir" => $sort_dir,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMarketplaceSearch", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getMyAccessToken()
	{
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMyAccessToken", TokenUtil::requestToken($this->apiKey), null);
		return $response;
	}

	public function getMyItems($access_token, $select = null, $not_select = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMyItems", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getMyMarketplaces($access_token, $select = null, $not_select = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMyMarketplaces", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getMyOrders($access_token, $select = null, $not_select = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMyOrders", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getMyProfile($access_token, $select = null, $not_select = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getMyProfile", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getOAuthAccessToken($access_token, $code)
	{
		$parameters = array("access_token" => $access_token,
		                    "code" => $code);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getOAuthAccessToken", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getOAuthPermission($marketplace_id, $redirect_uri, $scope = null, $state = null)
	{
		$parameters = array("marketplace_id" => $marketplace_id,
		                    "redirect_uri" => $redirect_uri,
		                    "scope" => $scope,
		                    "state" => $state);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getOAuthPermission", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getOrderStatus($access_token, $order_id)
	{
		$parameters = array("access_token" => $access_token,
		                    "order_id" => $order_id);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getOrderStatus", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getRegions()
	{
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getRegions", TokenUtil::requestToken($this->apiKey), null);
		return $response;
	}

	public function getSearch($q = null, $items = null, $start = null, $file = null, $charity = null, $image = null, $video = null, $shipment = null, $min_price = null, $max_price = null, $country = null, $currency = null, $lang = null, $tag = null, $tags = null, $sort_by = null, $sort_dir = null, $select = null, $not_select = null)
	{
		$parameters = array("q" => $q,
		                    "items" => $items,
		                    "start" => $start,
		                    "file" => $file,
		                    "charity" => $charity,
		                    "image" => $image,
		                    "video" => $video,
		                    "shipment" => $shipment,
		                    "min_price" => $min_price,
		                    "max_price" => $max_price,
		                    "country" => $country,
		                    "currency" => $currency,
		                    "lang" => $lang,
		                    "tag" => $tag,
		                    "tags" => $tags,
		                    "sort_by" => $sort_by,
		                    "sort_dir" => $sort_dir,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getSearch", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getShipmentCountries($item_id)
	{
		$parameters = array("item_id" => $item_id);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getShipmentCountries", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getUserItems($user_id, $select = null, $not_select = null)
	{
		$parameters = array("user_id" => $user_id,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getUserItems", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function getUserProfile($user_id, $select = null, $not_select = null)
	{
		$parameters = array("user_id" => $user_id,
		                    "select" => $select,
		                    "not_select" => $not_select);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::GET, "getUserProfile", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function updateItem($access_token, $item_id, $title = null, $currency = null, $price = null, $description = null, $tags = null, $quantity = null, $require_shipment_address = null, $shipment_countries = null, $shipment_costs = null, $shipment_costs_per_item = null, $geo_latitude = null, $geo_longitude = null, $image_tokens = null, $file_token = null, $video_url = null, $charity_id = null, $charity_percentage = null, $language = null, $country = null)
	{
		$parameters = array("access_token" => $access_token,
		                    "item_id" => $item_id,
		                    "title" => $title,
		                    "currency" => $currency,
		                    "price" => $price,
		                    "description" => $description,
		                    "tags" => $tags,
		                    "quantity" => $quantity,
		                    "require_shipment_address" => $require_shipment_address,
		                    "shipment_countries" => $shipment_countries,
		                    "shipment_costs" => $shipment_costs,
		                    "shipment_costs_per_item" => $shipment_costs_per_item,
		                    "geo_latitude" => $geo_latitude,
		                    "geo_longitude" => $geo_longitude,
		                    "image_tokens" => $image_tokens,
		                    "file_token" => $file_token,
		                    "video_url" => $video_url,
		                    "charity_id" => $charity_id,
		                    "charity_percentage" => $charity_percentage,
		                    "language" => $language,
		                    "country" => $country);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::PUT, "updateItem", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function uploadFile($access_token)
	{
		$parameters = array("access_token" => $access_token);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::POST, "uploadFile", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}

	public function uploadImage($access_token)
	{
		$parameters = array("access_token" => $access_token);
		$response = HttpClient::call("https://tinypay.me/mashape/", HttpMethod::POST, "uploadImage", TokenUtil::requestToken($this->apiKey), $parameters);
		return $response;
	}
}
?>