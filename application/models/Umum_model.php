<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Umum_model extends CI_Model 
{
    public $table = 'umum'; // Menggunakan tabel 'umum'
    public $id = 'kd_umum'; // Menggunakan kolom 'kd_umum' sebagai primary key
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function json() {       
        $this->datatables->select('kd_umum, nama, tgl_pesan, alamat, jam, pelanggan, total_harga, pembayaran, pengirim, ongkir, delivery');
        $this->datatables->from('umum');
        $this->datatables->add_column('action', anchor(site_url('umum/read/$1'),'<button type="button" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('umum/update/$1'),'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>')."  
        ".anchor(site_url('umum/delete/$1'),'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'kd_umum');
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
        $this->db->like('kd_umum', $q);
        $this->db->or_like('tgl_pesan', $q);
        $this->db->or_like('jam', $q);
        $this->db->or_like('pelanggan', $q);
        $this->db->or_like('nama', $q);
        $this->db->or_like('total_harga', $q);
        $this->db->or_like('pembayaran', $q);
        $this->db->or_like('alamat,', $q);
        $this->db->or_like('ongkir', $q);
        $this->db->or_like('pengirim', $q);
        $this->db->or_like('delivery', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_limit_data($limit, $start = 0, $q = NULL) {
        // Mengambil data dengan batas dan kriteria pencarian
        $this->db->order_by($this->id, $this->order);
        $this->db->like('kd_umum', $q);
        $this->db->or_like('tgl_pesan', $q);
        $this->db->or_like('jam', $q);
        $this->db->or_like('pelanggan', $q);
        $this->db->or_like('nama', $q);
        $this->db->or_like('total_harga', $q);
        $this->db->or_like('alamat,', $q);
        $this->db->or_like('pembayaran', $q);
        $this->db->or_like('ongkir', $q);
        $this->db->or_like('pengirim', $q);
        $this->db->or_like('delivery', $q);
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
        $this->db->insert('umum', $data);
        return $this->db->insert_id(); // Kembalikan ID pesanan baru
    }
    
    public function salin_data_pesanan_umum() {
        // Seleksi data pesanan dari tabel pesanan dengan pelanggan 'umum'
        $this->db->select('*');
        $this->db->from('pesanan');
        $this->db->where('pelanggan', 'umum');
        $data_pesanan_umum = $this->db->get()->result();
    
        // Hapus data umum yang tidak lagi terkait dengan pelanggan 'umum' di database pesanan
        $this->hapus_data_umum_tidak_terkait($data_pesanan_umum);
    
        // Masukkan atau perbarui data pesanan umum ke dalam tabel umum
        foreach ($data_pesanan_umum as $pesanan_umum) {
            // Cek apakah data tersebut sudah ada di tabel umum
            $existing_data = $this->db->get_where('umum', array(
                'kd_pesan' => $pesanan_umum->kd_pesan // Menggunakan kd_pesan sebagai kunci unik
            ))->row();
    
            // Jika data belum ada, tambahkan ke tabel umum
            if (!$existing_data) {
                $data = array(
                    'kd_pesan' => $pesanan_umum->kd_pesan, // Gunakan kd_pesan sebagai kunci unik
                    'tgl_pesan' => $pesanan_umum->tgl_pesan,
                    'jam' => $pesanan_umum->jam,
                    'pelanggan' => $pesanan_umum->pelanggan,
                    'alamat' => $pesanan_umum->alamat,
                    'nama' => $pesanan_umum->nama,
                    'total_harga' => $pesanan_umum->total_harga,
                    'pembayaran' => $pesanan_umum->pembayaran,
                    'pengirim' => $pesanan_umum->pengirim,
                    'ongkir' => $pesanan_umum->ongkir,
                    'delivery' => $pesanan_umum->delivery
                );
                $this->db->insert('umum', $data);
            } else {
                // Jika data sudah ada, perbarui data yang ada di tabel umum
                $this->db->where('kd_pesan', $pesanan_umum->kd_pesan); // Menggunakan kd_pesan sebagai kunci unik
                $this->db->update('umum', $pesanan_umum);
            }
        }
    }
    
    public function update_data_pesanan_umum($pelanggan, $data_pesanan) {
        // Perbarui data pada tabel umum sesuai dengan data pesanan yang telah diperbarui
        $this->db->where('pelanggan', $pelanggan);
        $this->db->update('umum', $data_pesanan);
    }

    private function hapus_data_umum_tidak_terkait($data_pesanan_umum) {
        // Ambil semua kd_pesan dari data_pesanan_umum
        $kd_pesanan_array = array();
        foreach ($data_pesanan_umum as $pesanan_umum) {
            $kd_pesanan_array[] = $pesanan_umum->kd_pesan;
        }
    
        // Hapus data umum yang tidak terkait dengan kd_pesan dari $kd_pesanan_array
        if (!empty($kd_pesanan_array)) {
            $this->db->where_not_in('kd_pesan', $kd_pesanan_array);
            $this->db->delete('umum');
        }
    }

    public function hapus_data_terkait($kd_pesan) {
        $this->db->where('kd_pesan', $kd_pesan);
        $this->db->delete('umum');
    }
}
