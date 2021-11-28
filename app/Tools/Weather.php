<?php

namespace App\Tools;

class Weather{

  private $lat;
  private $lng;

  public function __construct($lat, $lng){
    $this->lat = $lat;
    $this->lng = $lng;
  }

  public function getWeather(){
    $url = "https://api.openweathermap.org/data/2.5/weather?lat=" . $this->lat . "&lon=" . $this->lng . "&appid=" . env('APP_WEATHER');
    $getData = file_get_contents($url);
    return $getData;
  }


}
