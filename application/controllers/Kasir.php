<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->database();
		$this->load->model('Users_model');
		$this->load->model('Produk_model');
		$this->load->model('Karyawan_model');
		$this->load->model('Pesanan_model');
		$this->load->model('Penjualan_model');
		$this->load->model('Hutang_model');
		$this->load->model('Gaji_model');
		$this->load->library('cart');
		$this->load->library(['datatables', 'tglinggris']);
		$this->load->helper(['rupiah_helper', 'url', 'form', 'string', 'indonsiabln_helper']);
		// $this->load->helper('print_termal_helper');

		if(!$this->session->has_userdata('total_cart_price')) {
			$this->session->set_userdata('total_cart_price', 0);
		}
	}

	public function index()
	{
		if (!isset($this->session->userdata['username'])) {
			redirect(base_url("login"));
		}

		$config["per_page"] = ""; 

		$content = $this->cart->contents();
		$data["produk"] = $this->Produk_model->get_produk();
		$data["karyawan"] = $this->Karyawan_model->get_all();
		
        $this->load->view('templates/header');
        $this->load->view('templates/side_bar');
		$this->load->view('pages/kasir/kasir.php', $data, array('content' => $content));
        $this->load->view('templates/footer');
		$this->load->view('templates/jquery');
	}

	public function check_out() {
		$content = $this->cart->contents();
		$this->load->view('', array('content' => $content));
	}

	public function tambah() {
		$gaji = $this->input->post('gaji');
		$data_produk = array(
			'id' => $this->input->post('kd_produk'),
			'nama' => $this->input->post('nama_produk'),
			'harga' => $this->input->post('harga_produk'),
			'qty' => $this->input->post('jml_produk'),
			'gambar' => $this->input->post('foto_produk'),
			'gaji' => $gaji,
		);
	
	
		// // Periksa apakah nilai gaji valid
		// if ($gaji === null || $gaji === '') {
		// 	// Jika gaji null atau kosong, dapatkan gaji dari database berdasarkan nama_produk
		// 	$nama_produk = $this->input->post('nama_produk');
		// 	// Lakukan query untuk mendapatkan gaji berdasarkan nama_produk dari database
		// 	$gaji_from_database = $this->Produk_model->getGajiByNamaProduk($nama_produk); // Ganti nama_model dengan nama model yang Anda gunakan
	
		// 	// Set nilai gaji dari hasil query database
		// 	$data_produk['gaji'] = $gaji_from_database;
		// } else {
		// 	// Jika gaji tidak null, gunakan nilai gaji dari input POST
		// 	$data_produk['gaji'] = $gaji;
		// }
	
		// Set session produk hanya jika produk dengan id yang sama belum ada di session
		$produk_array = $this->session->userdata('produk_array');
		$produk_exists = false;
		if (!empty($produk_array)) {
			foreach ($produk_array as $index => $produk) {
				if ($produk['id'] == $data_produk['id']) {
					// Update qty jika produk sudah ada di session
					$produk_array[$index]['qty'] += $data_produk['qty'];
					$produk_exists = true;
					break;
				}
			}
		}
	
		// Jika produk belum ada di session, tambahkan produk baru ke dalam session
		if (!$produk_exists) {
			$produk_array[] = $data_produk;
		}
	
		// Simpan session produk
		$this->session->set_userdata('produk_array', $produk_array);
	
		// Tambahkan produk ke dalam keranjang belanja (cart)
		$this->cart->insert($data_produk);
	
		$subtotal = $this->cart->total();
	
		$response = array(
			'status' => 'success',
			'id' => $data_produk['id'],
			'nama_produk' => $data_produk['nama'],
			'harga_produk' => $data_produk['harga'],
			'jml_produk' => $data_produk['qty'],
			'foto_produk' => $data_produk['gambar'],
			'gaji' => $gaji,
			'total_harga' => $subtotal
		);
	
		echo json_encode($response);
		$this->update_total_cart_price();
	}
	

	// function hapus($rowid) {
	// 	$data = array(
	// 		'rowid' => $rowid,
	// 		'qty' => 0,
	// 	);
	// 	$this->cart->update($data);
	// 	$this->update_total_cart_price();
	// 	redirect('kasir');
	// }

	function update_total_cart_price() {
		$total_price = 0;
		
		foreach ($this->cart->contents() as $item) {
			$total_price += $item['subtotal'];
		}
		$this->session->set_userdata('total_cart_price', $total_price);
	}

	public function cari_barang(){
		$searchText = $this->input->post('searchText');
		$data = $this->Produk_model->cariBarang($searchText); // Adjust this based on your model name and method
		echo json_encode($data);
	}
	
	public function proses_order() {
		date_default_timezone_set('Asia/Jakarta');
		// Ambil nilai-nilai dari formulir
		$delivery = $this->input->post('delivery');
		$ambil = $this->input->post('ambil');
		$transaksi = $this->input->post('transaksi');
		$pelanggan = $this->input->post('pelanggan');
		$alamat = $this->input->post('alamat');
		$nama = $this->input->post('nama');
		$ongkir = $this->input->post('ongkir');
		$gaji = $this->input->post('gaji');
		$tanggal_pesan = date('d-m-Y');
		$jam_pesan = date('H:i:s');
		// Total harga (disesuaikan dengan implementasi Anda)
		$total_harga = $this->hitungTotalHarga(); // Fungsi untuk menghitung total harga
		// Data barang (sesuaikan dengan implementasi Anda)
		$produk_array = $this->session->userdata('produk_array');
	
		// Simpan data ke database
		$data_pesanan = array(
			'tgl_pesan' => $tanggal_pesan,
			'jam' => $jam_pesan,
			'pengirim' => $delivery,
			'total_harga' => $total_harga,
			'pembayaran' => $transaksi,
			'ongkir' => $ongkir,
			'pelanggan' => $pelanggan,
			'nama' => $nama,
			'alamat' => $alamat,
			'delivery' => $ambil,
		);
	
		$id_pesanan = $this->Pesanan_model->simpan_pesanan($data_pesanan);

		$this->printTermal($data_pesanan, $produk_array);

		try {
			// Buka koneksi ke printer
			$printer = fopen("Testprint", "w"); // Ganti dengan alamat printer Anda
			
			// Cetak konten struk
			fwrite($printer, "=== Struk Pesanan ===\n");
			fwrite($printer, "Nomor Pesanan: " . $id_pesanan . "\n");
			// Tambahkan informasi lain sesuai kebutuhan Anda
			fwrite($printer, "====================\n");
			
			// Tutup koneksi printer
			fclose($printer);
		} catch (Exception $e) {
			// Tangani kesalahan jika terjadi
			echo "Kesalahan: " . $e->getMessage();
		}

		if ($transaksi == 'TOP') {
			$produk_diproses = array();
			$ket_produk = '';
		
			// Loop melalui produk_array dan simpan nama produk dan qty ke dalam array
			foreach ($produk_array as $bars) {
				// Buat data baru untuk setiap bars
				$data_produk = array(
					'nama' => $bars['nama'],
					'qty' => $bars['qty']
				);
		
				// Tambahkan data bars ke dalam array produk_diproses
				$produk_diproses[] = $data_produk;
		
				// Gabungkan nama bars dan qty menjadi satu string
				$ket_produk .= $bars['nama'] . ' (' . $bars['qty'] . '), ';
			}
		
			// Hilangkan koma terakhir dari string "ket_produk"
			$ket_produk = rtrim($ket_produk, ', ');
		
			// Simpan data produk_diproses ke dalam tabel hutang_top
			$data_hutang_top = array(
				'nama' => $nama,
				'alamat' => $alamat,
				'total_hutang' => $total_harga,
				'tgl_hutang' => $tanggal_pesan,
				'ket' => $ket_produk,
				'saldo_akhir' => $total_harga
			);
		
			// Simpan data ke tabel hutang_top
			$this->Hutang_model->simpan_detail_pesanan($data_hutang_top);
		}
		

		foreach ($produk_array as $karyawan) {
			$nama_karyawan = $delivery;
			$gaji = $this->input->post('gaji');
			$qty = $karyawan['qty'];
			$gaji_karyawan = $gaji * $qty;
		
			// Periksa apakah ada nama karyawan yang valid
			if (!empty($nama_karyawan)) {
				// Periksa apakah ada pesanan pada tanggal yang sama
				$existing_order_on_same_date = $this->db->get_where('gaji_karyawan', array('tgl' => $tanggal_pesan))->row();
		
				if ($existing_order_on_same_date) {
					// Jika ada pesanan pada tanggal yang sama, tambahkan gajinya
					$existing_detail_gaji = $this->db->get_where('gaji_karyawan', array('nama_karyawan' => $nama_karyawan, 'tgl' => $tanggal_pesan))->row();
		
					if ($existing_detail_gaji) {
						// Jika sudah ada, update gajinya
						$new_gaji = $existing_detail_gaji->gaji + $gaji_karyawan;
		
						$data_detail = array(
							'gaji' => $new_gaji,
						);
						$this->db->where('nama_karyawan', $nama_karyawan);
						$this->db->where('tgl', $tanggal_pesan);
						$this->db->update('gaji_karyawan', $data_detail);
					} else {
						// Jika belum ada, tambahkan data baru
						$data_detail = array(
							'nama_karyawan' => $delivery,
							'tgl' => $tanggal_pesan,
							'gaji' => $gaji_karyawan,
							'bulan' => konversiNamaBulan(date('F', strtotime($tanggal_pesan))) // Menyimpan nilai bulan
						);
						$this->Gaji_model->simpan_detail_gaji($data_detail);
					}
				} else {
					// Jika tidak ada pesanan pada tanggal yang sama, buat entri baru
					$data_detail = array(
						'nama_karyawan' => $delivery,
						'tgl' => $tanggal_pesan,
						'gaji' => $gaji_karyawan,
						'bulan' => konversiNamaBulan(date('F', strtotime($tanggal_pesan))) // Menyimpan nilai bulan
					);
					$this->Gaji_model->simpan_detail_gaji($data_detail);
				}
			}
		}

		// Simpan data barang ke dalam tabel detail pesanan
		foreach ($produk_array as $produk) {
			$nama_produk = $produk['nama'];
			$qty = $produk['qty'];
			$harga = $produk['harga'];

			$this->updateJumlahProduk($nama_produk, $qty);
	
			// Periksa apakah ada pesanan pada tanggal yang sama
			$existing_order_on_same_date = $this->db->get_where('detail_pesanan', array('tgl' => $tanggal_pesan))->row();
	
			if ($existing_order_on_same_date) {
				// Jika ada pesanan pada tanggal yang sama, tambahkan qty-nya
				$existing_detail_pesanan = $this->db->get_where('detail_pesanan', array('nama_produk' => $nama_produk, 'tgl' => $tanggal_pesan))->row();
	
				if ($existing_detail_pesanan) {
					// Jika sudah ada, update qty-nya dan hitung ulang total_harga
					$new_qty = $existing_detail_pesanan->qty + $qty;
					$new_total_harga = $new_qty * $harga;
	
					$data_detail = array(
						'qty' => $new_qty,
						'total_harga' => $new_total_harga
					);
					$this->db->where('nama_produk', $nama_produk);
					$this->db->where('tgl', $tanggal_pesan);
					$this->db->update('detail_pesanan', $data_detail);
				} else {
					// Jika belum ada, tambahkan data baru
					$total_harga = $qty * $harga;
	
					$data_detail = array(
						'pesanan' => $id_pesanan,
						'nama_produk' => $nama_produk,
						'qty' => $qty,
						'total_harga' => $total_harga,
						'tgl' => $tanggal_pesan,
						'bulan' => konversiNamaBulan(date('F', strtotime($tanggal_pesan))) // Menyimpan nilai bulan
					);
					$this->Pesanan_model->simpan_detail_pesanan($data_detail);
				}
			} else {
				// Jika tidak ada pesanan pada tanggal yang sama, buat entri baru
				$total_harga = $qty * $harga;
	
				$data_detail = array(
					'pesanan' => $id_pesanan,
					'nama_produk' => $nama_produk,
					'qty' => $qty,
					'total_harga' => $total_harga,
					'tgl' => $tanggal_pesan,
					'bulan' => konversiNamaBulan(date('F', strtotime($tanggal_pesan))) // Menyimpan nilai bulan
				);
				$this->Pesanan_model->simpan_detail_pesanan($data_detail);
			}
		}
		// Bersihkan session produk_array setelah pesanan disimpan
		$this->session->unset_userdata('produk_array');
	
		// Berikan response, misalnya dalam bentuk JSON
		$response = array('status' => 'success', 'message' => 'Pesanan berhasil disimpan');
		echo json_encode($response);
		// printTermal();
		redirect('pesanan');
	}

	private function updateJumlahProduk($nama_produk, $qty) {
		// Ambil jumlah produk yang tersedia saat ini
		$produk = $this->Produk_model->get_by_nama_produk($nama_produk);
	
		if ($produk) {
			// Kurangi jumlah produk yang tersedia dengan qty pesanan
			$sisa_produk = $produk->jml_produk - $qty;
	
			// Update jumlah produk yang tersedia di tabel produk
			$this->Produk_model->updateJumlahProduk($nama_produk, $sisa_produk);
		}
	}
    
    // Fungsi untuk menghitung total harga (sesuaikan dengan implementasi Anda)
    private function hitungTotalHarga() {
        // Lakukan perhitungan total harga dari data di formulir
        // Contoh:
        $total_harga = $this->input->post('total_harga');
        return $total_harga;
    }

	public function hapus() {
		$id_produk = $this->input->post('id_produk'); // Ambil ID produk dari POST data
	
		// Lakukan proses penghapusan produk dari session atau database sesuai dengan kebutuhan Anda
		// Misalnya, jika Anda menyimpan produk dalam session, Anda dapat menggunakan unset untuk menghapus produk dari session
		$produk_array = $this->session->userdata('produk_array');
		if (!empty($produk_array)) {
			foreach ($produk_array as $index => $produk) {
				if ($produk['id'] == $id_produk) {
					unset($produk_array[$index]);
					$this->session->set_userdata('produk_array', $produk_array);
					echo json_encode(array('status' => 'success'));
					return;
				}
			}
		}
	
		// Jika produk tidak ditemukan atau gagal dihapus, kembalikan respons gagal
		echo json_encode(array('status' => 'error'));
	}

	private function printTermal($data_pesanan, $produk_array) {
		// Load library ESC/POS
		require_once(APPPATH . 'libraries/Mike42/Escpos/Printer.php');
		require_once(APPPATH . 'libraries/Mike42/Escpos/CapabilityProfile.php');
		require_once(APPPATH . 'libraries/Mike42/Escpos/PrintConnectors/WindowsPrintConnector.php');
	
		try {
			// Hubungkan ke printer
			$profile = Mike42\Escpos\CapabilityProfile::load("simple");
			$connector = new Mike42\Escpos\PrintConnectors\WindowsPrintConnector("Testprint");
			$printer = new Mike42\Escpos\Printer($connector, $profile);
	
			// Cetak header struk
			$printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER);
			$printer->text("===== Struk Pembelian =====\n\n");
			$printer->text("Tanggal: " . $data_pesanan['tgl_pesan'] . "\n");
			$printer->text("Nama Pelanggan: " . $data_pesanan['pelanggan'] . "\n");
			$printer->text("Alamat: " . $data_pesanan['alamat'] . "\n\n");
	
			// Cetak detail barang
			$printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_LEFT);
			$printer->text("Barang yang dibeli:\n");
			foreach ($produk_array as $produk) {
				$printer->text($produk['nama'] . " x " . $produk['qty'] . " - Rp" . $produk['harga'] * $produk['qty'] . "\n");
			}
			$printer->text("\n");
	
			// Cetak total harga
			$printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_RIGHT);
			$printer->text("Total Harga: Rp" . $data_pesanan['total_harga'] . "\n");
	
			// Cetak footer struk
			$printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER);
			$printer->text("\nTerima kasih atas pembeliannya\n");
			$printer->text("Silakan datang kembali!\n");
	
			// Putuskan koneksi ke printer
			$printer->cut();
			$printer->close();
	
		} catch (Exception $e) {
			// Tangani kesalahan jika ada
			echo "Error: " . $e->getMessage();
		}
	}
}
		
