<style type="text/css">
   ::selection { background-color: #E13300; color: white; }
   ::-moz-selection { background-color: #E13300; color: white; }

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
                        <th>Nomor Hendphone</th>
                        <th>Alamat</th>
                        <th>Koordinat</th>
                        <th>Status</th>
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
                        <th>Nomor Hendphone</th>
                        <th>Alamat</th>
                        <th>Koordinat</th>
                        <th>Status</th>
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
<script>
   $(document).ready(function() {
      GetdataAdminSelesai();
      GetdataAdminProses();
   });
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
</script>