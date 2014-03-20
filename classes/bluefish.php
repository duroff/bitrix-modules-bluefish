<?php

class bluefish {
      
    var $username;
    var $api_key;
    var $url;
    
    function __construct() {
        $this->username = COption::GetOptionString('bluefish', 'username');
	$this->api_key = COption::GetOptionString('bluefish', 'api_key'); 
        $this->url = COption::GetOptionString('bluefish', 'url', 'http://bluefish.ru/api/');
    }
    
    private function Request($request) {
        $timestamp = time(); 
        $api_salt = substr($timestamp, 0, 7); 
	$hash = hash_hmac('sha256', $this->username . $this->api_key . $api_salt . $timestamp, 'FZiQ7hYLeS2kd3w5L9IgFARpy6kUJk4x1vEc');
	$request_url = $this->url . $request . "&username=" . $this->username . "&api_salt=" . $api_salt . "&request_timestamp=" . $timestamp . "&request_token=" . $hash;
        $requests = file_get_contents($request_url); 
        return json_decode($requests, true); 
    }


    public function GetAll($limit = 5000) {
        $cars = $this->Request("cars?limit=" . $limit);
        return $cars;
    }

     
}