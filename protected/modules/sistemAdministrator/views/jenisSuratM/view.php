<div class="white-container">
    <legend class="rim2">Lihat <b>Jenis Surat</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Jenis Surat Ms' => array('index'),
        $model->jenissurat_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Surat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Surat', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Surat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Surat', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->jenissurat_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Surat', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    ?>

    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'jenissurat_id',
            'jenissurat_nama',
            'jenissurat_namalain',
            'jenissurat_aktif',
        ),
    )); ?>
    <br>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Surat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jenisSuratM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
</div>