<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Obat Supplier</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Obat Supplier' => array('admin'),
            'Update',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Obat Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Obat Supplier', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array(
            'model' => $model,
            'modObatSupplier' => $modObatSupplier,
            'modDetail' => $modDetail,
            'modDetails' => $modDetails,
            'modObat' => $modObat
        ));
        ?>
    </div>
</div>