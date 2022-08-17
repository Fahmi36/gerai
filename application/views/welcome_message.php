<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
                        <input type="text" placeholder="Masukan Nama Tempat" class="form-control" id="search_address">
                        <p id="tampilkan"></p>
                        <div id="mapsnya" style="height:400px;margin-bottom:20px;background: #FFF;padding: 10px;border:solid 1px #DDD"></div>
</div>

</body><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIIfuR8-AJIrG2tScD4zW3Fmm4Ret3wX4&language=id&region=id&libraries=places,geometry" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		getLocation();
	});
</script>
<script>
    var view = $("#tampilkan"); // Untuk mengambil id tampilkan 
    var geocoder = new google.maps.Geocoder();
    var map;
    var marker;
    var contentString;
    var po = [];
    var infowindow = new google.maps.InfoWindow({
        size: new google.maps.Size()
    });
    //Untuk menampilkan tampilan awal maps
    function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-6.354906833002305, 106.84109466061315);//untuk setting map di awal 
        var mapOptions = {
            center: latlng,
            zoom: 15,
            myLocation: true
        };
        
        map = new google.maps.Map(document.getElementById('mapsnya'), mapOptions),
		$.ajax({
			type: "get",
			url: "/getDataMitra",
			dataType: "json",
			success: function (response) {
				for (let i = 0; i < response.data.length; i++) {
					
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(response.data[i].lat,response.data[i].lng),
						map: map
					});
					
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
						infowindow.setContent(response.data[i].nama);
						infowindow.open(map, marker);
						}
					})(marker, i));
				}
			}
		});
        google.maps.event.addListener(map, "click", function (location) { 
            setLatLong(location.latLng.lat(), location.latLng.lng());
            placeMarker(location.latLng);
            setGeoCoder(location.latLng);
        });
        function placeMarker(location) {
            if ( marker ) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }
        }
        var input = document.getElementById('search_address');//Untuk memanggil id search autocomplete
        
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        autocomplete.setTypes([]);
        
        var infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });
        
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            //infowindow.close();
            marker.setVisible(true);
            var place = autocomplete.getPlace();
            
            if (!place.geometry) return;
            
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setIcon();
            marker.setPosition(place.geometry.location);
            geocodePosition(marker.getPosition());
            var namanya = place.name;
            var addrnya = place.formatted_address;
            marker.setVisible(true);
            setLatLong(place.geometry.location.lat(), place.geometry.location.lng(),namanya,addrnya);
        });
        
        google.maps.event.addListener(marker, "dragend", function (e) {
            setLatLong(marker.getPosition().lat(), marker.getPosition().lng());
            placeMarker(marker.getPosition());
            setGeoCoder(marker.getPosition());
        });
    }
    
    //fungsinya untuk mengambil id dari lat 
    function setLatLong(lat, long,nama,addr) {
        $('#lat').val(lat);
        $('#long').val(long);
        $('#alamat').val(addr);
        $('#coordinate').val(lat+','+long);
    }
    
    function setGeoCoder(pos) {
        geocoder.geocode({'location': pos}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#alamat').val(results[0].formatted_address);
                } else {
                    $('#search_address').val('');
                }
            } else {
                $('#search_address').val('');
            }
        });
    }
    
    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
            if (responses && responses.length > 0) {
                marker.formatted_address = responses[0].formatted_address;
            } else {
                marker.formatted_address = 'Cannot determine address at this location.';
            }
            $('#alamat').val(marker.formatted_address);
            
            infowindow.setContent(marker.formatted_address);
            infowindow.open(map, marker);
        });
    }
    
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            view.innerHTML = "Mohon maaf browser anda tidak mendukung Geolocation!";
        }
    }
    
    function showPosition(position) {
        $('#lat').val(position.coords.latitude);
        $('#long').val(position.coords.longitude);
        $('#coordinate').val(position.coords.latitude+','+position.coords.longitude);
        var address = position.coords.latitude+','+position.coords.longitude;
        geocoder.geocode({
			'address': address
        }, function(results, status) {
			var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(latlng);
                if (marker) {
                    marker.setMap(null);
                    if (infowindow) infowindow.close();
                }
                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: latlng
                });
                
                $('#alamat').val(results[0].formatted_address);
                var fx = results[0].formatted_address.split(',');
                $('hides').show();
                google.maps.event.addListener(marker, 'dragend', function(a) {
                    geocodePosition(marker.getPosition());
                    $('#lat').val(a.latLng.lat());
                    $('#long').val(a.latLng.lng());
                    $('#coordinate').val(a.latLng.lat()+','+a.latLng.lng());
                });
                google.maps.event.addListener(marker, 'center_changed', function() {
                    if (results[0].formatted_address) {
                        infowindow.setContent(results[0].formatted_address + "<br>coordinates: " + marker.getPosition());
                    }else {
                        infowindow.setContent(address + "<br>coordinates: " + marker.getPosition());
                    }
                    infowindow.open(map, marker);
                });
                google.maps.event.trigger(marker, 'center_changed');
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
        
    }
    
    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
            view.innerHTML = "Tidak dapat mendeteksi lokasi anda"
            break;
            case error.POSITION_UNAVAILABLE:
            view.innerHTML = "Lokasi anda tidak dapat kami temukan"
            break;
            case error.TIMEOUT:
            view.innerHTML = "Requestnya timeout"
            break;
            case error.UNKNOWN_ERROR:
            view.innerHTML = "An unknown error occurred."
            break;
        }
    }
    
    
    google.maps.event.addDomListener(window, "load", initialize);
</script>
</html>
