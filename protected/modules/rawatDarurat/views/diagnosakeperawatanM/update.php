<?php
if(isset($_GET['sukses'])){
	if($_GET['sukses']==0){
		Yii::app()->user->setFlash('error', '<b>Gagal!</b> tidak dapat diupdate. kerena digunakan di rencanakeperawatan_m');
	}
}
?>
<div class="white-container">
    <legend class="rim2">Ubah <b>Diagnosa Keperawatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadiagnosakeperawatan Ms'=>array('index'),
            $model->diagnosakeperawatan_id=>array('view','id'=>$model->diagnosakeperawatan_id),
            'Update',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Diagnosa Keperawatan '.$model->diagnosakeperawatan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RDDiagnosakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RDDiagnosakeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RDDiagnosakeperawatanM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->diagnosakeperawatan_id))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Keperawatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modIdDiagnosa'=>$modIdDiagnosa, 'modDiagnosa'=>$modDiagnosa)); ?>
</div>