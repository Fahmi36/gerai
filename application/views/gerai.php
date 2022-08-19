<style type="text/css">
   ::selection { background-color: #E13300; color: white; }
   ::-moz-selection { background-color: #E13300; color: white; }

</style>

<div class="container mt-3">
   <img src="<?=base_url('assets/img/logo.png');?>">
   <hr>
   <div class="col-md-12 mt-3">
      <div class="row">
         <div class="col-md-8">
            <div class="alert alert-info mt-3 fs-14" role="alert">
               Mesin Pencari Mitra Jumbo di sekitar lokasi Anda<br>
               Mesin ini dapat memberikan Anda rekomendasi apakah lokasi yang ingin Anda ajukan merupakan lokasi terbaik untuk menjadi Mitra Jumbo.<br>
               Pengajuan Mitra Jumbo hanya akan diterima apabila pada radius <strong>1.5 km</strong> dari lokasi Anda tidak ada Mitra Jumbo lainnya.    
            </div>
            <div class="input-group ">
               <span class="input-group-text bg-light"><i class="fa fa-map-marker text-danger fs-3"></i></span>
               <div class="form-floating">
                  <input type="text" class="form-control" id="search_address" placeholder="Masukan Nama Tempat">
                  <label for="search_address">Masukan Nama Tempat</label>
               </div>
            </div>
            <p id="tampilkan"></p>
            <div id="mapsnya"></div>
         </div>
         <div class="col-md-4">
            <div class="card card-information text-bg-light mt-3 d-none">
               <div class="card-header text-center" style="border-color: #ededed;font-weight: bold;">Informasi Mitra Sekitar Lokasi</div>
               <div class="card-body">
                  <div class="default-mitra text-center m-5 d-none">
                     <img src="<?=base_url('assets/img/logo.png');?>">
                  </div>
                  <div class="danger-mitra mitra">
                     <div class="alertmitra"></div>
                  </div>
                  <div class="success-mitra text-center d-none">
                     <img src="<?=base_url('assets/img/success-2.png');?>" style="width: 45%;">
                     <h5 class="card-title">Horeee!!</h5>
                     <p class="card-text">Tidak Ada Mitra Jumbo di sekitar Anda.<br>
                        Kami sarankan Anda untuk memilih lokasi ini untuk menjadi mitra terbaik kami.
                     </p>
                  </div>
                  <form method="post" id="pengajuan-mitra" action="javascript:void(0);" enctype="multipart/form-data" accept-charset="utf-8" class="form-mitra d-none">
                     <div class="form-daftar text-left">
                        <label for="nama" class="block">Nama Pemohon <span
                           class="text-danger">*</span>
                        </label>
                        <input type="text" required="" class="form-control" id="nama" name="nama" placeholder="-">
                        <label for="nama_booth" class="block">Nama Booth <span
                           class="text-danger">*</span>
                        </label>
                        <input type="text" required="" class="form-control" id="nama_booth" name="nama_booth" placeholder="-">
                        <label for="no_hp" class="block">Nomor Handphone <span
                           class="text-danger">*</span>
                        </label>
                        <input type="text" required="" class="form-control" id="no_hp" name="no_hp" placeholder="-">
                        <label for="alamat" class="block">Alamat Lengkap <span
                           class="text-danger">*</span>
                        </label>
                        <input type="text" required="" class="form-control" id="alamat" name="alamat" placeholder="-">
                        <input type="hidden" required="" class="form-control" id="coordinate" name="koordinat" placeholder="-">
                        <label for="foto_lokasi" class="block">Foto Lokasi <span
                           class="text-danger">*</span>
                        </label>
                        <input type="file" required="" class="form-control" id="foto_lokasi" name="foto_lokasi" placeholder="-">
                     </div>
                     <br><br>
                     <input class="cant-submit btn btn-warning rounded-5 mb-3 mt-4" type="submit" value="Isi Formulir Pengajuan"/>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIIfuR8-AJIrG2tScD4zW3Fmm4Ret3wX4&language=id&region=id&libraries=places,geometry" type="text/javascript"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
      $(document).ready(function () {
         getLocation();
      });
      $(function () {
         'use strict';
         $('.cant-submit').on('click', function (e) {
            if ($(this).hasClass('cant-submit')) {
               $('.success-mitra').addClass('d-none');
               $('.cant-submit').addClass('btn-submit');
               $('.card-header').html('Masukkan Informasi Pengajuan');
               e.preventDefault();
               $(this).animate({
                  bottom: -35
               }, 300, function () {
                  $('form').addClass('appear').delay(1000);
                  $('.form-daftar').fadeIn(1000, function () {
                  $('#nama').attr('placeholder', 'Masukan Nama Pemilik!');
                  $('#nama_booth').attr('placeholder', 'Masukan Nama Booth!');
                  $('#no_hp').attr('placeholder', 'Masukan Nomor Handphone!');
               });
                  $(this).removeClass('cant-submit').val('Kirim Pengajuan');
               });
            }
         });
         $("#pengajuan-mitra").submit(function (event) {
            var datas = new FormData($(this)[0]);
            Swal.fire({
               title: 'Data Sudah Sesuai ?',
               text: "Jika data sudah sesuai makan tekan tombol ya",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Ya',
               cancelButtonText: 'Batal'
            }).then((result) => {
               if (result.value) {
                  $.ajax({
                     url: '/masukanDataStore',
                     type: 'POST',
                     dataType: 'json',
                     data : datas,
                     contentType: false,
                     cache: false,
                     processData: false,
                     beforeSend:function() {
                        $("#text-loader").html('Mohon Tunggu');
                        $('#page-loader').fadeIn('slow');
                     },
                     success:function(data) {
                        if (data.code== 200) {
                           Swal.fire({
                              icon: 'success',
                              title: 'Horeee...',
                              text: data.message,
                           });
                           setInterval(() => {
                              window.location.reload();
                           }, 3000);
                        }else{
                           Swal.fire({
                              icon: 'error',
                              title: 'Maaf...',
                              text: data.message,
                           });
                        }
                     }
                  })
               }
            })
	});
      });
   </script>
   <script>
    var view = $("#tampilkan"); // Untuk mengambil id tampilkan 
    var geocoder = new google.maps.Geocoder();
    var map;
    var marker,i,markermitra;
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
      google.maps.event.addListener(map, "click", function (location) { 
         setLatLong(location.latLng.lat(), location.latLng.lng());
         placeMarker(location.latLng);
         setGeoCoder(location.latLng);
         circle(location.latLng.lat(), location.latLng.lng());
      });
      $.ajax({
         type: "get",
         url: "/getDataMitra",
         dataType: "json",
         success: function (response) {
            for (let i = 0; i < response.data.length; i++) {

               markermitra = new google.maps.Marker({
                  position: new google.maps.LatLng(response.data[i].lat,response.data[i].lng),
                  map: map,
                  icon:'https://ik.imagekit.io/dnmd9pfjcf/tr:h-50,w-50/profilteh__sbDUb3dH.png'
               });
               
               google.maps.event.addListener(markermitra, 'click', (function(markermitra, i) {
                  return function() {
                     infowindow.setContent(response.data[i].nama);
                     infowindow.open(map, markermitra);
                  }
               })(markermitra, i));
            }
         }
      });

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
             circle(place.geometry.location.lat(), place.geometry.location.lng());
          });
        
        google.maps.event.addListener(marker, "dragend", function (e) {
         setLatLong(marker.getPosition().lat(), marker.getPosition().lng());
         placeMarker(marker.getPosition());
         setGeoCoder(marker.getPosition());
         circle(marker.getPosition().lat(), marker.getPosition().lng());
      });
     }
     function circle(lat,lng){
        var sunCircle = {
            strokeColor: "#c3fc49",
            strokeOpacity: 0.1,
            strokeWeight: 1,
            fillColor: "#c3fc49",
            fillOpacity: 0.1,
            map: map,
            center: lat,lng,
            radius: 1400 // in meters
         };
      cityCircle = new google.maps.Circle(sunCircle);
      cityCircle.bindTo('center', marker, 'position');
      google.maps.event.addListener(cityCircle, 'click', function(location) {
         setLatLong(location.latLng.lat(), location.latLng.lng());
         placeMarker(location.latLng);
         setGeoCoder(location.latLng);
         circle(location.latLng.lat(), location.latLng.lng());
      });
     $.ajax({
      type: "get",
      url: "/getDataMitra",
      dataType: "json",
      success: function (response) {
      var jarak = [];
      var nama = [];
      var htmlmitra = '';
      for (let i = 0; i < response.data.length; i++) {
         ukur = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(lat,lng), new google.maps.LatLng(response.data[i].lat,response.data[i].lng)) / 1000;
         if(ukur <= 1.4){
            jarak.push(ukur);
            htmlmitra += '<div class="card card-mitra"><div class="card-body"> <label class="badge text-bg-success" style="float:right;">'+ukur.toFixed(2)+' km</label> <h6 class="fs-14 fw-bold mb-2>'+response.data[i].nama+'</h6><i class="fa fa-map-marker text-danger"></i> <p class="class="fs-13 mb-2"">'+response.data[i].alamat+'</p><p class="fs-13 mb-0 text-success">Sudah Buka</p></div></div>';
            $('.alertmitra').html('<div class="alert alert-danger mt-3 fs-14" role="alert"><strong>Mohon Maaf</strong> Sobat Jumbo, Mitra yang ada di sekitar Anda sudah melebihi batas yang kami tetapkan. Kami sarankan agar Anda memilih lokasi lain.<br></div>');
         }
      }
      if (jarak.length == 0) {
         jarak.length = 0;
         $('.success-mitra').removeClass('d-none');
         $('.form-mitra').removeClass('d-none');
         $('.card-information').removeClass('d-none');
         $('.mitra').addClass('d-none');
      }else{
         jarak.length = 0;
         $('.card-information').removeClass('d-none');
         $('.mitra').removeClass('d-none');
         $('.form-mitra').addClass('d-none');
         $('.success-mitra').addClass('d-none');
         $('.mitra').html(htmlmitra);
      }
 }
});
  }

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

  circle(position.coords.latitude, position.coords.longitude);
  $('#alamat').val(results[0].formatted_address);
  var fx = results[0].formatted_address.split(',');
  $('hides').show();
  google.maps.event.addListener(marker, 'dragend', function(a) {
     geocodePosition(marker.getPosition());
     $('#lat').val(a.latLng.lat());
     $('#long').val(a.latLng.lng());
     $('#coordinate').val(a.latLng.lat()+','+a.latLng.lng());
     circle(a.latLng.lat(), a.latLng.lng());
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