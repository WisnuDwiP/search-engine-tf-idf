<?php

include 'koneksi.php';

    $result = mysqli_query($konek," SELECT * FROM `tbindex` JOIN `tbjurnal` on tbindex.DocId = tbjurnal.Id ");
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="referrer" content="strict-origin" />
	<title>Bobot Dokumen</title>
	<link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <table class="table table-sm table-bordered">
        <tr class="bg-primary">
            <td scope="col">Term</td>
            <td scope="col">Dokumen</td>
            <td scope="col">Jumlah</td>
            <td scope="col">Bobot</td>
        </tr>
        <?php foreach($result as $row) : ?>

            <tr>
                <td><?= $row['Term'] ?></td>
                <td><?= $row['nm_dk'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['Bobot'] ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>
</html>