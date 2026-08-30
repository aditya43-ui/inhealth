<!--div class='white-container'-->
<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Pasien</b></div>
	</div>
	<div class="panel-body">
		<?php 
		$this->breadcrumbs=array(
				'Pemeriksaan Pasien'=>array('index'),
				'Manage',
		);
		?>
		<?php 
		$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
		$this->renderPartial($this->path_view.'_tabMenu',array());
		$this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien, 'modPendaftaran'=>$modPendaftaran)); ?>
		<div>
		<iframe id="frame" class='biru' src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
		</div>
	</div>
</div>
<?= $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>
<!--/div-->