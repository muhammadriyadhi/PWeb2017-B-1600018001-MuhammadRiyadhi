<?php
require_once 'db.php';
$sql = "SELECT * from datatiket, statuspembayaran where datatiket.pin = statuspembayaran.pin"; //id, nama, email, kelas, jumlah, total, status, jam daftar
// $j = "SELECT * FROM tiket";
$result = mysqli_query($konek, $sql);
// $data = mysqli_fetch_array($result);

?>

<center><br>
    <strong>
<!DOCTYPE html>
<html>
<head>
<title>Report</title>
</head>
<body style="background: black; color: white">
    <br><br><h1>TABEL DATA PEMBELI TIKET</h1>
</body>
</html>
<?php
    echo "<table border='1'>
            <tr>
                <th> PIN</th>
                <th> Tanggal</th>
                <th> Jenis Tiket</th>
                <th> Email</th>
                <th> Harga</th>
                <th> Status</th>  
            </tr>";
if ($result ->num_rows > 0) {
    // output data of each row
    while($value = mysqli_fetch_array($result)){
    	echo "<tr> 
                 <td>".$value['pin']."</td>
                 <td>".$value["tanggal"]."</td> 
                 <td>".$value["jenistiket"]."</td>
                 <td>".$value["email"]."</td> 
                 <td>".$value["harga"]."</td>
                 <td>".$value["statustiket"]."</td>
             </tr>";
    }
} else {
    echo "0 results";
}
        echo "</table>";
        

    $a = 0;
    $sql = "SELECT count(*) from datatiket";
    $query = $konek->query($sql);
    $a = $query->fetch_array();
        echo "<br>Jumlah Pemesan : ".$a[0];

    $b = 0;
    $sql = "SELECT count(*) from statuspembayaran where statustiket = 'waiting'";
    $query = $konek->query($sql);
    $b = $query->fetch_array();
        echo "<br>Jumlah Pemesan Status Belum Bayar : ".$b[0];

    $c = 0;
    $sql = "SELECT count(*) from statuspembayaran where statustiket = 'confirmed'";
    $query = $konek->query($sql);
    $c = $query->fetch_array();
        echo "<br>Jumlah Pemesan Status Sudah Bayar : ".$c[0];

    // $x = 0;
    // $sql = "SELECT count(*) from tiket where status = 'confirmed'";
    // $query = $conn->query($sql);
    // $x = $query->fetch_array();
    //     echo "<br>Jumlah Pendfaftar Yang Sudah Bayar : ".$x[0];

    $d = 0;
    $sql = "SELECT sum(harga) from datatiket, statuspembayaran where statuspembayaran.statustiket = 'confirmed' and datatiket.pin = statuspembayaran.pin";
    $query = $konek->query($sql);
    // print_r($query);
    $d = $query->fetch_array();
        echo "<br>Total Pembayaran: ".$d[0];

    $f = 0;
    $sql = "SELECT sum(harga) from datatiket, statuspembayaran where statuspembayaran.statustiket = 'waiting' and datatiket.pin = statuspembayaran.pin";
    $query = $konek->query($sql);
    $f = $query->fetch_array();
        echo "<br>Total Yang Belum Bayar: ".$f[0];
?>
</strong>
</center>