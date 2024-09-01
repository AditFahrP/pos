<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gaji_model extends CI_Model 
{
    public $table = 'gaji_karyawan'; // Menggunakan tabel 'gaji_karyawan'
    public $id = 'kd_gaji'; // Menggunakan kolom 'kd_gaji' sebagai primary key
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function json() {       
        $this->datatables->select('kd_gaji, nama_karyawan, gaji, bulan, tgl');
        $this->datatables->from('gaji_karyawan');
        $this->datatables->add_column('action', anchor(site_url('gaji/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('gaji/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('gaji/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_gaji');
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
        $this->db->like('kd_gaji', $q);
        $this->db->or_like('nama_karyawan', $q);
        $this->db->or_like('gaji', $q);
        $this->db->or_like('bulan', $q);
        $this->db->or_like('tgl', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL) {
        // Mengambil data dengan batas dan kriteria pencarian
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_gaji', $q);
        $this->db->or_like('nama_karyawan', $q);
        $this->db->or_like('gaji', $q);
        $this->db->or_like('bulan', $q);
        $this->db->or_like('tgl', $q);
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
    public function simpan_gaji($data) {
        $this->db->insert('gaji_karyawan', $data);
        return $this->db->insert_id(); // Kembalikan ID pesanan baru
    }

    public function simpan_detail_gaji($data) {
        // Simpan data detail pesanan ke dalam tabel detail_pesanan
        $this->db->insert('gaji_karyawan', $data);
    }

    public function get_total_qty() {
        $this->db->select_sum('gaji'); // Mengambil jumlah total qty
        $query = $this->db->get('gaji_karyawan');
        $row = $query->row();
        return $row->qty; // Mengembalikan jumlah total qty
    }
}
