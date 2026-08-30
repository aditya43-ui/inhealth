<div class='white-container'>
    <legend class='rim2'>Tambah <b>Kelompok</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                   // array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUKelompokM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>