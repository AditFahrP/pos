<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Informasi</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css">
    
    <style>
        a:hover {
            color: grey;
        }
    </style>

</head>

<body>
<div class="container mt-5" style="width: 65%;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center bg-white">
                    <img src="<?php echo base_url();?>assets/dist/img/logo_pos.jpg" style="width: 40%;"class="img-circle" alt="Logo POS">
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url().'login/proses'; ?>" method="post">
                    <?php
			        // Validasi error, jika username atau password tidak cocok
			        if (validation_errors() || $this->session->flashdata('result_login')) {
		            ?>
                    <div class="alert alert-danger animated fadeInDown" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Peringatan!</strong>
					<?php 
						// Menampilkan error
						echo validation_errors(); 
						// Session data users 
					    echo $this->session->flashdata('result_login'); ?>
			        </div> 
                <?php 
                    } 
                ?>		
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input placeholder="Masukan username" type="text" class="form-control" id="username" name="username" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" placeholder="Masukkan password" name="password" required>
                                <div class="input-group-append">
                                    <a href="javascript:;" class="input-group-text bg-white" id="password-toggle">
                                        <img src="<?php echo base_url()?>images/eye-slash.svg" id="password-toggle-img">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="<?php echo base_url('dashboard')?>" class="btn btn-danger">Cancle</a>
                    </form>
                </div>
                <!-- <div class="container">
                    <div class="mb-3">
                        Belum punya akun?<a class="" href="<?php echo base_url('createakun')?>"> Create Akun</a><br>
                        Sudah punya akun Pemasok?<a class="" href="<?php echo base_url('loginsupplier')?>"> Login Disini</a><br>
                        Ingin menjadi pemasok barang?<a class="" href="<?php echo base_url('createpemasok')?>"> Create Akun</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
</body>
