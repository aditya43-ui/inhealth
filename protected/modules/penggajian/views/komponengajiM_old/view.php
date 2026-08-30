<div class="white-container">
    <legend class="rim2">Lihat <b>Komponen Gaji</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Komponengaji Ms' => array('index'),
        $model->komponengaji_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').'  Komponen gaji  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KomponengajiM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' KomponengajiM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' KomponengajiM', 'icon'=>'pencil','url'=>array('update','id'=>$model->komponengaji_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' KomponengajiM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->komponengaji_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Komponen gaji ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'komponengaji_id',
            'nourutgaji',
            'komponengaji_kode',
            'komponengaji_nama',
            'komponengaji_singkt',
            'ispotongan',
            array(
                'label' => 'Potongan',
                'value' => (($model->ispotongan == 1) ? "Ya" : "Tidak"),
            ),
            array(
                'label' => 'Aktif',
                'value' => (($model->komponengaji_aktif == 1) ? "Ya" : "Tdak"),
            ),
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Komponen Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('komponengajiMGJ/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>