<?php

class	ApiRequest {
  var	$status; // bool, success or error?
  var	$raw_response; // string, raw text response received
  var	$response; // array
  var	$request; // string, the request that has been sent
  function __construct($url /* string*/, $parameters = array()/* array string => string */, $type = 'GET') {
    $url .= '/?';
    foreach ($parameters as $k => $v)
      $url .= $k.'='.$v.'&';
    $this->request = $url;
    $this->raw_response = file_get_contents($this->request);
    $this->response = json_decode($this->raw_response);
  }
  
}


function	get_cities() {
  }
