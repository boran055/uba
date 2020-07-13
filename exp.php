<?php 
if(isset($_SERVER['HTTP_COOKIE'])){$kue = $_SERVER['HTTP_COOKIE'];
	$cookies = explode(';', $kue);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $user = trim($parts[0]);
        setcookie($user, '', time()-1000);
        setcookie($user, '', time()-1000, '/');
		setcookie("user", '', time()-1000);
		setcookie("apl", '', time()-1000);		
    	unset($_COOKIE['user']);
    	setcookie('user', '', time() - 3600, '/'); // empty value and old timestamp
    }
}

?>
<!DOCTYPE html>
<!--<html lang="en">-->
<html>	
<script type="text/javascript">
function mousedwn(e){try{if(event.button==2||event.button==3)return false}catch(e){if(e.which==3)return false}}document.oncontextmenu=function(){return false};document.ondragstart=function(){return false};document.onmousedown=mousedwn
</script>
<script type="text/javascript">
window.addEventListener("keydown",function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault()}});document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){}return false}
</script>
<script type="text/javascript">
document.onkeydown=function(e){e=e||window.event;if(e.keyCode==123||e.keyCode==18){return false}}
</script>  


<?php
$tgl_now=date("Y-m-d");//tanggal sekarang
$tgl_launching="2020-2-22";// tanggal launching aplikasi
$jangka_waktu = strtotime('+180 days', strtotime($tgl_launching));// jangka waktu + 365 hari
$tgl_exp=date("Y-m-d",$jangka_waktu);//tanggal expired
if ($tgl_now >=$tgl_exp )
{
	
 echo"<center><h1>Masa uji coba applikasi telah habis</h1>
 <h3>Silahkan hubungi melalui email : komunitastik.com@gmail.com<h3></center>";
}
else
{
?>


<footer>
	<div class="container-fluid">
		<div class="row no-gutters">
			<div class="col-md-12">
				<div class="copyright">v02.03.2020 - Copyrights © 2020, <a href="http://smkyasmu.sch.id" target="_blank">CBT Application | </a>modified by <a href="http://daffamedia.web.id" target="_blank">zulkhaidir</a></div>
			</div>
		</div>
	</div>
</footer>

