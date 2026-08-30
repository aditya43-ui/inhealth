<div class='white-container'>
    <legend class='rim2'>Ubah Sebab <b>Infeksi Nosokomial</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmsebab Infeksi Nosokomial Ms'=>array('index'),
            $model->sebabin_id=>array('view','id'=>$model->sebabin_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Sebab Infeksi Nosokomial ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKSebabInfeksiNosokomialM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKSebabInfeksiNosokomialM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKSebabInfeksiNosokomialM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->sebabin_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sebab Infeksi Nosokomial', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>