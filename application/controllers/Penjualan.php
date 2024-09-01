<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('Penjualan_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('Produk_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('users_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->helpers('indonsiabln_helper'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman produk
    public function index() {	
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/penjualan/penjualan_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Penjualan_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM detail_pesanan
		          WHERE kd_detail_pesanan = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data penjualan tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('penjualan'),
			'kd_detail_pesanan' => $row->kd_detail_pesanan,
			'nama_produk' => $row->nama_produk,
			'total_harga' => $row->total_harga,
			'qty' => $row->qty,
			'tgl' => $row->tgl,
			'bulan' => $row->bulan,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/penjualan/penjualan_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }
	
	// Fungsi menampilkan form Create produk
    public function create(){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$data['produk'] = $this->Produk_model->get_produk();
    
		// Menampung data yang diinputkan
		$form_data = array(
			'button' => 'Create',
			'back'   => site_url('penjualan'),
			'action' => site_url('penjualan/create_action'),
			'kd_detail_pesanan' => set_value('kd_detail_pesanan'),
			'nama_produk' => set_value('nama_produk'),
			'qty' => set_value('qty'),
			'total_harga' => set_value('total_harga'),
		);
	
		// Menggabungkan data form dengan data produk
		$data = array_merge($data, $form_data);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/penjualan/penjualan_form', $data);
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

			$tanggal_pesan = date('dd-mm-yy');
			$jam_pesan = date('H:i:s');

			$data = array(
			'kd_detail_pesanan' => $this->input->post('kd_detail_pesanan',TRUE),
			'nama_produk' => $this->input->post('nama_produk',TRUE), 
			'total_harga' => $this->input->post('total_harga',TRUE),
			'qty' => $this->input->post('qty',TRUE),	
			'tgl' => $this->input->post('tgl',TRUE),
			'bulan' => konversiNamaBulan(date('F', strtotime($tanggal_pesan)))
		);
		$this->Penjualan_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('penjualan'));
	}
			
}
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Penjualan_model->get_by_id($id);
		$data['produk'] = $this->Produk_model->get_produk();
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $form_data = array(
            'button' => 'Update',
			'back'   => site_url('penjualan'),
            'action' => site_url('penjualan/update_action'),
			'kd_detail_pesanan' => $row->kd_detail_pesanan,
			'nama_produk' => $row->nama_produk,
			'total_harga' => $row->total_harga,
			'qty' => $row->qty,
		);

		$data = array_merge($data, $form_data);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/penjualan/penjualan_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('penjualan'));
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
			$this->update($this->input->post('kd_detail_pesanan', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			$tanggal_pesan = date('Y-m-d');
			$jam_pesan = date('H:i:s');
			
			$data = array(
				'kd_detail_pesanan' => $this->input->post('kd_detail_pesanan',TRUE),
				'nama_produk' => $this->input->post('nama_produk',TRUE), 
				'total_harga' => $this->input->post('total_harga',TRUE),
				'qty' => $this->input->post('qty',TRUE),	
				'tgl' => $tanggal_pesan,
				'bulan' => konversiNamaBulan(date('F', strtotime($tanggal_pesan)))
			);
			$this->Penjualan_model->update($this->input->post('kd_detail_pesanan', TRUE), $data);
			//  $this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('penjualan'));
		}
	}
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Penjualan_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Penjualan_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('penjualan'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penjualan'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('nama_produk', 'nama_produk', 'trim|required');
	$this->form_validation->set_rules('total_harga', 'total_harga', 'required');
	$this->form_validation->set_rules('qty', 'qty', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
