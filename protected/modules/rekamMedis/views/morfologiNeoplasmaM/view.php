<div class='white-container'>
    <legend class='rim2'>Lihat <b>Morfologi Neoplasma</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmmorfologi Neoplasma Ms'=>array('index'),
            $model->morfologineoplasma_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Morfologi Neoplasma ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKMorfologiNeoplasmaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKMorfologiNeoplasmaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKMorfologiNeoplasmaM', 'icon'=>'pencil','url'=>array('update','id'=>$model->morfologineoplasma_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKMorfologiNeoplasmaM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->morfologineoplasma_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Morfologi Neoplasma', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'morfologineoplasma_id',
                    'morfologineoplasma_nama',
                    'morfologineoplasma_namalainnya',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->morfologineoplasma_aktif==1)? "Ya" : "Tidak"),
                                    )
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>