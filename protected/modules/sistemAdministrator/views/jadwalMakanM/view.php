<div class="white-container">
    <legend class="rim2">Lihat <b>Jadwal Makan</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sajadwalmakan Ms' => array('index'),
        $model->jadwalmakan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jadwal Makan '.$model->jadwalmakan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jadwal Makan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Makanan', 'icon'=>'pencil','url'=>array('update','id'=>$model->bahanmakanan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Bahan Makanan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bahanmakanan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jadwal Makan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'jadwalmakan_id',
            'jeniswaktu.jeniswaktu_nama',
            'jenisdiet.jenisdiet_nama',
            'tipediet.tipediet_nama',
            'menudiet.menudiet_nama',
        ),
    )); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jadwal Makan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jadwalMakanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>