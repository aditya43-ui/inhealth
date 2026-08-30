<?php
//RND-6174
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


$this->pageTitle=Yii::app()->name." - ".$judul;
$this->breadcrumbs=array(
	$judul,
);
?>

<legend class="rim2"><?php echo $judul; ?></legend>

<div class="error">
<?php echo $pesan;?><br>
<?php echo "Link:".$actual_link;?><br>
</div>
<div>
    <blink><img src="<?php echo Params::pathImageErrorAdmin().'admin.jpg' ?> " align="right" width="20%" height="20%" style="margin-right:400px"></blink></br>
</div>
