<div class='white-container'>
    <legend class='rim2'>Lihat <b>Barang</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sabarang Ms' => array('index'),
        $model->barang_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Barang', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUBarangM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUBarangM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' GUBarangM', 'icon'=>'pencil','url'=>array('update','id'=>$model->barang_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' GUBarangM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->barang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Barang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'barang_id',
            'bidang_id',
            'barang_type',
            'barang_kode',
            'barang_nama',
            'barang_namalainnya',
            'barang_merk',
            'barang_noseri',
            'barang_ukuran',
            'barang_bahan',
            'barang_thnbeli',
            'barang_warna',
            'barang_statusregister',
            'barang_ekonomis_thn',
            'barang_satuan',
            'barang_jmldlmkemasan',
            'barang_image',
            'barang_aktif',
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/gudangUmum/BarangM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>