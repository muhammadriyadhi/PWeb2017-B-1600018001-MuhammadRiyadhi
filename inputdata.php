<?php
	
	$db = new mysqli("localhost","root","","datapeserta"); //("server","username","password","nama Database")
	if ($db->connect_error) {
		echo "Belum Terhubung ke Database. ".$db->error;
	}
	else {
		echo "Sudah Terhubung ke Database";
	}

	$nama = $_POST['nama'];
	$asalclub = $_POST['asalclub'];
	$contactp = $_POST['contactp'];
	$j_kelamin = $_POST['jeniskelamin'];
	$kategori = $_POST['kategori'];

	$sql = "INSERT INTO peserta VALUES('id','$nama','$asalclub','$contactp','$j_kelamin','$kategori', now())"; //input ke tabel
	$query = $db->query($sql);
	if ($query) {
		echo "Berhasil Menginputkan data";
	}
	else {
		echo "Gagal Menginputkan Data".$db->error;
	}

?>