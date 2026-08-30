<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Formulir Transfer Pasien
        </div>
    </div>
    <div class="panel-body">

	<?php 
	$this->breadcrumbs=array(
		'Daftar Pasien'=>Yii::app()->request->urlReferrer,
		'Formulir Transfer Pasien',
	);
	?>
        
	<?php 
        if(empty($_GET['frame'])){
            $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
        }
        $this->renderPartial($this->path_view.'_riwayatFormulirTransfer',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
	?>
        <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title"><strong>Input Transfer Pasien</strong></div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
            <div>
            <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
            </div>
        </div>
        </div>
        
	
    </div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien, 'modPendaftaran'=>$modPendaftaran)); ?>