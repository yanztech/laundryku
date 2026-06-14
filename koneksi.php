<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "laundryku";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>