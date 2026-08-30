<?php
/**
 * view utama untuk menampilkan interface dan form menu pemeriksaan pasien
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pemeriksaan Pasien <b><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></b>
        </div>
    </div>
    <div class="panel-body">

	<?php 
	$this->breadcrumbs=array(
		'Daftar Pasien'=>array('daftarPasien/'),
		'Pemeriksaan Pasien',
	);
	?>
	<?php 
	$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
	$this->renderPartial('_tabMenu',array());
	$this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>
	<div>
	<iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
	</div>
    </div>
</div>