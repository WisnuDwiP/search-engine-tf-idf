<?php
	$get_stopword = file_get_contents("stopword.json");
	$stopword = json_decode($get_stopword,true);
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="referrer" content="strict-origin" />
	<title>Dokumen Jurnal</title>
	<link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Tambah Jurnal</li>
			</ol>
		</nav>

		<h2 class="text-center">Daftar Jurnal</h2>
		<div class="add float-right">
			<div>
				<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal"><i
						class="fa fa-plus"></i>Tambah Artikel</button>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#stopword">
					Stopword
				</button>
				<a class="btn btn-info btn-sm" href="_tokenisasi.php">Text Processing</a>
			</div>
		</div>
		<table class="table table-striped">
			<thead class="bg-primary text-white">
				<tr>
					<th scope="col">No</th>
					<th scope="col">Sumber</th>
					<th scope="col">Volume</th>
					<th scope="col">Nomor</th>
					<th scope="col">Bulan</th>
					<th scope="col">Tahun</th>
					<th scope="col">Judul</th>
					<th scope="col">Abstrak</th>
					<th scope="col">Kata Kunci</th>
					<th scope="col">Kode</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				    	include 'koneksi.php';
						$result = mysqli_query($konek,"SELECT * FROM tbjurnal ORDER BY Id");
						$no = 1;
							while($row = mysqli_fetch_array($result)) {
								echo '<tr>';
						    	echo '<td>'.$no.'</td>';
							    echo '<td>'.$row['sumber'].'</td>';
								echo '<td>'.$row['volume'].'</td>';
								echo '<td>'.$row['nomor'].'</td>';
								echo '<td>'.$row['bulan'].'</td>';
								echo '<td>'.$row['tahun'].'</td>';
								echo '<td>'.$row['judul'].'</td>';
							    echo '<td>'.substr_replace($row['abstrak'],"...",100).'</td>';
								echo '<td>'.$row['katakunci'].'</td>';
							    echo '<td>'.$row['nm_dk'].'</td>';
							    ?>
				<td><a class="btn btn-danger btn-sm" onclick="return confirm('Yakin Ingin Hapus?')"
						href="hapus.php?idDock=<?= $row['Id'] ?>"><i class="fa fa-trash"></i></a>
					<?php
								echo '</tr>';
								$no++;
							}
							
						?>
			</tbody>
		</table>

		<!-- Modal Add Artikel-->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="_addDok.php" method="POST">
							<div class="form-group">
								<label for="sumber">Sumber</label>
								<input type="text" class="form-control" name="sumber" id="sumber"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="volume">Volume</label>
								<input type="text" class="form-control" name="volume" id="volume"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="nomor">Nomor</label>
								<input type="text" class="form-control" name="nomor" id="nomor"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="bulan">Bulan</label>
								<input type="text" class="form-control" name="bulan" id="bulan"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="tahun">Tahun</label>
								<input type="text" class="form-control" name="tahun" id="tahun"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="judul">Judul</label>
								<input type="text" class="form-control" name="judul" id="judul"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="isi">Isi Abstrak</label>
								<textarea class="form-control" id="isi" name="isi" rows="3"></textarea>
							</div>
							<div class="form-group">
								<label for="katakunci">Kata Kunci</label>
								<input type="text" class="form-control" name="katakunci" id="katakunci"
									aria-describedby="emailHelp">
							</div>
							<div class="form-group">
								<label for="kode">Kode Dokumen</label>
								<input type="text" class="form-control" id="kode" name="kode"
									aria-describedby="emailHelp">
							</div>
							<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
						</form>
					</div>

				</div>
			</div>
		</div>

		<!-- Modal -->

		<div class="modal fade" id="stopword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Stopword Sastrawi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-sm">
							<thead>
								<tr>
									<th class="text-center bg-primary text-white" scope="col">Daftar Kata</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($stopword as $list) : ?>
								<tr>
									<td class="text-center"><?= $list; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script>
	<!-- <script type="text/javascript" src="assets/bootstrap/dist/js/bootstrap.min.js"></script> -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- <script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>	 -->
</body>

</html>