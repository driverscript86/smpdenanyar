<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>
    <link rel="icon" href="<?= base_url(); ?>assets/img/<?= $web['fav'] ?>">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="<?= base_url('assets/') ?>select2/dist/css/select2.min.css" rel="stylesheet" />

    <link href="<?= base_url('assets/'); ?>css/main-admin.css" rel="stylesheet">
    <!-- jQuery library -->
    <script src="<?= base_url('assets/') ?>js/jquery-1.12.1.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>

    <style type="text/css">
        img[src=""] {
            display: none;
        }

        .ck-editor__editable_inline {
            min-height: 300px !important;
        }

        .active_button{
            background-color: #1cc88a;
            color: white;
        }
        .btn-group-xs > .btn, .btn-xs {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">