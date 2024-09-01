<?php 

class Tglinggris{

  //private $tanggal;

    function rubah($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$hasil="$thn-$bln-$tgl";
	return $hasil;
}

	
}
?>