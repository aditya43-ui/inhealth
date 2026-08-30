<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'gzbahanmakanan Ms' => array('index'),
            $model->bahanmakanan_id => array('view', 'id' => $model->bahanmakanan_id),
            'Update',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bahan Makanan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->bahanmakanan_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Makanan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'zatgizi' => $zatgizi, 'modZatBahanMakananM' => $modZatBahanMakananM)); ?>
        <!--</div>-->
    </div>
</div>