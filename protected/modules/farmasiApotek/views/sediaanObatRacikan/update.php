<fieldset class="box">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-edit"></i> Ubah <b>Sediaan Obat Racikan</b>
            </div>
        </div>
        <div class="panel-body">
            <?php
            $this->breadcrumbs = array(
                'Sajenisnapza Ms' => array('index'),
                $model->lookup_id => array('view', 'id' => $model->lookup_id),
                'Update',
            );
            $arrMenu = array();
            array_push($arrMenu, array('label' => Yii::t('mds', 'Update') . ' Sediaan Obat Racikan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' FALookupM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' FALookupM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id))) ;
            (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Sediaan Obat Racikan', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

            //$this->menu=$arrMenu;
            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('model' => $model)); ?>
        </div>
    </div>
</fieldset>