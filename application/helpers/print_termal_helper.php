<?php
require_once(APPPATH . 'libraries/Mike42/Escpos/PrintConnectors/WindowsPrintConnector.php');
require_once(APPPATH . 'libraries/Mike42/Escpos/CapabilityProfile.php');
require_once(APPPATH . 'libraries/Mike42/Escpos/Printer.php');
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;

function printTermal() {
    // Instantiate and use the dompdf class
    $profile = CapabilityProfile::load("simple");
    $connector = new WindowsPrintConnector("testprint");
    $printer = new Printer($connector, $profile);
    
    $printer -> text("Hello World!\n");
    $printer -> cut();
    $printer -> close();
}