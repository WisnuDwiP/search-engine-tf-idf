<?php
include 'koneksi.php';
function preproses($teks) {
	// include composer autoloader
	require_once __DIR__ . '/vendor/autoload.php';

	// create stemmer Sastrawi

	$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
	$stemmer  = $stemmerFactory->createStemmer();

	$get_stopword = file_get_contents("stopword.json");
	$stopword = json_decode($get_stopword,true);
	
	$data = explode(" ", $stemmer->stem($teks));
	$result = array_diff($data,$stopword);
	$hasil = implode(" ",$result);

	//Proses Stemming
	$teks = $hasil;
	return $teks;
}

$data = $konek->query("SELECT * FROM tbjurnal");

foreach($data as $row)
{
    $dokumen =  preproses($row['judul']);
    
    $pisah = explode(' ',$dokumen);
    
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="referrer" content="strict-origin" />
    <title>Sistem Informasi Rumput Laut</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/sketchy/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<!-- Image and text -->

<body>
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
                <td scope="col">Kode Dokumen</td>
                <td scope="col">Term</td>
            </tr>
            <?php foreach($data as $row) : 
        $dokumen =  preproses($row['judul']);
        $pisah = explode(' ',$dokumen);
        $kode = $row['nm_dk'];
        foreach($pisah as $res) : ?>
            <tr>
                <td><?= $kode; ?></td>
                <td><?= $res; ?></td>
            </tr>
            <?php endforeach; ?>



            <?php endforeach; ?>
        </table>
    </div>
    <script type="text/javascript" src="assets/jquery/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>

</html>