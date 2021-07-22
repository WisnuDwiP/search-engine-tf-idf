<?php
include 'koneksi.php';

$data_korpus = $konek->query("SELECT * FROM tbjurnal");
$konek->query("TRUNCATE TABLE tbtokenisasi");

    foreach($data_korpus as $row)
    {

        $word_chill = strtolower($row['judul']);
        
        $hilangkan = preg_replace("/[^a-zA-Z]/", ' ', $word_chill);
        $hilangkan2 = preg_replace ("/ +/", " ", $hilangkan); # convert all multispaces to space        
        $hilangkan3 = preg_replace ("/^ /", "", $hilangkan2);  # remove space from start
        $hilangkan4 = preg_replace ("/ $/", "", $hilangkan3);  # and end

        $kata = explode(" ",$hilangkan4);

        $dokumen = $row['nm_dk'];
        foreach($kata as $isi)
        {
            $sql = "INSERT INTO `tbtokenisasi`(`nm_dk`,`term`) VALUES ('$dokumen','$isi')";
            $cek = $konek->query($sql);
            if(!$cek)
            {
                echo mysqli_error($konek);
            }

        }
    }

    $limit = 5;
	$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
	$halaman_awal = ($halaman>1) ? ($halaman * $limit) - $limit : 0;

	$previous = $halaman -1;
	$next = $halaman +1;

	$query = mysqli_query($konek,"SELECT * FROM tbtokenisasi");
	$total_hasil_result = mysqli_num_rows($query);
	$total_halaman = ceil($total_hasil_result / $limit);

	$data_query = mysqli_query($konek,"SELECT * FROM tbtokenisasi limit $halaman_awal, $limit");

    // $token = $konek->query("SELECT * FROM tbtokenisasi");
    // $total = mysqli_num_rows($token);
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="referrer" content="strict-origin" />
    <title>Sistem Informasi Rumput Laut</title>
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
        <div class="alert alert-primary" role="alert">
            Menampilkan <?= $total_hasil_result; ?> term
        </div>
        <div class="buton">
            <a class="btn btn-primary btn-sm" href="_filtering.php">Filtering</a>
        </div>
        <table class="table table-sm table-bordered">
            <tr class="bg-primary">
                <td scope="col">Kode Dokumen</td>
                <td scope="col">Term</td>
            </tr>
            <?php foreach($data_query as $row) : ?>

            <tr>
                <td><?= $row['nm_dk']; ?></td>
                <td><?= $row['term']; ?></td>
            </tr>

            <?php endforeach; ?>
        </table>
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
    <script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>

</html>