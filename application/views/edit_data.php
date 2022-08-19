<div class="container mt-3">
<img src="<?=base_url('assets/img/logo.png');?>">
<hr>
<?php if($this->session->flashdata('success')){?>
   <div class="alert alert-success"><?=$this->session->flashdata('success');?></div>
   <?php } ?>
   <?php if($this->session->flashdata('error')){?>
      <div class="alert alert-error"><?=$this->session->flashdata('error');?></div>
      <?php } ?>
      <form method="post" id="edit_data" action="javascript:void(0);" enctype="multipart/form-data" accept-charset="utf-8" class="form-mitra">
      <label for="nama" class="block">Nama Pemohon <span
      class="text-danger">*</span>
      </label>
      <input type="text" required="" value="<?=@$data->nama_pemilik?>" class="form-control" id="nama" name="nama" placeholder="-">
      <input type="hidden" required="" value="<?=@$data->id?>" class="form-control" id="id" name="id" placeholder="-">
      
      <label for="nama_booth" class="block">Nama Booth <span
      class="text-danger">*</span>
      </label>
      <input type="text" required="" class="form-control" value="<?=@$data->nama_toko?>" id="nama_booth" name="nama_booth" placeholder="-">
      
      <label for="no_hp" class="block">Nomor Handphone <span
      class="text-danger">*</span>
      </label>
      <input type="text" required="" class="form-control" id="no_hp" value="<?=@$data->nohp?>" name="no_hp" placeholder="-">
      <div class="input-group ">
      <span class="input-group-text bg-light"><i class="fa fa-map-marker text-danger fs-3"></i></span>
      <div class="form-floating">
      <input type="text" class="form-control mb-0" id="search_address" placeholder="Masukan Nama Tempat">
      <label for="search_address">Masukan Nama Tempat</label>
      </div>
      </div>
      <p id="tampilkan"></p>
      <div id="mapsnya"></div>
      <label for="alamat" class="block">Alamat Lengkap <span
      class="text-danger">*</span>
      </label>
      <input type="text" required="" class="form-control" value="<?=@$data->alamat?>" id="alamat" name="alamat" placeholder="-">
      <input type="hidden" required="" class="form-control" value="<?=@$data->koordinat?>" id="coordinate" name="koordinat" placeholder="-">
      
      <label for="foto_lokasi" class="block">Foto Lokasi <span
      class="text-danger">*</span>
      </label>
      <input type="file" class="form-control" id="foto_lokasi" name="foto_lokasi" placeholder="-">
      <input type="hidden" value="<?=@$data->foto_toko?>" name="old_foto">
      <img src="<?=@$data->foto_toko?>" class="img-thumbnail mt-2" style="width: 300px;">
      <div class="d-grid gap-2 col-6 mx-auto">
      <button class="cant-submit btn btn-warning rounded-5 mb-3 mt-4 btn-block" type="submit">Edit</button>
      </div>
      </form>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIIfuR8-AJIrG2tScD4zW3Fmm4Ret3wX4&language=id&region=id&libraries=places,geometry" type="text/javascript"></script>
      <script type="text/javascript">
      $(function () {
         $("#edit_data").submit(function (event) {
            var datas = new FormData($(this)[0]);
            Swal.fire({
               title: 'Ubah Data',
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
                     url: '/editDataStore',
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
         var latlng = new google.maps.LatLng(<?=@$data->koordinat?>);//untuk setting map di awal 
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
         });
         var input = document.getElementById('search_address');//Untuk memanggil id search autocomplete
         
         var autocomplete = new google.maps.places.Autocomplete(input);
         autocomplete.bindTo('bounds', map);
         autocomplete.setTypes([]);
         
         var infowindow = new google.maps.InfoWindow();
         marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: latlng,
            anchorPoint: new google.maps.Point(0, -29)
         });
         addYourLocationButton(map, marker);
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
      function addYourLocationButton (map, marker) 
      {
         var controlDiv = document.createElement('div');
         
         var firstChild = document.createElement('button');
         firstChild.style.backgroundColor = '#fff';
         firstChild.style.border = 'none';
         firstChild.style.outline = 'none';
         firstChild.style.width = '40px';
         firstChild.style.height = '40px';
         firstChild.style.borderRadius = '2px';
         firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
         firstChild.style.cursor = 'pointer';
         firstChild.style.marginRight = '10px';
         firstChild.style.padding = '0';
         firstChild.title = 'Your Location';
         firstChild.type = 'button';
         controlDiv.appendChild(firstChild);
         
         var secondChild = document.createElement('div');
         secondChild.style.margin = '5px auto';
         secondChild.style.width = '18px';
         secondChild.style.height = '18px';
         secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-2x.png)';
         secondChild.style.backgroundSize = '180px 18px';
         secondChild.style.backgroundPosition = '0 0';
         secondChild.style.backgroundRepeat = 'no-repeat';
         firstChild.appendChild(secondChild);
         
         google.maps.event.addListener(map, 'center_changed', function () {
            secondChild.style['background-position'] = '0 0';
         });
         
         firstChild.addEventListener('click', function () {
            var imgX = '0',
            animationInterval = setInterval(function () {
               imgX = imgX === '-18' ? '0' : '-18';
               secondChild.style['background-position'] = imgX+'px 0';
            }, 500);
            
            if(navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(function(position) {
                  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                  setLatLong(position.coords.latitude, position.coords.longitude);
                  placeMarker(latlng);
                  setGeoCoder(latlng);
                  map.setCenter(latlng);
                  clearInterval(animationInterval);
                  secondChild.style['background-position'] = '-144px 0';
               });
            } else {
               clearInterval(animationInterval);
               secondChild.style['background-position'] = '0 0';
            }
         });
         
         controlDiv.index = 1;
         map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
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