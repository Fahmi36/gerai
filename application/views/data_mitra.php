<style type="text/css">
   ::selection { background-color: #f9c349; color: white; }
   ::-moz-selection { background-color: #f9c349; color: white; }
   .table td:last-child { 
      display: inline-flex;
   }
   #mapsnya{
      height:500px;
   }
   #mapsproses{
      height:500px;
   }
</style>

<div class="container mt-3">
   <img src="<?=base_url('assets/img/logo.png');?>">
   <hr>
   <?php if($this->session->flashdata('success')){?>
      <div class="alert alert-success"><?=$this->session->flashdata('success');?></div>
   <?php } ?>
   <?php if($this->session->flashdata('error')){?>
      <div class="alert alert-error"><?=$this->session->flashdata('error');?></div>
   <?php } ?>
   <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
         <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Sudah Verifikasi</button>
      </li>
      <li class="nav-item" role="presentation">
         <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Belum Verifikasi</button>
      </li>
   </ul>
   <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
         <div class="card card-information mt-3">
            <div id="mapsnya"></div>
            <div class="card-header">
              <h4 class="fs-15 mb-0 text-center fw-bold">Daftar Data Mitra Sudah Verifikasi</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table dataTable table-striped table-bordered">
                     <thead>
                        <th>No</th>
                        <th>Nama Pemohon</th>
                        <th>Nama Booth</th>
                        <th>Nomor Telepon</th>
                        <th>Foto</th>
                        <th>Alamat</th>
                        <th>Koordinat</th>
                        <th>Status</th>
                        <th>Jawaban 1</th>
                        <th>Jawaban 2</th>
                        <th>Jawaban 3</th>
                        <th>Jawaban 4</th>
                        <th>Jawaban 5</th>
                        <th>Aksi</th>
                     </thead>
                     <tbody id="contentNya">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
         <div class="card card-information mt-3">
            <div id="mapsproses"></div>
            <div class="card-header">
              <h4 class="fs-15 mb-0 text-center fw-bold">Daftar Data Mitra Belum Verifikasi</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table dataTableProses table-striped table-bordered" style="width:100%;">
                     <thead>
                        <th>No</th>
                        <th>Nama Pemohon</th>
                        <th>Nama Booth</th>
                        <th>Nomor Telepon</th>
                        <th>Foto</th>
                        <th>Alamat</th>
                        <th>Koordinat</th>
                        <th>Status</th>
                        <th>Jawaban 1</th>
                        <th>Jawaban 2</th>
                        <th>Jawaban 3</th>
                        <th>Jawaban 4</th>
                        <th>Jawaban 5</th>
                        <th>Aksi</th>
                     </thead>
                     <tbody id="contentNya">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modalImages" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <img src="" width="100%" class="image-modal">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIIfuR8-AJIrG2tScD4zW3Fmm4Ret3wX4&language=id&region=id&libraries=places,geometry" type="text/javascript"></script>
