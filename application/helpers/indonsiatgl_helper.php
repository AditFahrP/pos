<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('indonseiatgl')) {
 function indonsiatgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal="$tgl-$bln-$thn";
	return $tanggal;
}
}
 ?>