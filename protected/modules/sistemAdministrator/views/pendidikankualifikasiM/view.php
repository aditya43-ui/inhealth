<div class="white-container">
    <legend class="rim2">Lihat <b>Kualifikasi Pendidikan</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sapendidikankualifikasi Ms' => array('index'),
        $model->pendkualifikasi_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kualifikasi Pendidikan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kualifikasi Pendidikan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kualifikasi Pendidikan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kualifikasi Pendidikan', 'icon'=>'pencil','url'=>array('update','id'=>$model->pendkualifikasi_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kualifikasi Pendidikan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pendkualifikasi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kualifikasi Pendidikan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'pendkualifikasi_id',
            'pendkualifikasi_kode',
            'pendkualifikasi_nama',
            'pendkualifikasi_namalainnya',
            'pendkualifikasi_keterangan',
            'pendkualifikasi_aktif',
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->pendkualifikasi_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kualifikasi Pendidikan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/sistemAdministrator/PendidikankualifikasiM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>