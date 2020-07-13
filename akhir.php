<?php include "config/server.php"; 
// ===============================
// Status Ujian XStatusUjian = 1 Aktif
// Status Ujian XStatusUjian = 0 BelumAktif
// Status Ujian XStatusUjian = 9 Selesai
if(isset($_COOKIE['PESERTA'])){
$user = $_COOKIE['PESERTA'];} else {
header('Location:login.php');}

$tgl = date("H:i:s");
$tgl2 = date("Y-m-d");
				
		$sqltoken = mysql_query("SELECT * FROM `cbt_siswa_ujian` s left join cbt_ujian u on u.XKodeSoal = s.XKodeSoal
		WHERE s.XNomerUjian = '$user' and s.XStatusUjian = '1'");
		$st = mysql_fetch_array($sqltoken);
		$xtokenujian = $st['XTokenUjian'];  
		
		
		
		$sqlgabung = mysql_query("
		SELECT * FROM `cbt_siswa_ujian` s LEFT JOIN cbt_jawaban j ON j.XUserJawab = s.XNomerUjian and j.XTokenUjian = s.XTokenUjian left join cbt_siswa s1 on s1.XNomerUjian =
		s.XNomerUjian WHERE s.XNomerUjian = '$user' and s.XStatusUjian = '1'");
		  
		//=======================
		  $s0 = mysql_fetch_array($sqlgabung);
		  $xkodesoal = $s0['XKodeSoal'];
		  $xtokenujian = $s0['XTokenUjian'];  
		  $xnomerujian = $s0['XNomerUjian'];  
		  $xnik = $s0['XNIK'];    
		  $xkodeujian = $s0['XKodeUjian'];
		  $xkodemapel = $s0['XKodeMapel'];
		  $xkodekelas = $s0['XKodeKelas'];  
		  $xkodejurusan = $s0['XKodeJurusan']; 		
		  $xsemester = $s0['XSemester']; 		  
		  $xnamkel = $s0['XNamaKelas'];
		  
		  $sqlsoal = mysql_query("SELECT * FROM cbt_ujian  WHERE XKodeSoal = '$xkodesoal'");
		  $sa = mysql_fetch_array($sqlsoal);
		  //$xkodeujian = $sa['XKodeUjian'];
		  $xjumsoal = $sa['XJumSoal'];
		  $xjumpil = $sa['XPilGanda']; 	
		  $xtampil = $sa['XTampil'];
		  
		 $sql4 = mysql_query("SELECT * FROM cbt_mapel  WHERE XKodeMapel = '$xkodemapel'");
		  $km = mysql_fetch_array($sql4);
		  $kkm = $km['XKKM'];
		  
		  
		  if($xjumsoal>0){

	$sqlnilai = mysql_query(" SELECT * FROM cbt_paketsoal WHERE XKodeSoal = '$xkodesoal'");
	$sqn = mysql_fetch_array($sqlnilai);
	$per_pil = $sqn['XPersenPil'];	
	$per_esai = $sqn['XPersenEsai'];
	$xesai = $sqn['XEsai'];
	$xpilganda = $sqn['XPilGanda'];
$sqltahun = mysql_query("select * from cbt_setid where XStatus = '1'");
		$st = mysql_fetch_array($sqltahun);
		$tahunz = $st['XKodeAY'];
		  
$xjumbenarz = mysql_query("select count(XNilai) as benar from cbt_jawaban where XUserJawab = '$user' and XJenisSoal = '1' and XKodeSoal = '$xkodesoal' and XTokenUjian = '$xtokenujian' and XNilai = '1'");
		  $r = mysql_fetch_array($xjumbenarz);
		  $xjumbenar = $r['benar'];
		  $xjumsalah = $xjumpil-$xjumbenar;
		  $nilaix = ($xjumbenar/$xjumpil)*100;
		  if(isset($_COOKIE['beetahun'])){$setAY =$_COOKIE['beetahun'];}else{$setAY = "$tahunz";}
		  
		  //cek apakah nilai untuk token ini sudah ada atau tidak 
		  $sqlceknilai= mysql_num_rows(mysql_query("select * from cbt_nilai where XNomerUjian = '$xnomerujian' and XKodeSoal = '$xkodesoal' and XTokenUjian = '$xtokenujian' 
		  and XSemester = '$xsemester' and XSetId = '$setAY' and XKodeMapel = '$xkodemapel' and XNIK = '$xnik'"));
		  
		  if($sqlceknilai>0){
		  $sqlmasuk = mysql_query("update cbt_nilai set XJumSoal='$xjumsoal',XBenar='$xjumbenar',XSalah='$xjumsalah',XNilai='$nilaix',XTotalNilai=,'$nilaix'
		  where XNomerUjian = '$xnomerujian' and XKodeSoal = '$xkodesoal' and XTokenUjian = '$xtokenujian' and XSemester = '$xsemester' and XSetId = '$setAY' 
		  and XKodeMapel = '$xkodemapel' and XNIK = '$xnik'");
		  } else {
		  $sqlmasuk = mysql_query("insert into cbt_nilai (
		  XKodeUjian,XTokenUjian,XTgl,XJumSoal,XBenar,XSalah,XNilai,XKodeMapel,XKodeKelas,XKodeSoal,XNomerUjian,XNIK,XSemester,XSetId,XPersenPil,XPersenEsai,XTotalNilai,XPilGanda,XEsai,XNamaKelas) 
		  values 
		  ('$xkodeujian','$xtokenujian','$tgl2','$xjumsoal','$xjumbenar','$xjumsalah','$nilaix','$xkodemapel','$xkodekelas','$xkodesoal','$xnomerujian','$xnik','$xsemester',
		  '$setAY','$per_pil','$per_esai','$nilaix','$xpilganda','$xesai','$xnamkel')");
		  }
					
		  if(isset($xtokenujian)){
		  $sql = mysql_query("Update cbt_siswa_ujian set XStatusUjian = '9' where XNomerUjian = '$user' and XStatusUjian = '1'  and XTokenUjian = '$xtokenujian'");}
		  $sql = mysql_query("Update cbt_siswa_ujian set XStatusUjian = '9',XLastUpdate = '$tgl' where XNomerUjian = '$user' and XStatusUjian = '1'");

		  }
?>
<style>
.left {
    float: left;
    width: 70%;
}
.right {
    float: right;
    width: 30%;
	background-color: #333333;
			height:101px;	
		color:#FFFFFF;	
		font-size: 13px; font-style:normal; font-weight:normal;
}
.user {
		color:#FFFFFF;	
		font-size: 15px; font-style:normal; font-weight:bold;
		top:-20px;
}
.log {
		color:#3799c2;	
		font-size: 11px; font-style:normal; font-weight:bold;
		top:-20px;
}
.group:after {
    content:"";
    display: table;
    clear: both;
	
}
/*
img {
    max-width: 100%;
    height: auto;
}
*/

.visible{
    display: block !important;
}

.hidden{
    display: none !important;
}
.foto{height:80px;}	
.buntut{width:100%;bottom:0px; position:absolute;}	
@media screen and (max-width: 780px) { /* jika screen maks. 780 right turun */
/*    .left, */
    .left,
    .right {
        float: none;
        width: auto;
		margin-top:0px;
		height:101px;
		color:#FFFFFF;
		display:block;	
    }
.foto{height:80px;}	
.buntut{width:100%;bottom:0px; position:absolute;}		
}
@media screen and (max-width: 400px) { /* jika screen maks. 780 right turun */
/*    .left, */
    .left{width: auto;    height: 91px;}
    .right {
        float: none;
        width: auto;
		margin-top:0px;
		height:60px;
		color:#FFFFFF;
    }
.foto{height:60px;}	
.buntut{width:100%;bottom:0px; position:absolute;}	
}
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script type="text/javascript">
function mousedwn(e){try{if(event.button==2||event.button==3)return false}catch(e){if(e.which==3)return false}}document.oncontextmenu=function(){return false};document.ondragstart=function(){return false};document.onmousedown=mousedwn
</script>
<script type="text/javascript">
window.addEventListener("keydown",function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault()}});document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){}return false}
</script>
<script type="text/javascript">
document.onkeydown=function(e){e=e||window.event;if(e.keyCode==123||e.keyCode==18){return false}}
</script>  

<head>
<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Aplikasi UNBK | Login Untuk Memulai Ujian</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="Aplikasi UNBK, membantu anda sukses dalam ujian dengan memulai belajar test berbasis Komputer dengan beragam soal-soal ujian."> 
        <meta name="keyword" content="UNBK, Ujian, Ujian Nasional, Ulangan Harian, Ulangan Semester, Mid Semester, Test CPNS, Test SMBPTN">
        <meta name="google" content="nositelinkssearchbox" />
        <meta name="robots" content="index, follow">
    
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link href="css/mainam.css" rel="stylesheet">
        <link href="css/selectbox.min.css" rel="stylesheet">
</head>
<?php 

$sqllogin = mysql_query("SELECT * FROM  `cbt_siswa` WHERE XNomerUjian = '$user'");
 $sis = mysql_fetch_array($sqllogin);
 
  $xkodekelas = $sis['XKodeKelas'];
  $xnamkelas = $sis['XNamaKelas'];
  $xjurz = $sis['XKodeJurusan'];
  $val_siswa = $sis['XNamaSiswa'];
  $poto = $sis['XFoto'];  
  
  if($poto==''){
	  $gambar="avatar.gif";
  } else{
	  $gambar=$poto;
  } 
?>
<body class="font-medium" style="background-color:#c9c9c9">
<header class="masthead">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-md-12">
                <center><img src="css/logo.png"></center>
            </div>
        </div>
    </div>
    
</header>
<!--	
<header style="background-color:<?php echo "$log[XWarna]"; ?>">
<div class="group">
    <div class="left" style="background-color:<?php echo "$log[XWarna]"; ?>"><img src="images/<?php echo "$log[XBanner]"; ?>" style=" margin-left:0px;">
    </div>
    	<div class="right"><table width="100%" border="0" style="margin-top:10px">   
     					<tr><td rowspan="3" width="100px" align="center"><img src="./fotosiswa/<?php echo "$gambar"; ?>" style=" margin-left:0px; margin-top:5px" class="foto"></td>
						<td><span  class="user" style=" margin-left:0px; margin-top:5px">Terima Kasih</span></td></tr>
                        <tr><td><span class="user"><?php echo "$val_siswa <br>($xkodekelas-$xjurz | $xnamkelas)"; ?></span></td></tr>
                        <tr><td><span class="user"><br><span></td></tr>
						<tr></tr>
						</table>
                        </div>

      	
	</div> 
</div>         
</header>-->

     <link rel="stylesheet" href="mesin/css/bootstrap2.min.css">
     <link href="mesin/css/klien.css" rel="stylesheet">

    <script src="mesin/js/jquery.min.js"></script>
    <script src="mesin/js/bootstrap.min.js"></script>
<div class="grup" style="width:70%; margin:0 auto; margin-top:1px">
<div class="container-fluid ">
    <div class="main-content">
        <!-- Main Content -->
        <div class="main-content">
            <div class="container-fluid sm-width">
                <div class="row no-gutters" >
                    <div class="col-md-12">
                        <div class="content logo-bg">
							
				            <div class="panel-heading" style="text-align: center; font-size:22px; font-weight:bold">
				                Konfirmasi Tes
				            </div>

				            <div class="inner-content" style="height:320px">
				            	<div class="form-horizontal" style="margin-top:0px">


									<div class="inner-content">
			                            <div class="wysiwyg-content" style="text-align: center;">
			                                <p>	Terimakasih telah berpartisipasi dalam tes,</p>
			                                <p> silahkan klik tombol LOGOUT untuk mengakhiri tes.</p>
			                                <p>
												<br><br>	<?php 	if($xtampil=='1'){ ?>
												<br>	<font color="red">
															<?php echo 	"Nilai Pilihan Ganda Non Esai" 
															?>
												<br>	<font size="2" color="blue">
															<?php	
																	echo " KKM : ".$kkm."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Benar : ".$xjumbenar."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salah: ".$xjumsalah."</Font>"; 
															?>
												<br>
												<br>	<font size="7" color="blue">
												<?php
												
												echo " Nilai : ".$nilaix."</br></Font>";
												}
												?>
			                                   
			                                </p>
			                            </div>
			                        </div>
									<div class="panel-footer">
			                            <div class="row">
			                                <div class="col-xs-12"><a href="logout.php">
			                                    <button type="submit" class="btn btn-primary btn-block" data-dismiss="modal" style="border-radius: 30px;">LOGOUT</button>
			                                </div>
			                            </div>
			                        </div>            
								</div>
            				</div>
   						</div>
   					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</body>

</html>