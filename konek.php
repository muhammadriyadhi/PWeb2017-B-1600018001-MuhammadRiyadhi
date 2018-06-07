
<?php
	//membuat koneksi
	require "db.php";
	
	require 'PHPMailer/PHPMailerAutoload.php';

	$pin = rand(1000000,9999999);
	$email = $_POST['email'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$harga = $_POST['harga'];
	if($harga == 200000){
		$jenistiket = 'festivel daily pass';
	}else{
		$jenistiket = 'festivel 3 days pass';
	}

	$mail = new PHPMailer;

	// Konfigurasi SMTP
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'muhammad1600018001@webmail.uad.ac.id';
	$mail->Password = 'dozikindonesia08';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;

	$mail->setFrom('muhammad1600018001@webmail.uad.ac.id', 'Prambanan Music Jazz');
	$mail->addReplyTo('muhammad1600018001@webmail.uad.ac.id', 'Prambanan Music Jazz');

	// Menambahkan penerima
	$mail->addAddress("$email");

	// Menambahkan beberapa penerima
	//$mail->addAddress('penerima2@contoh.com');
	//$mail->addAddress('penerima3@contoh.com');

	// Menambahkan cc atau bcc 

	// Subjek email
	$mail->Subject = 'Kirim Email via SMTP Server di PHP menggunakan PHPMailer';

	// Mengatur format email ke HTML
	$mail->isHTML(true);

	// Konten/isi email
	$mailContent = "<h1>Anda telah terdaftar</h1>
					<p>Silahkan lakukan transfer ke Rekening Kami</p>
					<p>No. Rekening : 192-3888-827424 (BNI)</p>
					<p>Atas Nama 	: Muhammad Riyadhi</p>
					<p>jika sudah. silahkan verifikasi pembayaran anda disini</p>
					<p>PIN ANDA : '$pin' </p>
					<p>http://localhost/aplikasi/verifikasi.php?pin=$pin&&email=$email</p>";
	$mail->Body = $mailContent;

	// Menambahakn lampiran
	$mail->addAttachment('lmp/file1.pdf');
	$mail->addAttachment('lmp/file2.png', 'nama-baru-file2.png'); //atur nama baru

	// Kirim email
	if(!$mail->send()){
		echo '<script>Pesan gagal dikirim</script>';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}else{
		echo '<script>Pesan berhasil dikirim</script>';
	}

	echo '<a href="./index.html">kembali ke halaman utama</a>';
	$sql = "INSERT INTO datapemesan(email, nama, alamat)
			VALUES ('$email','$nama', '$alamat')";
	$sts = "INSERT INTO statuspembayaran VALUES ('$pin', '', 'WAITING')";		
	$x = "INSERT INTO datatiket(pin, tanggal, jenistiket, email, harga) VALUES ('$pin',NOW(),'$jenistiket','$email','$harga')";	
	mysqli_query($konek, "INSERT INTO `status`VALUES ('$email','foto.jpg','waiting')");
	if(mysqli_query($konek, $sql)){
		mysqli_query($konek, $x);
		mysqli_query($konek, $sts);
?>
		
			<script src="swal.min.js"></script>
			<script>
				swal('Congratulations', 'Data Sucses Saved', 'success');
			</script>
<?php
		// echo "Registrasi Tersimpan!<br>";
		}
	else{
?>
		<!-- echo "Registrasi Gagal : ".$konek->error."<br/>"; -->
		<script src="swal.min.js"></script>
			<script>
				swal('Failed', 'the email that you enter has been used', 'warning');
			</script>
<?php
	}
	// $konek->close();
	
	// echo"<a href='register.html'>Tambah Registrasi</a>";
?>