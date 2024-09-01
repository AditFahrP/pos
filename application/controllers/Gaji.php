<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gaji extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Gaji_model'); // Memanggil produk_model yang terdapat pada models
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
		$this->load->view('pages/gaji/gaji_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Gaji_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM gaji
		          WHERE kd_gaji = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data gaji tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('gaji'),
			'kd_gaji' => $row->kd_gaji,
			'tgl_pesan' => $row->tgl_pesan,
			'jam' => $row->jam,
			'pelanggan' => $row->pelanggan,
			'total_harga' => $row->total_harga,
			'pembayaran' => $row->pembayaran,
			'pengirim' => $row->pengirim,
			'ongkir' => $row->ongkir,
			'delivery' => $row->delivery,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/gaji/gaji_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gaji'));
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
			'back'   => site_url('gaji'),
            'action' => site_url('gaji/create_action'),
			'kd_gaji' => set_value('kd_gaji'),
			'tgl_pesan' => set_value('tgl_pesan'),
			'jam' => date('H:i:s'),
			'pelanggan' => set_value('pelanggan'),
			'total_harga' => set_value('total_harga'),
			'pembayaran' => set_value('pembayaran'),
			'pengirim' => set_value('pengirim'),
			'ongkir' => set_value('ongkir'),
			'delivery' => set_value('delivery'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/gaji/gaji_form', $data);
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
				'kd_gaji' => $this->input->post('kd_gaji',TRUE),
				'tgl_pesan' => $this->input->post('tgl_pesan',TRUE),
				'jam' => $this->input->post('jam',TRUE),
				'pelanggan' => $this->input->post('pelanggan',TRUE),
				'total_harga' => $this->input->post('total_harga',TRUE),
				'pembayaran' => $this->input->post('pembayaran',TRUE),
				'pengirim' => $this->input->post('pengirim',TRUE),
				'ongkir' => $this->input->post('ongkir',TRUE),
				'delivery' => $this->input->post('delivery',TRUE),
		);
		$this->Gaji_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('gaji'));
	}
			
}
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Gaji_model->get_by_id($id);
		// $data['defaultJam'] = date('H:i:s');

		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('gaji'),
            'action' => site_url('gaji/update_action'),
			'kd_gaji' => $row->kd_gaji,
			'tgl_pesan' => $row->tgl_pesan,
			'jam' => $row->jam,
			'pelanggan' => $row->pelanggan,
			'total_harga' => $row->total_harga,
			'pembayaran' => $row->pembayaran,
			'pengirim' => $row->pengirim,
			'ongkir' => $row->ongkir,
			'delivery' => $row->delivery,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/gaji/gaji_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('gaji'));
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
			$this->update($this->input->post('kd_gaji', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			 //Buat slug
			 $data = array(
				'kd_gaji' => $this->input->post('kd_gaji',TRUE),
				'tgl_pesan' => $this->input->post('tgl_pesan',TRUE),
				'jam' => $this->input->post('jam',TRUE),
				'pelanggan' => $this->input->post('pelanggan',TRUE),
				'total_harga' => $this->input->post('total_harga',TRUE),
				'pembayaran' => $this->input->post('pembayaran',TRUE),
				'pengirim' => $this->input->post('pengirim',TRUE),
				'ongkir' => $this->input->post('ongkir',TRUE),
				'delivery' => $this->input->post('delivery',TRUE),
			);
			$this->Gaji_model->update($this->input->post('kd_gaji', TRUE), $data);
			redirect(site_url('gaji'));
		}
	}
			
			//  $this->session->set_flashdata('message', 'Create Record Success');
	        
        
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Gaji_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Gaji_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('gaji'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('gaji'));
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
