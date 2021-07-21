<!DOCTYPE html>
<html>

<head>
	<meta name="referrer" content="strict-origin" />
	<title>SIRULA</title>
	<link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<script type="text/javascript" src="external-libraries/confusion-matrix-stats.js"></script>
</head>
<!-- <style type="text/css">
	* {
		font-family: awesome;
	}

	.col-example {
		padding: 1rem;
		background-color: #33b5e5;
		border: 2px solid #fff;
		color: #fff;
		text-align: center;
	}

	.search_form input {
		padding: 20px;
		border-top-left-radius: 2em;
		border-bottom-left-radius: 2em;
		border: 1px solid #eaeaea !important;
	}

	.search_form input:focus {
		border: 0px !important;
		outline: none !important;
		box-shadow: none !important;
		border: 1px solid #eaeaea !important;
	}

	.search_form button {
		padding: 0 20px !important;
		border-bottom-right-radius: 2em;
		border-top-right-radius: 2em;
		border: 1px solid #eaeaea !important;
	}

	.action {
		font-size: 11px;
		margin-left: 25px;
		color: #b7b7b7;
	}

	.result-list .list-group-item {
		border: 0px !important;
		margin-bottom: 20px;
	}
</style> -->

<body>
	<?php 
	$get_keyword_user = $_GET['search'];

	include 'fungsi.php';
	buatindex();
	hitungbobot(); 
	panjangvektor(); 
	hitungBobotKeyword();
	WdWdi();
	perangkinganDokumen();
	 ?>
	<div class="row">
		<div class="col-10" style="border-bottom: 1px solid #f7f7f7;">
			<div class="row">
				<div class="col-2 d-flex align-items-center justify-content-center">
					<a href="index.php">
						<h3>SIRULA</h3>
					</a>
				</div>
				<div class="col-5 ">
					<form method="GET" action="proses_cari.php" class="" style="padding: 20px 0 0 0;">
						<div class="input-group mb-3 search_form">
							<input type="text" class="form-control" placeholder="Mau nyari apa?" name="search"
								value="<?= $get_keyword_user;  ?>">
							<div class="input-group-append">
								<button class="btn btn-outline-secondary" type="submit"><i
										class="fas fa-search"></i></button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-5 ">
					<div style="padding: 20px 0 0 0;">
						<button class="btn btn-primary btn-sm btn-outline" data-toggle="modal"
							data-target=".bd-vector">Panjang Vector</button>
						<button class="btn btn-warning btn-sm btn-outline" data-toggle="modal"
							data-target=".bd-bobot">Bobot Keyword</button>
						<a class="btn btn-danger btn-sm btn-outline" href="bobotDokumen.php">Indexing</a>
						<a class="btn btn-danger btn-sm btn-outline" href="bobotDokumen.php">Precision</a>
						<a class="btn btn-danger btn-sm btn-outline" href="bobotDokumen.php">Recall</a>
					</div>
				</div>
			</div>
		</div>

		<?php 
			include "koneksi.php";
			$limit = 2;
			$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
			$halaman_awal = ($halaman>1) ? ($halaman * $limit) - $limit : 0;

			$previous = $halaman - 1;
			$next = $halaman +1;
			$query = mysqli_query($konek,"SELECT simpan_hasil.DocId,simpan_hasil.Hasil_Bobot_Akhir,tbjurnal.Id,tbjurnal.Judul,tbjurnal.abstrak,tbjurnal.nm_dk FROM simpan_hasil INNER JOIN tbjurnal ON simpan_hasil.DocId = tbjurnal.Id ORDER BY Hasil_Bobot_Akhir DESC");
			$total_hasil_result = mysqli_num_rows($query);
			$total_halaman = ceil($total_hasil_result / $limit);

			$data_query = mysqli_query($konek,"SELECT simpan_hasil.DocId,simpan_hasil.Hasil_Bobot_Akhir,tbjurnal.Id,tbjurnal.Judul,tbjurnal.abstrak,tbjurnal.nm_dk FROM simpan_hasil INNER JOIN tbjurnal ON simpan_hasil.DocId = tbjurnal.Id ORDER BY Hasil_Bobot_Akhir DESC limit $halaman_awal, $limit");
			// $nomor = $halaman_awal + 1;
			// while($d = mysqli_fetch_array($data_query))
			 ?>
		<div class="container">
			<div class="col-12" style="margin-top: 25px;">
				<div class="col-12">
					<div style="font-size: 13px;color: grey;margin-left: 19px;">
						<i>Menampilkan <b><?= $total_hasil_result ?></b> Hasil</i>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="list-group">

								<?php 
								foreach($data_query as $res) : 
								?>
								<?php 
									if($res['Hasil_Bobot_Akhir'] == 0){
									continue;
									}
								?>
								<a href="detailDokumen.php?id=<?= $res['Id']; ?>"
									class="list-group-item list-group-item-action ">
									<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1 font-weight-bold"><?= $res['Judul']; ?></h5>
										<small class="badge badge-info"><?= $res['nm_dk']; ?></small>
									</div>
									<p class="mb-1"><?= substr_replace($res['abstrak'],"...",170) ?></p>
									<small class="badge badge-primary">Bobot <?= $res['Hasil_Bobot_Akhir']; ?></small>
								</a>
								<?php endforeach; ?>
							</div>

						</div>
						<div class="col-4"></div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<ul class="pagination">
				<?php 
					if($halaman > 1) {
						echo "<li class='page-item'><a class='page-link' href='?halaman=$previous'>&laquo;</a></li>";
					} else {
						echo "<li class='page-item disabled'><a class='page-link' href='?halaman=$previous'>&laquo;</a></li>";
					}
				?>
				
				<?php 
					for($x=1;$x<=$total_halaman;$x++){
						if($x != $halaman) {
							echo "<li class='page-item'><a class='page-link' href='?halaman=$x'>$x</a></li>";
						} else {
							echo "<li class='page-item active'><a class='page-link' href='?halaman=$x'>$x</a></li>";
						}
					}
				?>
				<li class="page-item">
					<a class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>
						&raquo;
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="modal fade bd-vector" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
		aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Bobot Dokumen</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table table-sm">
						<thead class="bg-primary">
							<tr>
								<th class="text-white" scope="col">Dokumen Id</th>
								<th class="text-white" scope="col">Panjang</th>
							</tr>
						</thead>
						<tbody>
							<?php 
					  		include 'koneksi.php';
							$result = mysqli_query($konek," SELECT * FROM `tbvektor` ");
							while($row = mysqli_fetch_array($result)) {
								echo '<tr>';
							    echo '<td>'.$row['DocId'].'</td>';
							    echo '<td>'.$row['Panjang'].'</td>';
								echo '</tr>';
							}
					  	?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade bd-bobot" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Bobot Keyword</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table table-sm">
						<thead class="bg-primary">
							<tr>
								<th class="text-white" scope="col">Term</th>
								<th class="text-white" scope="col">Jumlah</th>
								<th class="text-white" scope="col">Bobot</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							  include 'koneksi.php';
							$result = mysqli_query($konek," SELECT * FROM `tbkeyword` ");
							while($row = mysqli_fetch_array($result)) {
								echo '<tr>';
							    echo '<td>'.$row['Term'].'</td>';
							    echo '<td>'.$row['jumlah'].'</td>';
							    echo '<td>'.$row['Bobot'].'</td>';
								echo '</tr>';
							}
					  	?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	<script type="text/javascript" src="assets\script.js"></script>
	<script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>

</html>