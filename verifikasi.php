<!DOCTYPE html>
<?php

    if(isset($_GET['pin'])){
        $pin = $_GET['pin'];
        $email = $_GET['email'];
    } else {
        $pin = '';
    }
    
    require 'PHPMailer/PHPMailerAutoload.php';
    require "db.php";
    if($_POST){
        $ekstensi_diperbolehkan	= array('png','jpg');
        $nama = $_FILES['image']['name'];
        $x = explode('.', $nama);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];	

        $pin = $_POST['pin'];

        // $sql = "SELECT * from datapemesan where email='$email'";
        $sql = "SELECT * from datatiket";
        $result = mysqli_query($konek, $sql);
        $data = mysqli_fetch_array($result);

        // echo $pin[0];
        if($pin == $data[3]) {
            $pin = $data[0];
        }

        

        // print_r();
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if($ukuran < 1044070){			
                move_uploaded_file($file_tmp, 'uploads/'.$nama);
                echo $nama;
                $query = mysqli_query($konek, "UPDATE `statuspembayaran` SET photo='$nama', statustiket='confirmed' WHERE pin = '$pin'");
                // mysqli_query($konek, $query);
                if($query){
                    echo '<script>alert("Photo Berhasil terupload")</script>';
                    $mail = new PHPMailer;

	                // Konfigurasi SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'muhammad1600018001@webmail.uad.ac.id';
                    $mail->Password = 'dozikindonesia08';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('muhammad1600018001@webmail.uad.ac.id', 'International Coffee Day');
                    $mail->addReplyTo('muhammad1600018001@webmail.uad.ac.id', 'International Coffee Day');

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
                    $mailContent = "<h1> Selamat, Akun anda sudah verified !</h1>
                                    <p>Silahkan datang pada tanggal antara 17, 18, atau 19 Agustus 2018 untuk daily pass</p>
                                    <p>dan silahkan datang pada tanggal 17, 18, 19 Agustus 2018 untuk 3 days pass</p>
                                    <p>Serahkan PIN pembayaran anda ketika sudah di gerbang</p>
                                    <p>PIN ANDA : '$pin' </p>";
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
                }else{
                    echo '<script>alert("Photo Gagal terupload")</script>';
                }
            }else{
                echo '<script>alert("Ukuran Photo terlalu besar")</script>';
            }
        }else{
            echo '<script>alert("Ekstensi tidak diperbolehkan")</script>';
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="pin">pin</label><input type="text" name="pin" value="<?=$pin?>"><br>
        <label for="Photo">Photo</label><input type="file" name="image"> <br>
        <input type="submit">
    </form>
</body>
</html>