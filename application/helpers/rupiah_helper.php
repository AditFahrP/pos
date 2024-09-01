<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('rupiah')) {
 function rupiah($angka){
 $uang = floatval($angka);
 $hasil_rupiah = number_format($uang,0,',','.');
 return $hasil_rupiah;
 }
}