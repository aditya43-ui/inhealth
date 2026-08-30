<fieldset class="box row">
    <legend class="rim">Ubah Jenis Napza</legend>
    <?php
    $this->breadcrumbs=array(
            'Sajenisnapza Ms'=>array('index'),
            $model->jenisnapza_id=>array('view','id'=>$model->jenisnapza_id),
            'Update',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Napza ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisnapzaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAJenisnapzaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SAJenisnapzaM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenisnapza_id))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Napza', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
</fieldset>