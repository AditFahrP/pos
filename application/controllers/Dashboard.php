<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Produk_model');
		$this->load->model('Penjualan_model');
		$this->load->model('Pesanan_model');
		$this->load->model('Karyawan_model');
		$this->load->model('Pengeluaran_model');
		$this->load->model('Pembelian_model');
		
	}
	public function index()
	{
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$data["total_row"] = $this->Produk_model->get_count_all();
		$data["total_rows"] = $this->Karyawan_model->get_count_all();
		$data["total_pesanan"] = $this->Pesanan_model->get_count_all();
		$data["total_jual"] = $this->Pesanan_model->get_total_pesanan();
		$data["total_qty"] = $this->Penjualan_model->get_total_qty();

		$total_beli = $this->Pembelian_model->get_total_harga();
        $total_keluar = $this->Pengeluaran_model->get_total_keluar();
        $total_semua = $total_beli + $total_keluar;
        $data['total_beli'] = $total_beli;
        $data['total_keluar'] = $total_keluar;
        $data['total_semua'] = $total_semua;
		
        $this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/dashboard', $data);
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	}
}
