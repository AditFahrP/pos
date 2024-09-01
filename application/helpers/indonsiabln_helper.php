<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('konversiNamaBulan')) {
	
	function konversiNamaBulan($bulanInggris) {
		$bulanIndonesia = array(
			'January' => 'Januari',
			'February' => 'Februari',
			'March' => 'Maret',
			'April' => 'April',
			'May' => 'Mei',
			'June' => 'Juni',
			'July' => 'Juli',
			'August' => 'Agustus',
			'September' => 'September',
			'October' => 'Oktober',
			'November' => 'November',
			'December' => 'Desember'
		);
	
		return $bulanIndonesia[$bulanInggris];
	}
	
	$tanggal_pesan = '2024-03-25';
	$bulan = date('F', strtotime($tanggal_pesan));
	$nama_bulan = konversiNamaBulan($bulan);
}
	
	