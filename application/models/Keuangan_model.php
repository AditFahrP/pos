<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Deklarasi pembuatan class produk_model
class Keuangan_model extends CI_Model 
{
    // Property yang bersifat public   
    public $table = 'keuangan';
    public $id = 'kd_uang';
    public $order = 'DESC';
	public $hasil='';
    
   // Konstrutor    
   function __construct()
    {
        parent::__construct();
    }

    // Tabel data dengan nama_obat produk dan prodi 
    function json() {       
		$this->datatables->select('kd_uang, tgl, pengeluaran, pendapatan, saldo_akhir, saldo_awal');
        $this->datatables->from('keuangan');        
        
        $this->datatables->add_column('action', anchor(site_url('keuangan/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('keuangan/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('keuangan/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_uang');
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
        $this->db->like('kd_uang', $q);
		$this->db->or_like('kd_uang', $q);
		$this->db->or_like('tgl', $q);
		$this->db->or_like('pengeluaran', $q);
		$this->db->or_like('saldo_akhir', $q);
		$this->db->or_like('pendapatan', $q);
		$this->db->or_like('saldo_awal', $q);
		$this->db->or_like('saldo_akhir', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // Menampilkan data dengan jumlah limit
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_uang', $q);
		$this->db->or_like('kd_uang', $q);
        $this->db->or_like('tgl', $q);
		$this->db->or_like('pengeluaran', $q);
		$this->db->or_like('saldo_akhir', $q);
		$this->db->or_like('pendapatan', $q);
		$this->db->or_like('saldo_awal', $q);
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

    function get_total_pengeluaran($tanggal)
    {
        $this->db->select_sum('biaya');
        $this->db->where('tgl', $tanggal);
        $query = $this->db->get('pengeluaran');
        return $query->row()->biaya;
    }

    // Mendapatkan total pendapatan berdasarkan tanggal
    function get_total_pendapatan($tanggal)
    {
        $this->db->select_sum('total_harga');
        $this->db->where('tgl', $tanggal);
        $query = $this->db->get('detail_pesanan');
        return $query->row()->total_harga;
    }

    function get_saldo_awal($tanggal)
    {
        $this->db->select('saldo_awal');
        $this->db->where('tgl', $tanggal);
        $query = $this->db->get('keuangan');
        return $query->row()->saldo_awal;
    }

    public function salin_data_pengeluaran() {
        // Ambil tanggal keuangan saat ini
        $tanggal_keuangan = date('d-m-Y');
        // Ambil total harga dari tabel detail pesanan berdasarkan tanggal keuangan
        $this->db->select_sum('total_harga');
        $this->db->where('tgl_produk_masuk', $tanggal_keuangan);
        $query_detail_pesanan = $this->db->get('pembelian');
        $total_harga_pembelian = $query_detail_pesanan->row()->total_harga;
    
        // Ambil total biaya dari tabel pengeluaran berdasarkan tanggal keuangan
        $this->db->select_sum('biaya');
        $this->db->where('tgl', $tanggal_keuangan);
        $query_pengeluaran = $this->db->get('pengeluaran');
        $total_biaya_pengeluaran = $query_pengeluaran->row()->biaya;
        
        $this->db->select_sum('total_harga');
        $this->db->where('tgl', $tanggal_keuangan);
        $query_detail_pesanan = $this->db->get('detail_pesanan');
        $total_harga_detail_pesanan = $query_detail_pesanan->row()->total_harga;
    
        // Hitung total pengeluaran (jumlah total harga detail pesanan dan total biaya pengeluaran)
        $total_pendapatan = $total_harga_detail_pesanan;

        $total_pengeluaran = $total_harga_pembelian + $total_biaya_pengeluaran;

        $total_saldo_akhir = $total_pendapatan - $total_pengeluaran;
    
        // Masukkan atau perbarui data ke dalam tabel keuangan
        $data = array(
            'tgl' => $tanggal_keuangan,
            'pendapatan' => $total_pendapatan,
            'pengeluaran' => $total_pengeluaran,
            'saldo_akhir' => $total_saldo_akhir
        );
    
        // Periksa apakah data sudah ada untuk tanggal tersebut di tabel keuangan
        $existing_data = $this->db->get_where('keuangan', array('tgl' => $tanggal_keuangan))->row();
        if ($existing_data) {
            // Jika data sudah ada, update data yang sudah ada
            $this->db->where('tgl', $tanggal_keuangan);
            $this->db->update('keuangan', $data);
        } else {
            // Jika data belum ada, masukkan data baru
            $this->db->insert('keuangan', $data);
        }
    }
}