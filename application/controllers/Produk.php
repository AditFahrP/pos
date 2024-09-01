<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Produk extends CI_Controller {
	// Konstruktor	
	function __construct() {
        parent::__construct();
        $this->load->model('produk_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->model('users_model'); // Memanggil produk_model yang terdapat pada models
        $this->load->library('form_validation'); // Memanggil form_validation yang terdapat pada library
		$this->load->library('upload'); // Memanggil upload yang terdapat pada helper
		$this->load->library('datatables'); // Memanggil datatables yang terdapat pada library
		$this->load->helper(['rupiah_helper', 'url', 'form', 'string', 'export_pdf']);
		$this->load->helper('date');

    }
	
	// Fungsi untuk menampilkan halaman produk
    public function index() {
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/produk/produk_list');
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
    }
	
	// Fungsi JSON
	public function json() {
        header('Content-Type: application/json');
        echo $this->produk_model->json();
    }
	
	// Fungsi untuk menampilkan halaman produk secara detail
    public function read($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
		
		// Query untuk menampilkan produk dan program studinya
		$sql   = "SELECT * FROM produk
		          WHERE kd_produk = '$id'";		
		$row = $this->db->query($sql)->row();			
		
		// Jika data produk tersedia maka akan ditampilkan
        if ($row) {
			$data = array(
			'button' => 'Read',
			'back'   => site_url('produk'),
			'kd_produk' => $row->kd_produk,
			'nama_produk' => $row->nama_produk,
			'kategori_produk' => $row->kategori_produk,
			'jml_produk' => $row->jml_produk,
			'harga_produk' => $row->harga_produk,
			'tgl_produk_masuk' => $row->tgl_produk_masuk,
			'foto_produk' => $row->foto_produk,
			// 'gaji' => $row->gaji,
			);
			
			$this->load->view('templates/header');
			$this->load->view('templates/side_bar');
			$this->load->view('pages/produk/produk_read', $data);
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
		
		// Menampung data yang diinputkan
        $data = array(
            'button' => 'Create',
			'back'   => site_url('produk'),
            'action' => site_url('produk/create_action'),
			'kd_produk' => set_value('kd_produk'),
            'slug' => set_value('slug'),
			'nama_produk' => set_value('nama_produk'),
            'kategori_produk' => set_value('kategori_produk'),
			'jml_produk' => set_value('jml_produk'),
           	'harga_produk' => set_value('harga_produk'),
           	'tgl_produk_masuk' => set_value('tgl_produk_masuk'),
           	'foto_produk' => set_value('foto_produk'),
           	// 'gaji' => set_value('gaji'),
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/produk/produk_form', $data);
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
			$nama = $this->input->post('nama_produk');
			$string=preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $nama); //filter karakter unik dan replace dengan kosong ('')
			$trim=trim($string); // hilangkan spasi berlebihan dengan fungsi trim
			$pre_slug=strtolower(str_replace(" ", "-", $trim)); // hilangkan spasi, kemudian ganti spasi dengan tanda strip (-)
			$slug=$pre_slug.'.html';

			$config['upload_path']   = 'images/fotoproduk/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('nama_produk')); //nama file gambar dirubah menjadi nama berdasarkan judul_gallery	
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			$datafoto_produk ='';
			
			if (!empty($_FILES['foto_produk']['name'])) {
				$this->upload->do_upload('foto_produk');
				$foto_produk = $this->upload->data();
				$datafoto_produk = $foto_produk['file_name']; 
			}; 
			
			$data = array(
				'kd_produk' => $this->input->post('kd_produk',TRUE),
				'nama_produk' => $this->input->post('nama_produk',TRUE), 
				'kategori_produk' => $this->input->post('kategori_produk',TRUE),
				'jml_produk' => $this->input->post('jml_produk',TRUE),
				'harga_produk' => $this->input->post('harga_produk',TRUE),
				'tgl_produk_masuk' => date('d-m-Y'),
				'gaji' => $this->input->post('gaji', TRUE),
				'tgl_produk_ditambahkan' => date('Y-m-d H:i:s', now()),
				'foto_produk' => $datafoto_produk,
				'slug' => $slug,
			);
			$this->produk_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('produk'));
		}
	}
			
    
	// Fungsi menampilkan form Update produk
    public function update($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}	
		
		// Menampilkan data berdasarkan id-nya yaitu kode_produk
        $row = $this->produk_model->get_by_id($id);
		
		// Jika id-nya dipilih maka data produk ditampilkan ke form edit produk
        if ($row) {
            $data = array(
            'button' => 'Update',
			'back'   => site_url('produk'),
            'action' => site_url('produk/update_action'),
			'kd_produk' => $row->kd_produk,
			'nama_produk' =>  $row->nama_produk,
            'kategori_produk' =>  $row->kategori_produk,
			'jml_produk' =>  $row->jml_produk,
           	'harga_produk' =>  $row->harga_produk,
           	'tgl_produk_masuk' =>  $row->tgl_produk_masuk,
           	'foto_produk' =>  $row->foto_produk,
			// 'gaji' => $row->gaji,
		);
		$this->load->view('templates/header');
        $this->load->view('templates/side_bar');
        $this->load->view('pages/produk/produk_form', $data);
		$this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	} 
	// Jika id-nya yang dipilih tidak ada maka akan menampilkan pesan 'Record Not Found'
	else {
		$this->session->set_flashdata('message', 'Record Not Found');
		redirect(site_url('produk'));
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
			$this->update($this->input->post('kd_produk', TRUE));
		} 
		// Jika form produk telah diisi dengan benar 
		// maka sistem akan melakukan update data produk kedalam database
		else {
			$nama = $this->input->post('nama_produk');
			$string=preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $nama); //filter karakter unik dan replace dengan kosong ('')
			$trim=trim($string); // hilangkan spasi berlebihan dengan fungsi trim
			$pre_slug=strtolower(str_replace(" ", "-", $trim)); // hilangkan spasi, kemudian ganti spasi dengan tanda strip (-)
			$slug=$pre_slug.'.html';

			$config['upload_path']   = 'images/fotoproduk/';    //path folder image
			$config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diupload jpg|png|jpeg			
			$config['file_name']     = url_title($this->input->post('nama_produk')); //nama file gambar dirubah menjadi nama berdasarkan judul_gallery	
			$this->upload->initialize($config);
			$datafoto_produk_upd = $this->input->post('foto_produk');;

			if (!empty($_FILES['foto_produk']['name'])) {
				$this->upload->do_upload('foto_produk');
				$foto_produk_upd = $this->upload->data();
				$datafoto_produk_upd = $foto_produk_upd['file_name']; 
			}; 
			
			$this->load->library('upload', $config);
			

			$data = array(
				'kd_produk' => $this->input->post('kd_produk',TRUE),
				'nama_produk' => $this->input->post('nama_produk',TRUE), 
				'kategori_produk' => $this->input->post('kategori_produk',TRUE),
				'jml_produk' => $this->input->post('jml_produk',TRUE),
				'harga_produk' => $this->input->post('harga_produk',TRUE),
				'tgl_produk_masuk' => date('d-m-Y'),
				// 'gaji' => $this->input->post('gaji', TRUE),
				'tgl_produk_ditambahkan' => date('Y-m-d H:i:s', now()),
				'foto_produk' => $datafoto_produk_upd,
				'slug' => $slug,
			);
			
			$this->produk_model->update($this->input->post('kd_produk', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('produk'));
		}
	}
			
	        
        
    
	// Fungsi untuk melakukan aksi delete data berdasarkan id yang dipilih
    public function delete($id){
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}
	
        $row = $this->produk_model->get_by_id($id);
		
		//jika id produk yang dipilih tersedia maka akan dihapus
        if ($row) {
            $this->produk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('produk'));
        } 
		//jika id produk yang dipilih tidak tersedia maka akan muncul pesan 'Record Not Found'
		else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

	public function pdf_view() {

		$data['produk'] = $this->produk_model->get_produk();
			$html = $this->load->view('pdfView', $data,TRUE);
			generatePdf($html, 'Daftar Produk', 'A4', 'landscape');
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
