<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Kehadiran extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Kehadiran_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('Karyawan_model'); // Memanggil produk_model yang terdapat pada models
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
		$this->load->view('pages/kehadiran/kehadiran_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Kehadiran_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM kehadiran
		          WHERE kd_hadir = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data kehadiran tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('kehadiran'),
			'kd_hadir' => $row->kd_hadir,
			'nama_karyawan' => $row->nama_karyawan,
			'tgl' => $row->tgl,
			'jam' => $row->jam,
			'keterangan' => $row->keterangan,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/kehadiran/kehadiran_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kehadiran'));
        }
    }
	
	// Fungsi menampilkan form Create produk
    public function create(){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		$data['karyawan'] = $this->Karyawan_model->get_karyawan();
		// Menampung data yang diinputkan
        $form_data = array(
            'button' => 'Create',
			'back'   => site_url('kehadiran'),
            'action' => site_url('kehadiran/create_action'),
			'kd_hadir' => set_value('kd_hadir'),
			'nama_karyawan' => set_value('nama_karyawan'),
            'tgl' => set_value('tgl'),
			'jam' => set_value('jam'),
           	'keterangan' => set_value('keterangan'),
		);
		$data = array_merge($data, $form_data);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/kehadiran/kehadiran_form', $data);
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

			date_default_timezone_set('asia/jakarta');
			$data = array(
			'kd_hadir' => $this->input->post('kd_hadir',TRUE),
			'nama_karyawan' => $this->input->post('nama_karyawan',TRUE), 
			'tgl' => $this->input->post('tgl',TRUE),
			'jam' => date('H:i:s'),
			'keterangan' => $this->input->post('keterangan',TRUE),	
		);
		$this->Kehadiran_model->insert($data);
		// $this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('kehadiran'));
	}
			
}
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Kehadiran_model->get_by_id($id);
		$data['karyawan'] = $this->Karyawan_model->get_karyawan();
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $form_data = array(
            'button' => 'Update',
			'back'   => site_url('kehadiran'),
            'action' => site_url('kehadiran/update_action'),
			'kd_hadir' => $row->kd_hadir,
			'nama_karyawan' => $row->nama_karyawan,
			'tgl' => $row->tgl,
			'jam' => $row->jam,
			'keterangan' => $row->keterangan,
		);

		$data = array_merge($data, $form_data);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/kehadiran/kehadiran_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('kehadiran'));
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
			$this->update($this->input->post('kd_hadir', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			 date_default_timezone_set('Asia/Jakarta');
			 $data = array(
				'kd_hadir' => $this->input->post('kd_hadir',TRUE),
				'nama_karyawan' => $this->input->post('nama_karyawan',TRUE), 
				'tgl' => $this->input->post('tgl',TRUE),
				'jam' => date('H:i:s'),
				'keterangan' => $this->input->post('keterangan',TRUE),	
			);
			$this->Kehadiran_model->update($this->input->post('kd_hadir', TRUE), $data);
			redirect(site_url('kehadiran'));
		}
	}
			
			//  $this->session->set_flashdata('message', 'Create Record Success');
	        
        
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Kehadiran_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Kehadiran_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kehadiran'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kehadiran'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('nama_karyawan', 'nama_karyawan', 'trim|required');
	$this->form_validation->set_rules('tgl', 'tgl', 'required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
?>
