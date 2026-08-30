<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-eye"></i> Lihat Aset <b>Jalan Irigasi dan Jaringan</b></div>
    </div>
    <div class="panel-body">

    <?php
    $this->breadcrumbs=array(
            'Guinvjalan Ts'=>array('index'),
            $model->invjalan_id,
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Inventarisasi Jalan Irigasi dan Jaringan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvjalanT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvjalanT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' MAInvjalanT', 'icon'=>'pencil','url'=>array('update','id'=>$model->invjalan_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' MAInvjalanT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->invjalan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Jalan Irigasi dan Jaringan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'invjalan_id',
                'asal.asalaset_nama',
                'barang.barang_nama',
                array(
                    'label' => 'Gambar Barang',
                    'type' => 'raw',
                    'value' => CHtml::image(Params::urlBarangDirectory() . $model->barang->barang_image, '', array('style' => 'max-height:120px; max-width:120px;')),
                ),
		'lokasi.lokasiaset_namalokasi',
		'pemilik.pemilikbarang_nama',
		'invjalan_kode',
		'invjalan_noregister',
		'invjalan_namabrg',
		'invjalan_kontruksi',
		'invjalan_panjang',
		'invjalan_lebar',
		'invjalan_luas',
		'invjalan_letak',
		'invjalan_tgldokumen',
		'invjalan_tglguna',
		'invjalan_nodokumen',
		'invjalan_statustanah',
		'invjalan_keadaaan',
		'invjalan_harga',
		'invjalan_akumsusut',
		'invjalan_ket',
		'craete_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
	),
    )); ?>
        <div class="form-actions">
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Jalan Irigasi dan Jaringan ', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('invjalanT/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
        </div>
</div>
</div>