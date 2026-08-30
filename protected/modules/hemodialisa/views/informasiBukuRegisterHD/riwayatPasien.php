<div class="white-container">
    <legend class="rim2">Riwayat Pasien <b><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></b></legend>

	<?php 
	$this->breadcrumbs=array(
		'Sapendidikan Ms'=>array('index'),
		'Manage',
	);
	?>
	<?php 
	$this->renderPartial('_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
	$this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>
    

</div>