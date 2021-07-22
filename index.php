<!DOCTYPE html>
<html>
<head>
	<meta name="referrer" content="strict-origin" />
	<title>Sistem Informasi Rumput Laut</title>
	<link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand text-primary text-weight-bold" href="#">RULA PUSTAKA</a>
	<button class="float-left btn btn-secondary my-2 my-sm-0" onclick="window.location.href='add_dokumen.php';"> Dokumen </button>
  </div>
</nav>
	<div class="container">
		<div class="d-flex align-items-center justify-content-center" style="height: 500px">
			<div class="col-6">
				<form method="GET" action="proses_cari.php">
					<div class="text-center" style="margin-bottom: 50px">
						<h1 class="text-primary">Pencarian Dokumen</h1>
					</div>
					<div class="input-group mb-3 search_form">
					  <input type="text" class="form-control me-sm-2" placeholder="Masukkan Keyword" name="search" autocomplete="off">
					  <div class="input-group-append">
					    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
					  </div>
					</div>
				</form>
			</div>
		</div>
	</div>

<!-- <script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
<!-- <script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>