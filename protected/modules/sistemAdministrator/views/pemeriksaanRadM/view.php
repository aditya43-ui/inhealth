<div class="white-container">
    <legend class="rim2">Lihat <b>Pemeriksaan Radiologi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapemeriksaan Rad Ms'=>array('index'),
            $model->pemeriksaanrad_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pemeriksaaan Radiologi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAPemeriksaanRadM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAPemeriksaanRadM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAPemeriksaanRadM', 'icon'=>'pencil','url'=>array('update','id'=>$model->pemeriksaanrad_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAPemeriksaanRadM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pemeriksaanrad_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemeriksaaan Radiologi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'pemeriksaanrad_id',
                    'daftartindakan_id',
                    'pemeriksaanrad_jenis',
                    'pemeriksaanrad_nama',
                    'pemeriksaanrad_namalainnya',
                    'pemeriksaanrad_aktif',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->pemeriksaanrad_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
    <?php 
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pemeriksaan Radiologi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $this->widget('UserTips',array('type'=>'view'));
    ?>
</div>