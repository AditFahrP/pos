<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Deklarasi pembuatan class produk_model
class Pesanan_model extends CI_Model 
{
    // Property yang bersifat public   
    public $table = 'pesanan';
    public $id = 'kd_pesan';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama_pesanan produk dan prodi 
    function json() {       
		$this->datatables->select('kd_pesan, nama, tgl_pesan, alamat, jam, pelanggan, total_harga, pembayaran, pengirim, ongkir, delivery');
        $this->datatables->from('pesanan');        
        
        $this->datatables->add_column('action', anchor(site_url('pesanan/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('pesanan/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('pesanan/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_pesan');
        return $this->datatables->generate();
    }
   
   
   // Menampilkan semua data 
   function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // Menampilkan semua data berdasarkan id-nya
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
	// menampilkan jumlah data	
    function total_rows($q = NULL) {
        $this->db->like('kd_pesan', $q);
		$this->db->or_like('kd_pesan', $q);
		$this->db->or_like('tgl_pesan', $q);
		$this->db->or_like('jam', $q);
		$this->db->or_like('pelanggan', $q);
		$this->db->or_like('nama', $q);
		$this->db->or_like('alamat,', $q);
		$this->db->or_like('total_harga', $q);
		$this->db->or_like('pembayaran', $q);
		$this->db->or_like('ongkir', $q);
		$this->db->or_like('pengirim', $q);
		$this->db->or_like('delivery', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_pesan', $q);
		$this->db->or_like('kd_pesan', $q);
		$this->db->or_like('tgl_pesan', $q);
		$this->db->or_like('jam', $q);
		$this->db->or_like('pelanggan', $q);
		$this->db->or_like('nama', $q);
		$this->db->or_like('alamat,', $q);
		$this->db->or_like('total_harga', $q);
		$this->db->or_like('pembayaran', $q);
		$this->db->or_like('ongkir', $q);
		$this->db->or_like('pengirim', $q);
		$this->db->or_like('delivery', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Menambahkan data kedalam database
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // Merubah data kedalam database
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Menghapus data kedalam database
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
    
    public function get_count_all() {
        return $this->db->count_all('pesanan');
    }

    public function simpan_pesanan($data) {
        // Simpan data pesanan ke dalam tabel pesanan
        $this->db->insert('pesanan', $data);
        return $this->db->insert_id();
    }
    
    public function simpan_detail_pesanan($data) {
        // Simpan data detail pesanan ke dalam tabel detail_pesanan
        $this->db->insert('detail_pesanan', $data);
    }

    public function get_total_pesanan() {
        $this->db->select_sum('total_harga'); // Mengambil jumlah total qty
        $query = $this->db->get('pesanan');
        $row = $query->row();
        return $row->total_harga; // Mengembalikan jumlah total qty
    }

    public function get_total_pesanan_tgl($tanggal){
        $this->db->select_sum('total_harga');
        $this->db->where('tgl_pesan', $tanggal);
        $query = $this->db->get('pesanan');
        return $query->row()->total_harga;
    }

}
