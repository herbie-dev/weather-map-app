<?php
namespace App\Http\Controllers\Weather;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Weather;

class WeatherController extends Controller
{
  public function index(){
    return view('home');
  }


  public function weather(Request $request){

    $weather = new Weather($request->lat,$request->longit);
  
    return response($weather->getWeather());

  }

}
