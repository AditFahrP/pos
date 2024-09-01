<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pengeluaran extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Pengeluaran_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('users_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
    }
	
	// Fungsi untuk menampilkan halaman produk
    public function index() {	
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/pengeluaran/pengeluaran_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Pengeluaran_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM pengeluaran
		          WHERE kd_pengeluaran = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data pengeluaran tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('pengeluaran'),
			'kd_pengeluaran' => $row->kd_pengeluaran,
			'pengeluaran' => $row->pengeluaran,
			'pengeluaran_untuk' => $row->pengeluaran_untuk,
			'biaya' => $row->biaya,
			'tgl' => $row->tgl,
			'jam' => $row->jam,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/pengeluaran/pengeluaran_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaran'));
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
			'back'   => site_url('pengeluaran'),
            'action' => site_url('pengeluaran/create_action'),
			'kd_pengeluaran' => set_value('kd_pengeluaran'),
			'pengeluaran' => set_value('pengeluaran'),
			'pengeluaran_untuk' => set_value('pengeluaran_untuk'),
			'biaya' => set_value('biaya'),
			'tgl' => set_value('tgl'),
			// 'jam' => set_value('jam'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/pengeluaran/pengeluaran_form', $data);
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
			date_default_timezone_set('Asia/Jakarta');
			$data = array(
			'kd_pengeluaran' => $this->input->post('kd_pengeluaran',TRUE),
			'pengeluaran' => $this->input->post('pengeluaran'),
			'pengeluaran_untuk' => $this->input->post('pengeluaran_untuk'),
			'biaya' => $this->input->post('biaya'),
			'tgl' => $this->input->post('tgl'),
			'jam' => date('H:i:s'),
		);
		$this->Pengeluaran_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('pengeluaran'));
	}
			
}
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Pengeluaran_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('pengeluaran'),
            'action' => site_url('pengeluaran/update_action'),
			'kd_pengeluaran' => $row->kd_pengeluaran,
			'pengeluaran' => $row->pengeluaran,
			'pengeluaran_untuk' => $row->pengeluaran_untuk,
			'biaya' => $row->biaya,
			'tgl' => $row->tgl,
			// 'jam' => $row->jam,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/pengeluaran/pengeluaran_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('pengeluaran'));
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
			$this->update($this->input->post('kd_pengeluaran', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			date_default_timezone_set('Asia/Jakarta');

			 $data = array(
				 'kd_pengeluaran' => $this->input->post('kd_pengeluaran',TRUE),
				 'pengeluaran' => $this->input->post('pengeluaran'),
				 'pengeluaran_untuk' => $this->input->post('pengeluaran_untuk'),
				 'biaya' => $this->input->post('biaya'),
				 'tgl' => $this->input->post('tgl'),
				 'jam' => date('H:i:s'),
			);
			$this->Pengeluaran_model->update($this->input->post('kd_pengeluaran', TRUE), $data);
			redirect(site_url('pengeluaran'));
		}
	}
			
			//  $this->session->set_flashdata('message', 'Create Record Success');
	        
        
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Pengeluaran_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Pengeluaran_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengeluaran'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengeluaran'));
        }
    }

	public function hapus_data() {
        // Panggil fungsi truncate pada model atau langsung pada database
        $this->db->truncate('pengeluaran');
        
        // Tampilkan pesan sukses atau lakukan pengalihan halaman
        redirect('pengeluaran');
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('pengeluaran', 'pengeluaran', 'trim|required');
	$this->form_validation->set_rules('pengeluaran_untuk', 'pengeluaran_untuk', 'required');
	$this->form_validation->set_rules('biaya', 'biaya', 'required');
	$this->form_validation->set_rules('tgl', 'tgl', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
?>
