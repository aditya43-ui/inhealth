<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>PBF</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pbf' => array('admin'),
            $model->pbf_id => array('view', 'id' => $model->pbf_id),
            'Update',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pbf ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pbf', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pbf', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pbf', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->pbf_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pbf', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
    </div>
</div>