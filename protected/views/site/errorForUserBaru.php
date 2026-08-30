<?php
$this->pageTitle=Yii::app()->name . ' - Hubungi Admin';
$this->breadcrumbs=array(
	'Hubungi Admin',
);

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$judul = "Fitur ini tidak / belum tersedia !";
$pesan = "Mohon maaf fitur ini tidak / belum tersedia, silakan hubungi admin / technical support untuk bantuan lebih lanjut. Kode: ".$code;
if($code == '403'){
	$judul = "Anda tidak diperbolehkan mengakses halaman ini !";
	$pesan = "Mohon maaf Anda tidak diperbolehkan mengakses halaman ini. Silakan :"
			. "<ol>"
			. "<li>Login sesuai dengan pemakai yang telah diberikan akses ke fitur ini</li>"
			. "<li>Atur hak akses pemakai di modul sistem administrator - login pemakai</li>"
			. "<li>Hubungi admin / technical support untuk bantuan lebih lanjut. Kode: ".$code."</li>"
			. "</ol>";
}else if($code == '500'){
	$judul = "Ada kesalahan pengaturan / data di database !";
	$pesan = "Mohon maaf, ada kesalahan pengaturan/data di database. Silakan hubungi admin/technical support untuk bantuan lebih lanjut.";
}else if($code == '400'){
	$judul = "Ada kesalahan pengiriman data !";
	$pesan = "Mohon maaf, ada kesalahan pengiriman data. Silakan :"
			. "<ol>"
			. "<li>Cek link serta parameter</li>"
			. "<li>Hindari penggunaan forward / next pada browser</li>"
			. "<li>Hubungi admin / technical support untuk bantuan lebih lanjut. Kode: ".$code."</li>"
			. "</ol>";
}

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
// $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
?>
<div class="col-sm-12">
    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-body" style="background-color:#fff;border:2px solid #E87A25;">
<table>
	<tr>
		<td width="50%" style="vertical-align:middle;">
			<h1 style="font-size:200px;color:#21A5A7;text-align:center;"><?php echo $code; ?></h1>			
		</td>
		<td class="" style="vertical-align:middle;padding-left:30px;border-left: 3px solid #E87A25;"><b>

	<h4><?php echo $judul ?></h4>
    <?php echo $pesan; ?>
	<br>
	<!--h4>SILAHKAN COBA SALAH SATU HALAMAN BERIKUT:</h4-->
		<!--ol>
				<li><a href="http://localhost/javamedica/" title="Menuju ke halaman utama">Halaman Utama</a></li>
        <li><span><a href="mailto:pi.informasi@gmail.com">Contact Webmaster</a></li>
		</ol-->
		<a style="color:blue;" href="<?php echo $this->createUrl('/site/logout'); ?>">Silakan Logout dan Login kembali</a><br/>
		<?php
			if (!empty($modul_nama)){
		?>
				<label>atau</label><br/>
				<a style="color:blue;" href="<?php 					
					echo $this->createUrl('/'.$modul_nama->url_modul); 
				?>">Silakan kembali ke dashboard modul <?php echo $modul_nama->modul_nama; ?></a>
		<?php
			}
		?>
</td>
</tr>
</table>
</div>
</div>
</div>
<!--div >
    <blink><img src="<?php echo Params::pathImageErrorAdmin().'admin.jpg' ?> " align="right" width="20%" height="20%" style="margin-right:400px"></blink></br>
</div-->
<br>
