<div class="white-container">
    <legend class="rim2">Ubah <b>Bahan Makanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sabahanmakanan Ms'=>array('index'),
            $model->bahanmakanan_id=>array('view','id'=>$model->bahanmakanan_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bahan Makanan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->bahanmakanan_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Makanan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'zatgizi'=>$zatgizi)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>