<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hutang extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Hutang_model'); // Memanggil produk_model yang terdapat pada models
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
		$this->load->view('pages/hutang/hutang_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Hutang_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM hutang_top
		          WHERE kd_top = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data hutang tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('hutang'),
			'kd_top' => $row->kd_top,
			'nama' => $row->nama,
			'alamat' => $row->alamat,
			'via' => $row->via,
			'tgl_hutang' => $row->tgl_hutang,
			'jml_kasbon' => $row->jml_kasbon,
			'bayar' => $row->bayar,
			'tgl' => $row->tgl,
			'saldo_akhir' => $row->saldo_akhir,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/hutang/hutang_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hutang'));
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
			'back'   => site_url('hutang'),
            'action' => site_url('hutang/create_action'),
			'kd_top' => set_value('kd_top'),
			'nama' => set_value('nama'),
			'alamat' => set_value('alamat'),
			'via' => set_value('via'),
			'bayar' => set_value('bayar'),
			'tgl_hutang' => set_value('tgl_hutang'),
			'total_hutang' => set_value('total_hutang'),
			'ket' => set_value('ket'),
			'saldo_akhir' => set_value('saldo_akhir'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/hutang/hutang_form', $data);
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
			$biaya_pembayaran = $this->input->post('bayar'); // Ambil nilai dari kolom bayar
	
			// Ambil saldo_akhir terakhir dari database
			$saldo_akhir_sebelumnya = $this->Hutang_model->get_saldo_akhir_terakhir();
	
			// Saldo akhir yang akan disimpan untuk data baru adalah saldo akhir sebelumnya ditambahkan dengan biaya pembayaran
			$saldo_akhir_baru = $saldo_akhir_sebelumnya + $biaya_pembayaran;
	
			$data = array(
				'kd_top' => $this->input->post('kd_top',TRUE),
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'bayar' => $biaya_pembayaran, // Simpan nilai bayar
				'tgl_hutang' => $this->input->post('tgl_hutang'),
				'via' => $this->input->post('via'),
				'total_hutang' => $this->input->post('total_hutang'),
				'ket' => $this->input->post('ket'),
				'saldo_akhir' => $saldo_akhir_baru,
			);
	
			$this->Hutang_model->insert($data);
			redirect(site_url('hutang'));
		}   
	}
	
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Hutang_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('hutang'),
            'action' => site_url('hutang/update_action'),
			'kd_top' => $row->kd_top,
			'nama' => $row->nama,
			'alamat' => $row->alamat,
			'via' => $row->via,
			'tgl_hutang' => $row->tgl_hutang,
			'total_hutang' => $row->total_hutang,
			'bayar' => $row->bayar,
			'saldo_akhir' => $row->saldo_akhir,
			'ket' => $row->ket,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/hutang/hutang_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('hutang'));
	}
}
    
	// Fungsi untuk melakukan aksi update data
	public function update_action() {
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
		$this->_rules(); // Rules atau aturan bahwa setiap form harus diisi
		
		// Jika form produk belum diisi dengan benar 
		// maka sistem akan meminta user untuk menginput ulang
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('kd_top', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
				$data = array(
					'kd_top' => $this->input->post('kd_top', TRUE),
					'nama' => $this->input->post('nama'),
					'alamat' => $this->input->post('alamat'),
					'bayar' => $this->input->post('bayar'),
					'tgl_hutang' => $this->input->post('tgl_hutang'),
					'via' => $this->input->post('via'),
					'total_hutang' => $this->input->post('total_hutang'),
					'ket' => $this->input->post('ket'),
					'saldo_akhir' => $this->input->post('saldo_akhir'),
				);
	
				$this->Hutang_model->update($this->input->post('kd_top', TRUE), $data);
				$this->session->set_flashdata('message', 'Update Record Success');
				redirect(site_url('hutang'));
			}
		}
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Hutang_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Hutang_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('hutang'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('hutang'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('nama', 'nama', 'required');
	$this->form_validation->set_rules('alamat', 'alamat', 'required');
	$this->form_validation->set_rules('tgl_hutang', 'tgl_hutang', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
?>
