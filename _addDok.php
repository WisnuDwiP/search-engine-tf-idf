<?php

    include 'koneksi.php';

    $sumber = $_POST['sumber'];
	$volume = $_POST['volume'];
	$nomor = $_POST['nomor'];
	$bulan = $_POST['bulan'];
	$tahun = $_POST['tahun'];
	$judul = $_POST['judul'];
	$isi = $_POST['isi'];
	$katakunci = $_POST['katakunci'];
	$kode = $_POST['kode'];
    
    

    if(empty($judul AND $isi AND $kode)){
        die("Form tidak boleh kosong");
    }
    else
    {
        $add = $konek->query("INSERT INTO `tbjurnal`(`sumber`,`volume`,`nomor`,`bulan`,`tahun`,`judul`,`abstrak`,`katakunci`,`nm_dk`) VALUES ('$sumber','$volume','$nomor','$bulan','$tahun','$judul','$isi','$katakunci','$kode')");
        if(!$add)
        {
            echo mysqli_error($konek);
        }
        else
        {
            header("Location:add_dokumen.php");
        }
    }

?>