<div class="white-container">
    <legend class="rim2">Ubah <b>Asuransi Pinjaman</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Saasalaset Ms'=>array('index'),
           // $model->asalaset_id=>array('view','id'=>$model->asalaset_id),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Asal Aset ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAAsalasetM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAAsalasetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAAsalasetM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->asalaset_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Asal Aset', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // STANDARD NYA 1 FORM >> echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</div>