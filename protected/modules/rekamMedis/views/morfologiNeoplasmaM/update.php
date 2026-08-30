<div class='white-container'>
    <legend class='rim2'>Ubah <b>Morfologi Neoplasma</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmmorfologi Neoplasma Ms'=>array('index'),
            $model->morfologineoplasma_id=>array('view','id'=>$model->morfologineoplasma_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Morfologi Neoplasma ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKMorfologiNeoplasmaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKMorfologiNeoplasmaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKMorfologiNeoplasmaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->morfologineoplasma_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Morfologi Neoplasma', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>