<script>
   $(document).ready(function() {
      GetdataAdminSelesai();
      GetdataAdminProses();
   });
   function openModal(image){
      $('#modalImages').modal('show');
      $('.image-modal').attr('src', image);
   }
   function GetdataAdminSelesai() {
      var URL = '<?=site_url('list_data_mitra/selesai')?>';
      var t = $('.dataTable').DataTable({ 
         "processing": true, 
         "serverSide": true, 
         "ajax": {
            "url": URL,
            "type": "POST"
         },
      });
   }
   function GetdataAdminProses() {
      var URL = '<?=site_url('list_data_mitra/proses')?>';
      var t = $('.dataTableProses').DataTable({ 
         "processing": true, 
         "serverSide": true, 
         "ajax": {
            "url": URL,
            "type": "POST"
         },
      });
   }
   function setujuMitra(id) {
      Swal.fire({
            title: 'Setujui',
            text: "Jika data sudah sesuai maka tekan tombol ya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
            $.ajax({
               type: "post",
               url: "/setujuiGerai",
               data: {id:id,status:1},
               dataType: "json",
               success: function (response) {
                  if (response.code== 200) {
                        Swal.fire({
                           icon: 'success',
                           title: 'Horeee...',
                           text: response.message,
                        });
                        setInterval(() => {
                           window.location.reload();
                        }, 3000);
                     }else{
                        Swal.fire({
                           icon: 'error',
                           title: 'Maaf...',
                           text: response.message,
                        });
                     }
               }
            });
         }
      });
    }
    function nonaktifMitra(id) {
      Swal.fire({
            title: 'Non aktif Mitra',
            text: "Jika data sudah sesuai maka tekan tombol ya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
            $.ajax({
               type: "post",
               url: "/setujuiGerai",
               data: {id:id,status:2},
               dataType: "json",
               success: function (response) {
                  if (response.code== 200) {
                        Swal.fire({
                           icon: 'success',
                           title: 'Horeee...',
                           text: response.message,
                        });
                        setInterval(() => {
                           window.location.reload();
                        }, 3000);
                     }else{
                        Swal.fire({
                           icon: 'error',
                           title: 'Maaf...',
                           text: response.message,
                        });
                     }
               }
            });
         }
      });
    }
    function tolakMitra(id) {
      Swal.fire({
            title: 'Tolak Mitra',
            text: "Jika data sudah sesuai maka tekan tombol ya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
            $.ajax({
               type: "post",
               url: "/setujuiGerai",
               data: {id:id,status:3},
               dataType: "json",
               success: function (response) {
                  if (response.code== 200) {
                        Swal.fire({
                           icon: 'success',
                           title: 'Horeee...',
                           text: response.message,
                        });
                        setInterval(() => {
                           window.location.reload();
                        }, 3000);
                     }else{
                        Swal.fire({
                           icon: 'error',
                           title: 'Maaf...',
                           text: response.message,
                        });
                     }
               }
            });
         }
      });
   }
   var infowindow = new google.maps.InfoWindow({
      size: new google.maps.Size()
   });
   
   //Untuk menampilkan tampilan awal maps
   function initialize() {
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(-6.354906833002305, 106.84109466061315);//untuk setting map di awal 
      var mapOptions = {
         center: latlng,
         zoom: 12,
         myLocation: true
      };

      map = new google.maps.Map(document.getElementById('mapsnya'), mapOptions);
      map2 = new google.maps.Map(document.getElementById('mapsproses'), mapOptions);

      $.ajax({
         type: "get",
         url: "getDataMitra",
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

               markermitrap = new google.maps.Marker({
                  position: new google.maps.LatLng(response.data[i].lat,response.data[i].lng),
                  map: map2,
                  icon:'https://ik.imagekit.io/dnmd9pfjcf/tr:h-50,w-50/profilteh__sbDUb3dH.png'
               });

               google.maps.event.addListener(markermitrap, 'click', (function(markermitrap, i) {
                  return function() {
                     infowindow.setContent(response.data[i].nama);
                     infowindow.open(map2, markermitrap);
                     circle(response.data[i].lat,response.data[i].lng,markermitrap,map2);
                  }
               })(markermitrap, i));
            }
         }
      });
      $.ajax({
         type: "get",
         url: "getDataMitraProses",
         dataType: "json",
         success: function (response) {
            for (let i = 0; i < response.data.length; i++) {

               markermitrabp = new google.maps.Marker({
                  position: new google.maps.LatLng(response.data[i].lat,response.data[i].lng),
                  map: map2,
                  icon:'https://ik.imagekit.io/dnmd9pfjcf/tr:h-30,w-30/help_N-PgWX2Z2.png'
               });
               
               google.maps.event.addListener(markermitrabp, 'click', (function(markermitrabp, i) {
                  return function() {
                     infowindow.setContent(response.data[i].nama);
                     infowindow.open(map2, markermitrabp);
                     circle(response.data[i].lat,response.data[i].lng,markermitrabp,map2);
                  }
               })(markermitrabp, i));
            }
         }
      });
      var infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
         map: map,
         draggable: true,
         anchorPoint: new google.maps.Point(0, -29)
      });
   }
   function circle(lat,lng,markernya,mapnya){
        var sunCircle = {
            strokeColor: "#9dfc49",
            strokeOpacity: 0.2,
            strokeWeight: 1,
            fillColor: "#9dfc49",
            fillOpacity: 0.2,
            map: mapnya,
            center: lat,lng,
            radius: 1400 // in meters
         };
      cityCircle = new google.maps.Circle(sunCircle);
      cityCircle.bindTo('center', markernya, 'position');
   }
   google.maps.event.addDomListener(window, "load", initialize);
</script>