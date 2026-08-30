<?php 
$this->breadcrumbs=array(
	'Sapendidikan Ms'=>array('index'),
	'Manage',
);
?>
<?php 
$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
$this->renderPartial($this->path_view.'_tabMenu',array());
$this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien)); ?>
<div>
<iframe id="frame" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
</div>

