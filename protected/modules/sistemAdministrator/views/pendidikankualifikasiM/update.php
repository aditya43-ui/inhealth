<div class="white-container">
    <legend class="rim2">Ubah <b>Kualifikasi Pendidikan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapendidikankualifikasi Ms'=>array('index'),
            $model->pendkualifikasi_id=>array('view','id'=>$model->pendkualifikasi_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kualifikasi Pendidikan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kualifikasi Pendidikan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kualifikasi Pendidikan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kualifikasi Pendidikan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pendkualifikasi_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kualifikasi Pendidikan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</div>