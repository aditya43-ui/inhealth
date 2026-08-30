<div class='white-container'>
    <legend class='rim2'>Lihat Penyebab <b>Luar Cedera</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmpenyebab Luar Cedera Ms'=>array('index'),
            $model->penyebabluarcedera_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Penyebab Luar Cedera ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKPenyebabLuarCederaM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKPenyebabLuarCederaM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKPenyebabLuarCederaM', 'icon'=>'pencil','url'=>array('update','id'=>$model->penyebabluarcedera_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKPenyebabLuarCederaM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->penyebabluarcedera_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penyebab Luar Cedera', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'penyebabluarcedera_id',
                    'penyebabluarcedera_nama',
                    'penyebabluarcedera_namalainnya',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->penyebabluarcedera_aktif==1)? "Ya" : "Tidak"),
                                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>