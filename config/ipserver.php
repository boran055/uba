<?php
include "server.php";

$sql = mysql_query("select * from server_pusat");
$xadm = mysql_fetch_array($sql);
$ipserver= $xadm['XIPSekolah'];
$kodesekolah= $xadm['XServerId'];
$db_userm= $xadm['XUsername'];
$db_pasw= $xadm['XPass'];
$db_nama= $xadm['XDbName'];

$user_name = "$admin"; // sesuaikan dengan akun privileges
$password = "$Tamsis123456"; // sesuaikan dengan password privileges
$database = "$master";
$host_name = "$beesmart9.herokuapp.com"; // Nama Komputer SERVER atau nama domain kalau hosting
