<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan_model extends CI_Model 
{
    public $table = 'detail_pesanan'; // Menggunakan tabel 'detail_pesanan'
    public $id = 'kd_detail_pesanan'; // Menggunakan kolom 'kd_detail_pesanan' sebagai primary key
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function json() {       
        $this->datatables->select('kd_detail_pesanan, tgl, bulan, qty, total_harga, nama_produk');
        $this->datatables->from('detail_pesanan');
        $this->datatables->add_column('action', anchor(site_url('penjualan/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('penjualan/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('penjualan/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_detail_pesanan');
        return $this->datatables->generate();
    }

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    function total_rows($q = NULL) {
        // Menghitung jumlah baris yang sesuai dengan kriteria pencarian
        $this->db->like('kd_detail_pesanan', $q);
        $this->db->or_like('jam', $q);
        $this->db->or_like('tgl', $q);
        $this->db->or_like('bulan', $q);
        $this->db->or_like('kd_detail_pesanan,', $q);
        $this->db->or_like('total_harga', $q);
        $this->db->or_like('nama_produk,', $q);
        $this->db->or_like('qty', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL) {
        // Mengambil data dengan batas dan kriteria pencarian
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_detail_pesanan', $q);
        $this->db->or_like('jam', $q);
        $this->db->or_like('bulan', $q);
        $this->db->or_like('tgl', $q);
        $this->db->or_like('kd_detail_pesanan,', $q);
        $this->db->or_like('total_harga', $q);
        $this->db->or_like('nama_produk,', $q);
        $this->db->or_like('qty', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
    
    // Fungsi untuk menyimpan pesanan baru ke dalam tabel pesanan
    public function simpan_pesanan($data) {
        $this->db->insert('detail_pesanan', $data);
        return $this->db->insert_id(); // Kembalikan ID pesanan baru
    }

    public function simpan_detail_pesanan($data) {
        // Simpan data detail pesanan ke dalam tabel detail_pesanan
        $this->db->insert('detail_pesanan', $data);
    }

    public function get_total_qty() {
        $this->db->select_sum('qty'); // Mengambil jumlah total qty
        $query = $this->db->get('detail_pesanan');
        $row = $query->row();
        return $row->qty; // Mengembalikan jumlah total qty
    }
}
