<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Deklarasi pembuatan class produk_model
class Pembelian_model extends CI_Model {
    // Property yang bersifat public   
    public $table = 'pembelian';
    public $id = 'kd_beli';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama_produk produk dan prodi 
    function json() {       
		$this->datatables->select('kd_beli, nama_produk, kategori_produk, jml_produk, harga_produk, total_harga, tgl_produk_masuk');
        $this->datatables->from('pembelian');        
        
        $this->datatables->add_column('action', anchor(site_url('pembelian/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('pembelian/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('pembelian/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_beli');
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
        $this->db->like('kd_beli', $q);
		$this->db->or_like('kd_beli', $q);
		$this->db->or_like('nama_produk', $q);
		$this->db->or_like('kategori_produk', $q);
		$this->db->or_like('jml_produk', $q);
		$this->db->or_like('harga_produk', $q);
		$this->db->or_like('total_harga', $q);
		$this->db->or_like('tgl_produk_masuk', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_beli', $q);
		$this->db->or_like('kd_beli', $q);
		$this->db->or_like('nama_produk', $q);
		$this->db->or_like('kategori_produk', $q);
		$this->db->or_like('jml_produk', $q);
		$this->db->or_like('harga_produk', $q);
		$this->db->or_like('total_harga', $q);
		$this->db->or_like('tgl_produk_masuk', $q);
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

    public function get_produk() {
        $query = $this->db->get('pembelian');
        return $query->result();
    }

    public function get_count_all() {
        return $this->db->count_all('pembelian');
    }

    public function get_total_harga() {
        $this->db->select_sum('total_harga'); // Mengambil jumlah total qty
        $query = $this->db->get('pembelian');
        $row = $query->row();
        return $row->total_harga; // Mengembalikan jumlah total qty
    }

    public function get_total_keluar_tgl($tanggal){
        $this->db->select_sum('total_harga');
        $this->db->where('tgl_produk_masuk', $tanggal);
        $query = $this->db->get('pembelian');
        return $query->row()->total_harga;
    }
    

}