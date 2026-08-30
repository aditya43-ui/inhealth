<div class="white-container">
    <legend class="rim2">Ubah <b>Pemeriksaan Radiologi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapemeriksaan Rad Ms'=>array('index'),
            $model->pemeriksaanrad_id=>array('view','id'=>$model->pemeriksaanrad_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pemeriksaan Radiologi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPemeriksaanRadM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAPemeriksaanRadM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAPemeriksaanRadM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pemeriksaanrad_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemeriksaan Radiologi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modReferensiHasil'=>$modReferensiHasil,)); ?>
</div>