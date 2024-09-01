<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pembelian extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Pembelian_model'); // Memanggil Pembelian_model yang terdapat pada models
        $this->load->model('Produk_model'); // Memanggil Pembelian_model yang terdapat pada models
        $this->load->model('users_model'); // Memanggil Pembelian_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->helper(['rupiah_helper', 'url', 'form', 'string' ]);
		$this->load->helper('date');

    }
	
	// Fungsi untuk menampilkan halaman produk
    public function index() {
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/pembelian/pembelian_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Pembelian_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM pembelian
		          WHERE kd_beli = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data produk tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('pembelian'),
			'kd_beli' => $row->kd_beli,
			'nama_produk' => $row->nama_produk,
			'kategori_produk' => $row->kategori_produk,
			'jml_produk' => $row->jml_produk,
			'harga_produk' => $row->harga_produk,
			'total_harga' => $row->total_harga,
			'tgl_produk_masuk' => $row->tgl_produk_masuk,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/pembelian/pembelian_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
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
			'back'   => site_url('pembelian'),
            'action' => site_url('pembelian/create_action'),
			'kd_beli' => set_value('kd_beli'),
			'nama_produk' => set_value('nama_produk'),
            'kategori_produk' => set_value('kategori_produk'),
			'jml_produk' => set_value('jml_produk'),
           	'harga_produk' => set_value('harga_produk'),
           	'total_harga' => set_value('total_harga'),
           	'tgl_produk_masuk' => set_value('tgl_produk_masuk'),
		);

		$data = array_merge($data, $form_data);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/pembelian/pembelian_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
    
	// Fungsi untuk melakukan aksi simpan data
    public function create_action() {
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
			$data = array(
				'kd_beli' => $this->input->post('kd_beli',TRUE),
				'nama_produk' => $this->input->post('nama_produk',TRUE), 
				'kategori_produk' => $this->input->post('kategori_produk',TRUE),
				'jml_produk' => $this->input->post('jml_produk',TRUE),
				'harga_produk' => $this->input->post('harga_produk',TRUE),
				'total_harga' => $this->input->post('total_harga',TRUE),
				'tgl_produk_masuk' => $this->input->post('tgl_produk_masuk',TRUE),

			);
			$this->Pembelian_model->insert($data); // Simpan data pembelian
	
			$nama_produk = $this->input->post('nama_produk', TRUE);
			$jml_produk = $this->input->post('jml_produk', TRUE);
			$this->tambahJumlahProduk($nama_produk, $jml_produk); // Panggil fungsi untuk menambah jumlah produk
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('pembelian'));
		}
	}
			
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Pembelian_model->get_by_id($id);
		$data['produk'] = $this->Produk_model->get_produk();
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $form_data = array(
            'button' => 'Update',
			'back'   => site_url('pembelian'),
            'action' => site_url('pembelian/update_action'),
			'kd_beli' => $row->kd_beli,
			'nama_produk' =>  $row->nama_produk,
            'kategori_produk' =>  $row->kategori_produk,
			'jml_produk' =>  $row->jml_produk,
           	'harga_produk' =>  $row->harga_produk,
           	'total_harga' =>  $row->total_harga,
           	'tgl_produk_masuk' =>  $row->tgl_produk_masuk,
		);

		$data = array_merge($data, $form_data);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/pembelian/pembelian_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		$this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('pembelian'));
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
			$this->update($this->input->post('kd_beli', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {

			$data = array(
				'kd_beli' => $this->input->post('kd_beli',TRUE),
				'nama_produk' => $this->input->post('nama_produk',TRUE), 
				'kategori_produk' => $this->input->post('kategori_produk',TRUE),
				'jml_produk' => $this->input->post('jml_produk',TRUE),
				'harga_produk' => $this->input->post('harga_produk',TRUE),
				'tgl_produk_masuk' => $this->input->post('tgl_produk_masuk',TRUE),
				'total_harga' => $this->input->post('total_harga',TRUE),
			);
			
			$this->Pembelian_model->update($this->input->post('kd_beli', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('pembelian'));
		}
	}

	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Pembelian_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Pembelian_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pembelian'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pembelian'));
        }
    }

	private function tambahJumlahProduk($nama_produk, $jml_produk) {
		// Mencari produk berdasarkan nama_produk
		$produk = $this->Produk_model->get_by_nama_produk($nama_produk);
	
		// Jika produk ditemukan, tambahkan jumlah produk
		if ($produk) {
			$jumlah_sekarang = $produk->jml_produk;
			$jumlah_baru = $jumlah_sekarang + $jml_produk;
	
			// Update jumlah produk di dalam tabel produk
			$this->Produk_model->update_jumlah_produk($produk->kd_produk, $jumlah_baru);
		}
	}
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('nama_produk', 'nama_produk', 'trim|required');
	$this->form_validation->set_rules('kategori_produk', 'kategori_produk', 'required');
	$this->form_validation->set_rules('jml_produk', 'jml_produk', 'required');
	$this->form_validation->set_rules('harga_produk', 'harga_produk', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
