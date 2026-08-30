<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Bahan Menu Diet</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Gzbahanmenudiet Ms' => array('index'),
            $model->bahanmenudiet_id => array('view', 'id' => $model->bahanmenudiet_id),
            'Update',
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Provinsi', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Provinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Provinsi', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->bahanmenudiet_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Menu Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;
        ?>

        <?php echo $this->renderPartial('_formBaru', array('model' => $model, 'getAll' => $getAll)); ?>
    </div>
</div>