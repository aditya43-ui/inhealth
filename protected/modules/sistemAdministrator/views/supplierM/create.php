<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Supplier</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Supplier' => array('admin'),
            'Tambah',
        );
        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Supplier', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modObatSupplier' => $modObatSupplier, 'latitude' => $latitude, 'longitude' => $longitude)); ?>
    </div>
</div>