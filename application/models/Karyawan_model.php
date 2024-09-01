<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Deklarasi pembuatan class produk_model
class Karyawan_model extends CI_Model {
    // Property yang bersifat public   
    public $table = 'karyawan';
    public $id = 'kd_karyawan';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   public function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama_karyawan produk dan prodi 
    public function json() {       
		$this->datatables->select('kd_karyawan, nama_karyawan, level, alamat, no_tlp, tgl_karyawan_masuk');
        $this->datatables->from('karyawan');        
        
        $this->datatables->add_column('action', anchor(site_url('karyawan/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('karyawan/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('karyawan/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_karyawan');
        return $this->datatables->generate();
    }
   
   
   // Menampilkan semua data 
   public function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // Menampilkan semua data berdasarkan id-nya
    public function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
	// menampilkan jumlah data	
    public function total_rows($q = NULL) {
        $this->db->like('kd_karyawan', $q);
		$this->db->or_like('kd_karyawan', $q);
		$this->db->or_like('nama_karyawan', $q);
		$this->db->or_like('alamat', $q);
		$this->db->or_like('no_tlp', $q);
		$this->db->or_like('level', $q);
		$this->db->or_like('tgl_karyawan_masuk', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    public function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_karyawan', $q);
		$this->db->or_like('kd_karyawan', $q);
		$this->db->or_like('nama_karyawan', $q);
        $this->db->or_like('alamat', $q);
		$this->db->or_like('no_tlp', $q);
		$this->db->or_like('level', $q);
		$this->db->or_like('tgl_karyawan_masuk', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // Menambahkan data kedalam database
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // Merubah data kedalam database
    public function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // Menghapus data kedalam database
    public function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    public function get_count_all() {
        return $this->db->count_all('karyawan');
    }

    public function get_karyawan() {
        $query = $this->db->get('karyawan');
        return $query->result();
    }   
}