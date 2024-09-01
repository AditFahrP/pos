<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Deklarasi pembuatan class produk_model
class Produk_model extends CI_Model {
    // Property yang bersifat public   
    public $table = 'produk';
    public $id = 'kd_produk';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama_produk produk dan prodi 
    function json() {       
		$this->datatables->select('slug, kd_produk, nama_produk, kategori_produk, jml_produk, harga_produk, tgl_produk_masuk, tgl_produk_ditambahkan, foto_produk');
        $this->datatables->from('produk');        
        
        $this->datatables->add_column('action', anchor(site_url('produk/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('produk/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('produk/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_produk');
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
        $this->db->like('kd_produk', $q);
		$this->db->or_like('kd_produk', $q);
		$this->db->or_like('nama_produk', $q);
		$this->db->or_like('slug', $q);
		$this->db->or_like('kategori_produk', $q);
		$this->db->or_like('gaji', $q);
		$this->db->or_like('jml_produk', $q);
		$this->db->or_like('harga_produk', $q);
		$this->db->or_like('tgl_produk_masuk', $q);
		$this->db->or_like('foto_produk', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_produk', $q);
		$this->db->or_like('kd_produk', $q);
		$this->db->or_like('nama_produk', $q);
		$this->db->or_like('slug', $q);
		$this->db->or_like('gaji', $q);
		$this->db->or_like('kategori_produk', $q);
		$this->db->or_like('jml_produk', $q);
		$this->db->or_like('harga_produk', $q);
		$this->db->or_like('tgl_produk_masuk', $q);
		$this->db->or_like('foto_produk', $q);
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
        $query = $this->db->get('produk');
        return $query->result();
    }

    public function get_count_all() {
        return $this->db->count_all('produk');
    }

    public function cariBarang($searchText){
        $this->db->like('nama_produk', $searchText);
        $query = $this->db->get('produk');
        return $query->result_array();
    }

    public function updateJumlahProduk($nama_produk, $jml_produk) {
        $data = array('jml_produk' => $jml_produk);
        $this->db->where('nama_produk', $nama_produk);
        $this->db->update($this->table, $data);
    }

    public function get_by_nama_produk($nama_produk) {
        $this->db->where('nama_produk', $nama_produk);
        return $this->db->get('produk')->row();
    }
    
    public function update_jumlah_produk($id_produk, $jumlah_baru) {
        $this->db->where('kd_produk', $id_produk);
        $this->db->update('produk', array('jml_produk' => $jumlah_baru));
    }

    public function getGajiByNamaProduk($nama_produk) {
        // Lakukan query untuk mendapatkan gaji berdasarkan nama_produk dari database
        $this->db->select('gaji');
        $this->db->where('nama_produk', $nama_produk);
        $query = $this->db->get('produk'); // Ganti 'nama_tabel_produk' dengan nama tabel produk yang Anda gunakan

        // Periksa apakah query berhasil dan hasilnya ada
        if ($query->num_rows() > 0) {
            // Ambil nilai gaji dari hasil query
            $row = $query->row();
            $gaji = $row->gaji;
            return $gaji;
        } else {
            // Jika tidak ada hasil, kembalikan nilai null atau sesuai kebutuhan
            return null;
        }
    }

    public function hapus_produk($id_produk) {
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('produk');
    }
    

}