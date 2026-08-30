<div class='white-container'>
    <legend class='rim2'>Tambah <b>Pelayanan Rekening</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jurnal Rekening Penjamin Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pelayanan Rekening ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pelayanan Rekening', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modTindakanRuangan'=>$modTindakanRuangan)); ?>
</div>