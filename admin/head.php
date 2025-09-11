<?php
include '../config.php';

// header('location: login.php');

// if(!isset($_SESSION['user'])){
//   $_SESSION['user']['username'];
//   header('location: login.php');
// }



if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login');
    
}

else{
  // echo "lusu";
}


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCL | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
 <!-- daterange picker -->
 <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
   <!-- DataTables -->
   <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- <link rel="stylesheet" href="plugins/dark-editable/dark-editable.css" />
  <script src="plugins/dark-editable/dark-editable.js"></script> -->
  
 <!-- x-editable (bootstrap version) -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
   <!-- sweetalert2 -->

  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.css">
  <script src="plugins/sweetalert2/sweetalert2.js"></script>


  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">



<style>
 .nav-item .user-image {
  float: left;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  margin-right: 10px;
  margin-top: -2px;
}
@media (max-width: 767px) {
.nav-item .user-image {
    float: none;
    margin-right: 0;
    margin-top: -8px;
    line-height: 10px;
  }
}

.nav-item > .navbar-nav  > li.user-header {
  height: 175px;
  padding: 10px;
  text-align: center;
}
.nav-item > .navbar-nav  > li.user-header > img {
  z-index: 5;
  height: 90px;
  width: 90px;
  border: 3px solid;
  border-color: transparent;
  border-color: rgba(255, 255, 255, 0.2);
}
.nav-item > .navbar-nav  > li.user-header > p {
  z-index: 5;
  color: #fff;
  color: rgba(255, 255, 255, 0.8);
  font-size: 17px;
  margin-top: 10px;
}
.nav-item > .navbar-nav > li.user-header > p > small {
  display: block;
  font-size: 12px;
}
.nav-item > .user-menu > .navbar-nav  > li.user-header {
  height: 175px;
  padding: 10px;
  text-align: center;
}


.hidden {
            display: none;
        }

    
  </style>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>



</head>

<body class="hold-transition sidebar-mini layout-fixed">
  
<div class="wrapper">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
