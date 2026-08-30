<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Jadwal Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Gzjadwalmakan Ms' => array('index'),
            $model->jadwalmakan_id => array('view', 'id' => $model->jadwalmakan_id),
            'Update',
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jadwal Makan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jadwal Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jadwal Makan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jadwal Makanan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jadwalmakan_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jadwal Makan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
    </div>
</div>