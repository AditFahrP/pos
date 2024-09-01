<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
// Konstruktor	
  
  function __construct() {
	
    parent::__construct();
	// Jika session data username dan password sesuai dengan yang ada didalam database 
	// maka halaman admin akan dibuka
    //if ($this->session->userdata('username') AND $this->session->userdata('password') AND $this->session->userdata('nama')=='admin') {
    if ($this->session->userdata('username') AND $this->session->userdata('password')) {
      redirect(base_url('dashboard'));
    }
    $this->load->model(array('Login_model'));
  }
  
   function index() {
	  
    $this->load->view('form-login');
    $this->load->view('templates/jquery'); // Menampilkan halaman utama login
   }
  
  function proses() {
    $this->form_validation->set_rules('username', 'username', 'required|trim');
    $this->form_validation->set_rules('password', 'password', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('form-login');
    } else {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $username;
        $pass = md5($password);
        $cek = $this->Login_model->cek($user, $pass);

        if ($cek->num_rows() > 0) {
            foreach ($cek->result() as $qad) {
                $sess_data['username'] = $qad->username;
                $sess_data['nama'] = $qad->nama;
                $sess_data['level'] = $qad->level;
                $this->session->set_userdata($sess_data);
            }
            $this->session->set_flashdata('result_login', 'Selamat datang, ' . $this->session->userdata('username') . '!');
            redirect(base_url('dashboard'));
        } else {
            $this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
            redirect(base_url('login'));
        }
      }
    }
    public function logout() {
      // Hapus semua data session
      $this->session->sess_destroy();
      // Redirect ke halaman login atau halaman lain sesuai kebutuhan
      redirect(base_url('dashboard'));
  }
  }
    

