<?php

include 'koneksi.php';

    $id = $_GET['id'];

    $data = $konek->query("SELECT * FROM tbjurnal WHERE Id = $id");

    $result = mysqli_fetch_array($data);

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="referrer" content="strict-origin" />
	<title><?= $result['Judul']; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.min.css">
  <style>
    *{
      font-family: awesome;
    }
  </style>
</head>
<body>
<!-- Image and text -->
<nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php">
    <!-- <img src="assets/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy"> -->
    RULA PUSTAKA
  </a>
</nav>
<br />
<div class="container">
<div class="card">
  <div class="card-header font-weight-bold text-center">
    <?= $result['judul'] ?>
  </div>
  <div class="card-body">
    <p class="card-text"><?= $result['abstrak']; ?></p>
  </div>
</div>
</div>

<script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script>
</body>
</html>