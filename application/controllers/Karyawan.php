<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Karyawan extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('karyawan_model'); // Memanggil produk_model yang terdapat pada models
		$this->load->model('users_model'); // Memanggil produk_model yang terdapat pada models
		$this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->helper('date');
	}
	
	// Fungsi untuk menampilkan halaman produk
	public function index() {	
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->load->view('templates/header');
		$this->load->view('templates/side_bar');
		$this->load->view('pages/karyawan/karyawan_list');
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	}
	
	// Fungsi JSON
	public function json() {
		header('Content-Type: application/json');
		echo $this->karyawan_model->json();
	}
	
	// Fungsi untuk menampilkan halaman produk secara detail
	public function read($id){

		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM karyawan
				  WHERE kd_karyawan = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data karyawan tersedia maka akan ditampilkan
		if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('karyawan'),
			'kd_karyawan' => $row->kd_karyawan,
			'nama_karyawan' => $row->nama_karyawan,
			'alamat' => $row->alamat,
			'no_tlp' => $row->alamat,
			'tgl_karyawan_masuk' => $row->tgl_karyawan_masuk,
			'level' => $row->level,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/karyawan/karyawan_read', $data);
			$this->load->view('templates/footer');
	
	$this->load->view('templates/jquery');	} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
			// $this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('karyawan'));
		}
	}
	
	// Fungsi menampilkan form Create produk
	public function create(){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Menampung data yang diinputkan
		$data = array(
			'button' => 'Create',
			'back'   => site_url('karyawan'),
			'action' => site_url('karyawan/create_action'),
			'kd_karyawan' => set_value('kd_karyawan'),
			'nama_karyawan' => set_value('nama_karyawan'),
			'alamat' => set_value('alamat'),
			'no_tlp' => set_value('no_tlp'),
			'tgl_karyawan_masuk' => set_value('tgl_karyawan_masuk'),
			'level' => set_value('level'),
		);
		$this->load->view('templates/header');
		$this->load->view('templates/side_bar');
		$this->load->view('pages/karyawan/karyawan_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	}
	
	// Fungsi untuk melakukan aksi simpan data
	public function create_action(){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form produk belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan menyimpan kedalam database
		else {
			// $nama_karyawan = $this->input->post('nama_karyawan');
			// $jk = $this->input->post('jk');
			// $alamat = $this->input->post('alamat');
			// $no_tlp = $this->input->post('no_tlp');

			$data = array(
			'kd_karyawan' => $this->input->post('kd_karyawan',TRUE),
			'nama_karyawan' => $this->input->post('nama_karyawan',TRUE), 
			'alamat' => $this->input->post('alamat',TRUE),
			'no_tlp' => $this->input->post('no_tlp', TRUE),
			'level' => $this->input->post('level', TRUE),
			'tgl_karyawan_masuk' => $this->input->post('tgl_karyawan_masuk', TRUE),
			'data_ditambahkan' => date('Y-m-d H:i:s', now()),
		);
		$this->karyawan_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('karyawan'));
	}	
}
	
	// Fungsi menampilkan form Update produk
	public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
		$row = $this->karyawan_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
		if ($row) {
			$data = array(
			'button' => 'Update',
			'back'   => site_url('karyawan'),
			'action' => site_url('karyawan/update_action'),
			'kd_karyawan' => $row->kd_karyawan,
			'nama_karyawan' => $row->nama_karyawan,
			'alamat' => $row->alamat,
			'no_tlp' => $row->no_tlp,
			'tgl_karyawan_masuk' => $row->tgl_karyawan_masuk,
			'level' => $row->level,
		);
		$this->load->view('templates/header');
		$this->load->view('templates/side_bar');
		$this->load->view('pages/karyawan/karyawan_form', $data);
		$this->load->view('templates/footer');

$this->load->view('templates/jquery');	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('karyawan'));
	}
}
	
	// Fungsi untuk melakukan aksi update data
	public function update_action(){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rules(); // Rules atau aturan bahwa setiap form harus diisi	
		
		// Jika form produk belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('kd_karyawan', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			 //Buat slug
			 $data = array(
				'kd_karyawan' => $this->input->post('kd_karyawan',TRUE),
				'nama_karyawan' => $this->input->post('nama_karyawan',TRUE), 
				'alamat' => $this->input->post('alamat',TRUE),
				'no_tlp' => $this->input->post('no_tlp',TRUE),
				'tgl_karyawan_masuk' => $this->input->post('tgl_karyawan_masuk',TRUE),
				'level' => $this->input->post('level',TRUE),
				'data_ditambahkan' => date('Y-m-d H:i:s', now()),
			);
			$this->karyawan_model->update($this->input->post('kd_karyawan', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('karyawan'));
		}
	}
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
	public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$row = $this->karyawan_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
		if ($row) {
			$this->karyawan_model->delete($id);
			// $this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('karyawan'));
		} 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
			// $this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('karyawan'));
		}
	}
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
	public function _rules() {
		$this->form_validation->set_rules('nama_karyawan', 'nama_karyawan', 'trim|required');
		$this->form_validation->set_rules('alamat', 'alamat', 'required');
		$this->form_validation->set_rules('no_tlp', 'no_tlp', 'required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
}
	
?>