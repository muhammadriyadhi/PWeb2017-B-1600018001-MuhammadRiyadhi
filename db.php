<?php
    $host = "localhost";
	$username = "root";
	$password = "";
	$db_name = "datatiket";

	$konek = mysqli_connect($host, $username, $password, $db_name);
	//mengecek oneksi
	// if($konek->connect_error){
	// die("koneksi Gagal Karena : ".$konek->connect_error);
    // }
?>