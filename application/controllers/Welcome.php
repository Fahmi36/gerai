<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	public function index()
	{
		$data['title'] = 'Halaman Tambah Gerai - Teh Manis Jumbo';
        $data['link_view'] = 'gerai';
		$this->load->view('utama',$data);
	}
	public function getMitra()
	{
		$this->db->select('koordinat,nama_pemilik');
		$this->db->from('mitra');
		$query = $this->db->get();
		$data = [];
		foreach ($query->result() as $key) {
			$exp = explode(',',$key->koordinat);
			$data[] = [
				'nama'=>$key->nama_pemilik,
				'koordinat'=>$key->koordinat,
				'lat'=>floatval(@$exp[0]),
				'lng'=>floatval(@$exp[1]),
			];
		}
		echo json_encode(['code'=>200,'data'=>$data]);
	}
}
