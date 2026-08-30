<div class="white-container">
    <legend class="rim2">Lihat <b>Implementasi Keperawatan</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Saimplementasikeperawatan Ms' => array('index'),
        $model->implementasikeperawatan_id,
    );

    $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Implementasi Keperawatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RIImplementasikeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RIImplementasikeperawatanM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RIImplementasikeperawatanM', 'icon'=>'pencil','url'=>array('update','id'=>$model->implementasikeperawatan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RIImplementasikeperawatanM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->implementasikeperawatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'implementasikeperawatan_id',
            'diagnosakeperawatan_id',
            'rencanakeperawatan_id',
            'implementasikeperawatan_kode',
            'implementasi_nama',
            'iskolaborasiimplementasi',
            array(
                'type' => 'raw',
                'label' => 'Kolaborasi implementasi',
                'value' => (($model->iskolaborasiimplementasi) ? "Ya" : "Tidak"),
            ),
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Implementasi Keperawatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>