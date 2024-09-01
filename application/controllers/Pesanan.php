<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pesanan extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Pesanan_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('Umum_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('Warung_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('WarungKomit_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('users_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->helper('indonsiatgl'); // Memanggil datatables yang terdapat pada library
		
    }
	
	// Fungsi untuk menampilkan halaman produk
    public function index() {	
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/pesanan/pesanan_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Pesanan_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM pesanan
		          WHERE kd_pesan = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data pesanan tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('pesanan'),
			'kd_pesan' => $row->kd_pesan,
			'tgl_pesan' => $row->tgl_pesan,
			'jam' => $row->jam,
			'pelanggan' => $row->pelanggan,
			'nama' => $row->nama,
			'total_harga' => $row->total_harga,
			'pembayaran' => $row->pembayaran,
			'pengirim' => $row->pengirim,
			'ongkir' => $row->ongkir,
			'delivery' => $row->delivery,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/pesanan/pesanan_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pesanan'));
        }
    }
	
	// Fungsi menampilkan form Create produk
    public function create(){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	

		date_default_timezone_set('Asia/Jakarta');
		
		// Menampung data yang diinputkan
        $data = array(
            'button' => 'Create',
			'back'   => site_url('pesanan'),
            'action' => site_url('pesanan/create_action'),
			'kd_pesan' => set_value('kd_pesan'),
			'tgl_pesan' => set_value('tgl_pesan'),
			'jam' => date('H:i:s'),
			'pelanggan' => set_value('pelanggan'),
			'nama' => set_value('nama'),
			'total_harga' => set_value('total_harga'),
			'pembayaran' => set_value('pembayaran'),
			'pengirim' => set_value('pengirim'),
			'ongkir' => set_value('ongkir'),
			'delivery' => set_value('delivery'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/pesanan/pesanan_form', $data);
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

			$data = array(
				'kd_pesan' => $this->input->post('kd_pesan',TRUE),
				'tgl_pesan' => $this->input->post('tgl_pesan',TRUE),
				'jam' => $this->input->post('jam',TRUE),
				'pelanggan' => $this->input->post('pelanggan',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'total_harga' => $this->input->post('total_harga',TRUE),
				'pembayaran' => $this->input->post('pembayaran',TRUE),
				'pengirim' => $this->input->post('pengirim',TRUE),
				'ongkir' => $this->input->post('ongkir',TRUE),
				'delivery' => $this->input->post('delivery',TRUE),
		);
		$this->Pesanan_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('pesanan'));
	}
			
}
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Pesanan_model->get_by_id($id);
		// $data['defaultJam'] = date('H:i:s');

		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('pesanan'),
            'action' => site_url('pesanan/update_action'),
			'kd_pesan' => $row->kd_pesan,
			'tgl_pesan' => $row->tgl_pesan,
			'jam' => $row->jam,
			'pelanggan' => $row->pelanggan,
			'nama' => $row->nama,
			'total_harga' => $row->total_harga,
			'pembayaran' => $row->pembayaran,
			'pengirim' => $row->pengirim,
			'ongkir' => $row->ongkir,
			'delivery' => $row->delivery,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/pesanan/pesanan_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('pesanan'));
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
			$this->update($this->input->post('kd_pesan', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			 //Buat slug
			 $data = array(
				// 'kd_pesan' => $this->input->post('kd_pesan',TRUE),
				'tgl_pesan' => $this->input->post('tgl_pesan',TRUE),
				'jam' => $this->input->post('jam',TRUE),
				'pelanggan' => $this->input->post('pelanggan',TRUE),
				'nama' => $this->input->post('nama',TRUE),
				'total_harga' => $this->input->post('total_harga',TRUE),
				'pembayaran' => $this->input->post('pembayaran',TRUE),
				'pengirim' => $this->input->post('pengirim',TRUE),
				'ongkir' => $this->input->post('ongkir',TRUE),
				'delivery' => $this->input->post('delivery',TRUE),
			);
			$this->Pesanan_model->update($this->input->post('kd_pesan', TRUE), $data);
			$this->Umum_model->update_data_pesanan_umum($data['pelanggan'], $data);
			$this->Warung_model->update_data_pesanan_warung($data['pelanggan'], $data);
			$this->WarungKomit_model->update_data_pesanan_warung_komit($data['pelanggan'], $data);

			$this->Umum_model->hapus_data_terkait($this->input->post('kd_pesan', TRUE));
        	$this->Warung_model->hapus_data_terkait($this->input->post('kd_pesan', TRUE));
        	$this->WarungKomit_model->hapus_data_terkait($this->input->post('kd_pesan', TRUE));

        // Insert kembali data pesanan dengan status yang baru ke tabel yang sesuai
        if ($data['pelanggan'] == 'umum') {
            $this->Umum_model->insert_data_pesanan_umum($data);
        } elseif ($data['pelanggan'] == 'warung') {
            $this->Warung_model->insert_data_pesanan_warung($data);
        } elseif ($data['pelanggan'] == 'warung komitmen') {
            $this->WarungKomit_model->insert_data_pesanan_warung_komit($data);
        }
			redirect(site_url('pesanan'));
		}
	}
			
			//  $this->session->set_flashdata('message', 'Create Record Success');
	        
        
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Pesanan_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Pesanan_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
			$this->db->where('kd_pesan', $id);
			$this->db->delete('umum');

			 // Hapus entri terkait dari tabel warung
			 $this->db->where('kd_pesan', $id);
			 $this->db->delete('warung');

			 $this->db->where('kd_pesan', $id);
			 $this->db->delete('warung_komit');
	
            redirect(site_url('pesanan'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pesanan'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('tgl_pesan', 'tgl_pesan', 'trim|required');
	$this->form_validation->set_rules('pelanggan', 'pelanggan', 'required');
	$this->form_validation->set_rules('jam', 'jam', 'required');
	$this->form_validation->set_rules('total_harga', 'total_harga', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
?>
