<div class='white-container'>
    <legend class='rim2'>Ubah Jenis <b>Infeksi Nosokomial</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmjenis Infeksi Nosokomial Ms'=>array('index'),
            $model->jenisin_id=>array('view','id'=>$model->jenisin_id),
            'Update',
    );
    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Infeksi Nosokomial', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKJenisInfeksiNosokomialM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKJenisInfeksiNosokomialM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' RKJenisInfeksiNosokomialM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenisin_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Infeksi Nosokomial', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</div>