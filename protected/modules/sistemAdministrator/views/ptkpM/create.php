<div class="panel panel-gradient">
    <div class="panel-heading">
        <?php if ($this->hasTab) : ?>
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>PTKP</b>
            </div>
        <?php else : ?>
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>PTKP</b>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'TPKP' => array('admin'),
            'Create',
        );
        $arrMenu = array();
        //              array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //              array_push($arrMenu,array('label'=>Yii::t('mds','List').' KomponengajiM', 'icon'=>'list', 'url'=>array('index'))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'   Komponen gaji', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        //$this->renderPartial('_tabMenu',array());
        ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>