<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Kelas Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php // $this->renderPartial('_tab'); 
        ?>
        <?php
        $this->breadcrumbs = array(
            'Kelas Ruangan' => array('admin'),
            $model->ruangan_id => array('view', 'id' => $model->ruangan_id),
            'Ubah',
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Kelas Ruangan '/*.$model->ruangan_id*/, 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelas Ruangan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->ruangan_id))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelas Ruangan', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model, 'modRuangan' => $modPelayanan)); ?>
    </div>
</div>