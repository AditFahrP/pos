<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Deklarasi pembuatan class produk_model
class Hutang_model extends CI_Model {
    // Property yang bersifat public   
    public $table = 'hutang_top';
    public $id = 'kd_top';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama produk dan prodi 
    function json() {       
		$this->datatables->select('kd_top, nama, alamat, tgl_hutang, total_hutang, ket, bayar, via, saldo_akhir');
        $this->datatables->from('hutang_top');        
        
        $this->datatables->add_column('action', anchor(site_url('hutang/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('hutang/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('hutang/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_top');
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
        $this->db->like('kd_top', $q);
		$this->db->or_like('kd_top', $q);
		$this->db->or_like('nama', $q);
		$this->db->or_like('alamat', $q);
		$this->db->or_like('tgl_kasbon', $q);
		$this->db->or_like('total_hutang', $q);
		$this->db->or_like('ket', $q);
		$this->db->or_like('bayar', $q);
		$this->db->or_like('via', $q);
		$this->db->or_like('saldo_akhir', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_top', $q);
		$this->db->or_like('kd_top', $q);
		$this->db->or_like('nama', $q);
		$this->db->or_like('alamat', $q);
		$this->db->or_like('tgl_kasbon', $q);
		$this->db->or_like('total_utang', $q);
		$this->db->or_like('ket', $q);
		$this->db->or_like('bayar', $q);
		$this->db->or_like('via', $q);
		$this->db->or_like('saldo_akhir', $q);
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

    public function simpan_detail_pesanan($data) {
        // Simpan data detail pesanan ke dalam tabel detail_pesanan
        $this->db->insert('hutang_top', $data);
    }

    public function get_saldo_sebelumnya($kd_top) {
        $this->db->select('saldo_akhir');
        $this->db->where('kd_top', $kd_top);
        $query = $this->db->get('hutang_top'); // Ganti 'nama_tabel_kasbon' dengan nama tabel yang sesuai
        $row = $query->row();
        if ($row) {
            return $row->saldo_akhir;
        } else {
            // Jika tidak ada data ditemukan, kembalikan 0 atau nilai default
            return 0;
        }
    }

    public function get_saldo_akhir_terakhir() {
        $this->db->select('saldo_akhir');
        $this->db->order_by('kd_top', 'DESC'); // Mengurutkan berdasarkan ID secara menurun untuk mendapatkan saldo_akhir terakhir
        $this->db->limit(1); // Hanya ambil satu baris data
        $query = $this->db->get('hutang_top'); // Ganti 'nama_tabel_kasbon' dengan nama tabel yang sesuai
        $row = $query->row();
        if ($row) {
            return $row->saldo_akhir;
        } else {
            // Jika tidak ada data ditemukan, kembalikan 0 atau nilai default
            return 0;
        }
    }
}