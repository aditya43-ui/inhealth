<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Komponen Jasa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Komponenjasa Ms' => array('index'),
            $model->komponenjasa_id => array('view', 'id' => $model->komponenjasa_id),
            'Update',
        );

        //$arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KomponenjasaM #'.$model->komponenjasa_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KomponenjasaM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KomponenjasaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' KomponenjasaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->komponenjasa_id))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' KomponenjasaM', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
        //
        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial('_formUpdate', array('model' => $model)); ?>
        <?php //$this->widget('UserTips',array('type'=>'update'));
        ?>
    </div>
</div>