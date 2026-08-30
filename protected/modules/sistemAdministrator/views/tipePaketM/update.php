<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Tipe Paket</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Tipe Paket' => array('admin'),
            $model->tipepaket_id => array('view', 'id' => $model->tipepaket_id),
            'Update',
        );

        //$arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tipe Paket '.$model->tipepaket_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        ////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Paket', 'icon'=>'list', 'url'=>array('index'))) ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Paket', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        ////                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tipe Paket', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->tipepaket_id))) ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Paket', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
        //
        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>
    </div>
</div>