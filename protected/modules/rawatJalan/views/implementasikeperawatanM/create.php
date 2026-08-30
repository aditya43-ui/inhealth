<fieldset class='box'>
    <legend class="rim">Tambah Implementasi Keperawatan</legend>
    <?php
    $this->breadcrumbs=array(
            'Saimplementasikeperawatan Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Implementasi Keperawatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJImplementasikeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Implementasi Keperawatan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>