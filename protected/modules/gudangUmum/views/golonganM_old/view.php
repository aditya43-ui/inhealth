<div class='white-container'>
    <legend class='rim2'>Lihat <b>Golongan</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sagolongan Ms' => array('index'),
        $model->golongan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Golongan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUGolonganM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUGolonganM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' GUGolonganM', 'icon'=>'pencil','url'=>array('update','id'=>$model->golongan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' GUGolonganM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->golongan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'golongan_id',
            'golongan_kode',
            'golongan_nama',
            'golongan_namalainnya',
            'golongan_aktif',
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Golongan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/gudangUmum/golonganM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>