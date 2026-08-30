<div class="white-container">
    <legend class="rim2">Ubah <b>Implementasi Keperawatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Saimplementasikeperawatan Ms'=>array('index'),
            $model->implementasikeperawatan_id=>array('view','id'=>$model->implementasikeperawatan_id),
            'Update',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Implementasi Keperawatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RIImplementasikeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RIImplementasikeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RIImplementasikeperawatanM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->implementasikeperawatan_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Implementasi Keperawatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modImplementasiKeperawatan'=>$modImplementasiKeperawatan, 'modDiagnosakeperawatan'=>$modDiagnosakeperawatan)); ?>
</div>