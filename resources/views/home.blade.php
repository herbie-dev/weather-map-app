@extends('layout.app')
@section('content')
<div class="container-fluid">
  <br>
  <center><h3>Click location to check weather</h3></center>
  <div class="fade-in">
    <div id="map" class="col-12" style="width:100%;height:400px;"></div>
  </div>
</div>

@endsection
@push('scripts')
  <script>


  var marker;
  var infowindow;
  var geocoder;
  var mapCanvas = document.getElementById("map");
  var myCenter=new google.maps.LatLng(11.5776725,113.5671426);
  var mapOptions = {
        center: myCenter, zoom: 5,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
  var map = new google.maps.Map(mapCanvas, mapOptions);
          google.maps.event.addListener(map, 'click', function(event) {
          placeMarker(map, event.latLng);
        });

        $.ajaxSetup({
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });



        function placeMarker(map, location) {
          $('#btnweather').removeAttr("disabled")
          var lat = location.lat();
          var longit = location.lng();

          var activeInfoWindow;

          if (!marker || !marker.setPosition) {
              marker = new google.maps.Marker({
                  position: location,
                  map: map,
              });

          } else {
              marker.setPosition(location);
          }

          if (!!infowindow && !!infowindow.close) {
              infowindow.close();
          }

          $.ajax({
            type: 'GET',
            url: '{{ route('weather-ajax', app()->getLocale()) }}',
            dataType: "json",
            data: { lat : lat,
                    longit : longit

             },

            success: function(data){
              if (infowindow) {
                infowindow.close();
              }
                infowindow = new google.maps.InfoWindow();
                infowindow.setContent('Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng() + '<br>Country: ' + data.sys.country + '<br>City: ' + data.name  + '<br>Weather : ' + data.weather[0].description  + '<br>Temperature :' + Math.round(data.main.temp - 273.15) + " °C");
                infowindow.open(map, marker);

            }

          });
      }



  </script>

@endpush
