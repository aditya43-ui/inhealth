<div class="white-container">
    <legend class="rim2">Ubah <b>Obat Supplier</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfsupplier Ms'=>array('index'),
            'Update',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Obat Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Supplier', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array(
                                        'model'=>$model,
                                        'modObatSupplier'=>$modObatSupplier,
                                        'modDetail'=>$modDetail,
                                        'modDetails'=>$modDetails,
                                        'modObat'=>$modObat)); ?>
</div>