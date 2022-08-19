<?php

date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');
use ImageKit\ImageKit;

class Welcome extends CI_Controller {
	
	/**
	* Index Page for this controller.
	*
	* Maps to the following URL
	* 		http://example.com/index.php/welcome
	*	- or -
	* 		http://example.com/index.php/welcome/index
	*	- or -
	* Since this controller is set as the default controller in
	* config/routes.php, it's displayed at http://example.com/
	*
	* So any other public methods not prefixed with an underscore will
	* map to /index.php/welcome/<method_name>
	* @see https://codeigniter.com/userguide3/general/urls.html
	*/
	var $coloumnorder = array(null,'nama_pemilik','nama_toko','nohp','alamat','koordinat',null);
	var $coloumnsearch = array('lower(nama_pemilik)','lower(nama_toko)','lower(nohp)','lower(alamat)','lower(koordinat)');
	var $order = array('created_at'=>'ASC');
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['title'] = 'Halaman Tambah Gerai - Teh Manis Jumbo';
		$data['link_view'] = 'gerai';
		$this->load->view('utama',$data);
	}
	public function getMitra()
	{
		$this->db->select('koordinat,nama_pemilik,alamat');
		$this->db->from('mitra');
		$this->db->where('status',1);
		$query = $this->db->get();
		$data = [];
		foreach ($query->result() as $key) {
			$exp = explode(',',$key->koordinat);
			$data[] = [
				'nama'=>ucwords($key->nama_pemilik),
				'koordinat'=>$key->koordinat,
				'lat'=>floatval(@$exp[0]),
				'lng'=>floatval(@$exp[1]),
				'alamat'=>$key->alamat,
			];
		}
		echo json_encode(['code'=>200,'data'=>$data]);
	}
	function saveDataMitra(){
		$respone = array();
		if (!$this->input->is_ajax_request()) {
			$response = array(
				'code'=>400,
				'message'=> 'Tidak Boleh Akses'
			);
		}else{
			$this->db->trans_start();
			$this->form_validation->set_rules('nama','Nama Penanggung Jawab','required',array('required' => 'Mohon Isi Nama Penanggung Jawab'));
			$this->form_validation->set_rules('no_hp','Nomor Telp','required',array('required' => 'Mohon Isi Nomor Telp Pemohon'));
			$this->form_validation->set_rules('nama_booth','Nama Booth','required',array('required' => 'Mohon Isi Nama Booth'));
			$this->form_validation->set_rules('alamat','Alamat Booth','required',array('required' => 'Mohon Isi Nama Booth'));
			$this->form_validation->set_rules('koordinat','koordinat Booth','required',array('required' => 'Mohon Pilih Alamat Anda Di Maps'));
			if($this->form_validation->run()){
				$cek = $this->db->get_where('mitra',array('nohp'=>$this->input->post('no_hp'),'alamat'=>$this->input->post('alamat')));
				if($cek->num_rows() > 0){
					$this->db->trans_rollback();
					$respone['code'] = 400;
					$respone['message'] = 'Toko Anda Sedang Dalam Review';
				}else{
					$this->db->insert('mitra',array(
						'nama_pemilik'=>$this->input->post('nama'),
						'nama_toko'=>$this->input->post('nama_booth'),
						'nohp'=>$this->input->post('no_hp'),
						'alamat'=>$this->input->post('alamat'),
						'koordinat'=>$this->input->post('koordinat'),
						'status'=>0,
						'foto_toko'=>$this->uploadFile('foto_lokasi'),
						'created_at'=>date('Y-m-d H:i:s'),
					));
					
					$this->db->trans_commit();
					$respone['code'] = 200;
					$respone['message'] = 'Data Anda akan Kami Review';
				}
			}else{
				$this->db->trans_rollback();
				$respone['code'] = 400;
				$respone['message'] = 'Gagal';
			}
		}
		echo json_encode($respone);
	}
	function updateDataMitra(){
		$respone = array();
		if (!$this->input->is_ajax_request()) {
			$response = array(
				'code'=>400,
				'message'=> 'Tidak Boleh Akses'
			);
		}else{
			$this->db->trans_start();
			$this->form_validation->set_rules('nama','Nama Penanggung Jawab','required',array('required' => 'Mohon Isi Nama Penanggung Jawab'));
			$this->form_validation->set_rules('no_hp','Nomor Telp','required',array('required' => 'Mohon Isi Nomor Telp Pemohon'));
			$this->form_validation->set_rules('nama_booth','Nama Booth','required',array('required' => 'Mohon Isi Nama Booth'));
			$this->form_validation->set_rules('alamat','Alamat Booth','required',array('required' => 'Mohon Isi Nama Booth'));
			$this->form_validation->set_rules('koordinat','koordinat Booth','required',array('required' => 'Mohon Pilih Alamat Anda Di Maps'));
			if($this->form_validation->run()){
				$cek = $this->db->get_where('mitra',array('nohp'=>$this->input->post('no_hp'),'alamat'=>$this->input->post('alamat')));
				if($cek->num_rows() > 0){
					$this->db->trans_rollback();
					$respone['code'] = 400;
					$respone['message'] = 'Toko Anda Sedang Dalam Review';
				}else{
					$file = $this->uploadFile('foto_lokasi');
					if($file == null){
						$foto = $this->input->post('old_foto');
					}else{
						$foto = $file;
					}
					$this->db->update('mitra',array(
						'nama_pemilik'=>$this->input->post('nama'),
						'nama_toko'=>$this->input->post('nama_booth'),
						'nohp'=>$this->input->post('no_hp'),
						'alamat'=>$this->input->post('alamat'),
						'koordinat'=>$this->input->post('koordinat'),
						'foto_toko'=>$foto,
						'created_at'=>date('Y-m-d H:i:s'),
					),array('id'=>$this->input->post('id')));
					
					$this->db->trans_commit();
					$respone['code'] = 200;
					$respone['message'] = 'Data Anda akan Kami Review';
				}
			}else{
				$this->db->trans_rollback();
				$respone['code'] = 400;
				$respone['message'] = 'Gagal';
			}
		}
		echo json_encode($respone);
	}
	function setujuiGerai(){
		$respone = array();
		if (!$this->input->is_ajax_request()) {
			$response = array(
				'code'=>400,
				'message'=> 'Tidak Boleh Akses'
			);
		}else{
			$this->db->trans_start();
			$this->form_validation->set_rules('id','id','required',array('required' => 'Mohon Isi id'));
			if($this->form_validation->run()){
				$cek = $this->db->get_where('mitra',array('id'=>$this->input->post('id')));
				if($cek->num_rows() > 0){
					$this->db->trans_commit();
					$this->db->update('mitra',array(
						'status'=>$this->input->post('status'),
						'updated_at'=>date('Y-m-d H:i:s'),
					),array('id'=>$this->input->post('id')));
					$respone['code'] = 200;
					$respone['message'] = 'Data Sudah di Terima';
				}else{
					$this->db->trans_rollback();
					$respone['code'] = 400;
					$respone['message'] = 'Tidak Ada Toko';
				}
			}else{
				$this->db->trans_rollback();
				$respone['code'] = 400;
				$respone['message'] = 'Gagal';
			}
		}
		echo json_encode($respone);
	}
	function uploadFile($params)
	{
		$this->load->library('upload');
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'jpeg|jpg|png';
		$config['encrypt_name'] = true;
		
		$this->upload->initialize($config);
		$upload = $this->upload->do_upload($params);
		if ($upload){
			$image = $this->upload->data();
			$imageKit = new ImageKit(
				"public_jW32xkWgKyRPF/iDkRqRGReQlFc=",
				"private_NATFuIxSElfVrHS/7qQMnelui+g=",
				"https://ik.imagekit.io/dnmd9pfjcf"
			);
			$uploadFile = $imageKit->uploadFile([
				'file' => base_url('assets/img/'.$image['file_name']),
				'fileName' => $image['file_name'],
			]);
			$data = $uploadFile->result->url;
			unlink(@$image['full_path']);
		}else{
			$data = false;
		}
		return $data;
	}
	function getDataTable()
	{	
		$uri = $this->uri->segment(2);
		$list = $this->dataTableMitra($uri,'');
		$countnya = $this->countDataMitra($uri);
		$numrows = $this->dataTableMitra($uri,'num_rows')->num_rows();
		$data = array();
		$no = @$_POST['start'];
		foreach ($list->result() as $field) {
			$no++;
			if ($field->status == 1) {
				$status = 'Mitra aktif';
			}else if($field->status == 2){
				$status = 'Mitra non-aktif';
			}else if($field->status == 3){
				$status = 'Mitra di tolak';
			}else{
				$status = 'Mitra belum verifikasi';
			}
			if ($field->status == 1) {
				$btn = "<a href=".site_url('editdata_mitra/'.$field->id)." class='btn btn-sm btn-warning'>Edit</a>&nbsp<a href='javascript:void(0);' onclick='nonaktifMitra(".$field->id.")' class='btn btn-sm btn-primary'>Non Aktif</a>";
			}else{
				$btn = "<a href='javascript:void(0);' onclick='setujuMitra(".$field->id.")' class='btn btn-sm btn-primary'>Terima</a>&nbsp <a href='javascript:void(0);' onclick='tolakMitra(".$field->id.")' class='btn btn-sm btn-danger'>Tolak</a>&nbsp<a href=".site_url('editdata_mitra/'.$field->id)." class='btn btn-sm btn-warning'>Edit</a>";
			}
			$row = array();
			$row[] = $no;
			$row[] = $field->nama_pemilik;
			$row[] = $field->nama_toko;
			$row[] = $field->nohp;
			$row[] = '<a href="javascript:void(0);" onclick="openModal("'.$field->foto_toko.'")" class="text-primary text-underline">Lihat Foto</a>';
			$row[] = $field->alamat;
			$row[] = $field->koordinat;
			$row[] = $status;
			$row[] = $btn;
			$data[] = $row;
		}
		$output = array(
			"draw" => @$_POST['draw'],
			"recordsTotal" => $countnya,
			"recordsFiltered" => $numrows,
			"data" => $data,
		);
		echo json_encode($output);
	}
	function dataTableMitra($uri='',$num='')
	{
		$this->db->select('*');
		$this->db->from('mitra');
		if ($uri=='selesai') {
			$this->db->where('status',1);
		}else{
			$this->db->where('status',0);
		}
		$i = 0;
		foreach ($this->coloumnsearch as $itemsearch) {
			if (@$_POST['search']['value']) {
				if ($i === 0) {
					$this->db->like($itemsearch, strtolower($_POST['search']['value']),'BOTH');
					if ($uri=='selesai') {
						$this->db->where_in('status',[1,2]);
					}else{
						$this->db->where('status',0);
					}
				}else{
					$this->db->or_like($itemsearch, strtolower($_POST['search']['value']),'BOTH');
					if ($uri=='selesai') {
						$this->db->where_in('status',[1,2]);
					}else{
						$this->db->where('status',0);
					}
				}
			}
			$i++;
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->coloumnorder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		if ($num == null) {
			if(@$_POST['length'] != -1)
			$this->db->limit(@$_POST['length'], @$_POST['start']);
		}
		$q = $this->db->get();
		return $q;
	}
	function countDataMitra($uri='')
	{
		$this->db->select('*');
		$this->db->from('mitra');
		if ($uri=='selesai') {
			$this->db->where('status',1);
		}else{
			$this->db->where('status',0);
		}
		return $this->db->count_all_results();
	}
	public function data_mitra()
	{
		$data['title'] = 'Halaman Data Mitra - Teh Manis Jumbo';
		$data['link_view'] = 'data_mitra';
		$this->load->view('utama',$data);
	}
	public function edit_data()
	{
		$uri = $this->uri->segment(2);
		$query = $this->db->get_where('mitra',array('id'=>$uri));
		if($query->num_rows() > 0){
			$data['data'] = $query->row();
			$data['title'] = 'Halaman Edit Data Mitra - Teh Manis Jumbo';
			$data['link_view'] = 'edit_data';
			$this->load->view('utama',$data);
		}else{
			redirect('datamitra');
		}
	}
}
