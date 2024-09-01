<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Keuangan extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Keuangan_model'); // Memanggil produk_model yang terdapat pada models
		$this->load->model('Pembelian_model');
		$this->load->model('Pesanan_model');
		$this->load->model('Pengeluaran_model');
        $this->load->model('users_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman produk
    public function index() {
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		};

		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/keuangan/keuangan_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Keuangan_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		};	
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM keuangan
		          WHERE kd_uang = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data keuangan tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('keuangan'),
			'kd_uang' => $row->kd_uang,
			'tgl' => $row->tgl,
			'pendapatan' => $row->pendapatan,
			'pengeluaran' => $row->pengeluaran,
			'saldo_awal' => $row->saldo_awal,
			'saldo_akhir' => $row->saldo_akhir,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/keuangan/keuangan_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('keuangan'));
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
			'back'   => site_url('keuangan'),
            'action' => site_url('keuangan/create_action'),
			'kd_uang' => set_value('kd_uang'),
			'tgl' => set_value('tgl'),
			'saldo_awal' => set_value('saldo_awal'),
			'saldo_akhir' => set_value('saldo_akhir'),
			'pendapatan' => set_value('pendapatan'),
			'pengeluaran' => set_value('pengeluaran'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/keuangan/keuangan_form', $data);
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
			$tanggal_keuangan = date('d-m-Y');
			$saldo_awal = $this->input->post('saldo_awal');
	
			// Ambil total biaya dari tabel pengeluaran berdasarkan tanggal keuangan
			$this->db->select_sum('total_harga');
			$this->db->where('tgl_produk_masuk', $tanggal_keuangan);
			$query_detail_pesanan = $this->db->get('pembelian');
			$total_harga_pembelian = $query_detail_pesanan->row()->total_harga;
		
			$this->db->select_sum('biaya');
			$this->db->where('tgl', $tanggal_keuangan);
			$query_pengeluaran = $this->db->get('pengeluaran');
			$total_biaya_pengeluaran = $query_pengeluaran->row()->biaya;
			
			$this->db->select_sum('total_harga');
			$this->db->where('tgl', $tanggal_keuangan);
			$query_detail_pesanan = $this->db->get('detail_pesanan');
			$total_harga_detail_pesanan = $query_detail_pesanan->row()->total_harga;
	
			// Hitung total pengeluaran (jumlah total harga detail pesanan dan total biaya pengeluaran)
			$total_pendapatan = $total_harga_detail_pesanan;
	
			$total_pengeluaran = $total_biaya_pengeluaran + $total_harga_pembelian;
	
			$total_saldo_akhir = $saldo_awal + $total_pendapatan - $total_pengeluaran;
	
			// Data yang akan dimasukkan ke dalam database
			$data = array(
				'tgl' => $tanggal_keuangan,
				'saldo_awal' => $saldo_awal,
				'saldo_akhir' => $total_saldo_akhir,
				'pendapatan' => $total_pendapatan,
				'pengeluaran' => $total_pengeluaran,
			);
	
			// Insert data ke dalam tabel keuangan
			$this->Keuangan_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('keuangan'));
	}
			
}
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Keuangan_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('keuangan'),
            'action' => site_url('keuangan/update_action'),
			'kd_uang' => $row->kd_uang,
			'tgl' => $row->tgl,
			'pendapatan' => $row->pendapatan,
			'pengeluaran' => $row->pengeluaran,
			'saldo_awal' => $row->saldo_awal,
			'saldo_akhir' => $row->saldo_akhir,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/keuangan/keuangan_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('keuangan'));
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
			$this->update($this->input->post('kd_uang', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			 //Buat slug
			 $data = array(
				 'tgl' => date('d-m-Y'), 
				 'saldo_awal' => $this->input->post('saldo_awal',TRUE), 
				 'saldo_akhir' => $this->input->post('saldo_akhir',TRUE), 
				 'pendapatan' => $this->input->post('pendapatan',TRUE), 
				 'pengeluaran' => $this->input->post('pengeluaran',TRUE), 
			);
			$this->Keuangan_model->update($this->input->post('kd_uang', TRUE), $data);
			redirect(site_url('keuangan'));
		}
	}
			
			//  $this->session->set_flashdata('message', 'Create Record Success');
	        
        
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Keuangan_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Keuangan_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('keuangan'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('keuangan'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('saldo_awal', 'nama_keuangan', 'trim|required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

