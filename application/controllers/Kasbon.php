<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class kasbon extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('Kasbon_model'); // Memanggil produk_model yang terdapat pada models
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
		$this->load->view('pages/kasbon/kasbon_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->Kasbon_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM kasbon
		          WHERE kd_kasbon = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data kasbon tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('kasbon'),
			'kd_kasbon' => $row->kd_kasbon,
			'nama' => $row->nama,
			'alamat' => $row->alamat,
			'via' => $row->via,
			'tgl_kasbon' => $row->tgl_kasbon,
			'jml_kasbon' => $row->jml_kasbon,
			'bayar' => $row->bayar,
			'tgl' => $row->tgl,
			'saldo_akhir' => $row->saldo_akhir,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/kasbon/kasbon_read', $data);
			$this->load->view('templates/footer');
			$this->load->view('templates/jquery');
		} 
		// Jika data produk tidak tersedia maka akan ditampilkan informasi 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kasbon'));
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
			'back'   => site_url('kasbon'),
            'action' => site_url('kasbon/create_action'),
			'kd_kasbon' => set_value('kd_kasbon'),
			'nama' => set_value('nama'),
			'alamat' => set_value('alamat'),
			'via' => set_value('via'),
			'bayar' => set_value('bayar'),
			'tgl_kasbon' => set_value('tgl_kasbon'),
			'jml_hutang' => set_value('jml_hutang'),
			'ket' => set_value('ket'),
			'saldo_akhir' => set_value('saldo_akhir'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/kasbon/kasbon_form', $data);
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
			$saldo_akhir_sebelumnya = $this->Kasbon_model->get_saldo_akhir_terakhir();
	
			// Saldo akhir yang akan disimpan untuk data baru adalah saldo akhir sebelumnya ditambahkan dengan biaya pembayaran
			$saldo_akhir_baru = $saldo_akhir_sebelumnya + $biaya_pembayaran;
	
			$data = array(
				'kd_kasbon' => $this->input->post('kd_kasbon',TRUE),
				'nama' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'bayar' => $biaya_pembayaran, // Simpan nilai bayar
				'tgl_kasbon' => $this->input->post('tgl_kasbon'),
				'via' => $this->input->post('via'),
				'jml_hutang' => $this->input->post('jml_hutang'),
				'ket' => $this->input->post('ket'),
				'saldo_akhir' => $saldo_akhir_baru,
			);
	
			$this->Kasbon_model->insert($data);
			redirect(site_url('kasbon'));
		}   
	}
	
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->Kasbon_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('kasbon'),
            'action' => site_url('kasbon/update_action'),
			'kd_kasbon' => $row->kd_kasbon,
			'nama' => $row->nama,
			'alamat' => $row->alamat,
			'via' => $row->via,
			'tgl_kasbon' => $row->tgl_kasbon,
			'jml_hutang' => $row->jml_hutang,
			'bayar' => $row->bayar,
			'saldo_akhir' => $row->saldo_akhir,
			'ket' => $row->ket,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/kasbon/kasbon_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		// $this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('kasbon'));
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
			$this->update($this->input->post('kd_kasbon', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			// Mendapatkan nilai biaya dari inputan form
			$biaya_pembayaran = $this->input->post('bayar');
	
			// Jika jumlah pembayaran tidak kosong
			if (!empty($biaya_pembayaran)) {
				// Ambil saldo_akhir sebelumnya dari database
				$saldo_sebelumnya = $this->Kasbon_model->get_saldo_sebelumnya($this->input->post('kd_kasbon', TRUE));
	
				// Hitung saldo_akhir baru
				$saldo_akhir_baru = $saldo_sebelumnya + $biaya_pembayaran;
	
				// Data untuk disimpan ke dalam database
				$data = array(
					'kd_kasbon' => $this->input->post('kd_kasbon', TRUE),
					'nama' => $this->input->post('nama'),
					'alamat' => $this->input->post('alamat'),
					'bayar' => $biaya_pembayaran,
					'tgl_kasbon' => $this->input->post('tgl_kasbon'),
					'via' => $this->input->post('via'),
					'jml_hutang' => $this->input->post('jml_hutang'),
					'ket' => $this->input->post('ket'),
					'saldo_akhir' => $saldo_akhir_baru,
				);
	
				$this->Kasbon_model->update($this->input->post('kd_kasbon', TRUE), $data);
				redirect(site_url('kasbon'));
			} else {
				// Jika jumlah pembayaran kosong, tampilkan pesan kesalahan
				$this->session->set_flashdata('error', 'Kolom bayar harus diisi');
				redirect(site_url('kasbon'));
			}
		}
	}
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->Kasbon_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->Kasbon_model->delete($id);
            // $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kasbon'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            // $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kasbon'));
        }
    }
	
	// Fungsi rules atau aturan untuk pengisian pada form (create/input dan update)
    public function _rules() {
	$this->form_validation->set_rules('nama', 'nama', 'required');
	$this->form_validation->set_rules('alamat', 'alamat', 'required');
	$this->form_validation->set_rules('tgl_kasbon', 'tgl_kasbon', 'required');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
?>
