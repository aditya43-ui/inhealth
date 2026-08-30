<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-eye"></i> Lihat Aset <b>Gedung dan Bangunan</b></div>
    </div>
    <div class="panel-body">

    <?php
    $this->breadcrumbs=array(
            'Guinvgedung Ts'=>array('index'),
            $model->invgedung_id,
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Inventarisasi Gedung dan Bangunan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvgedungT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvgedungT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' MAInvgedungT', 'icon'=>'pencil','url'=>array('update','id'=>$model->invgedung_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' MAInvgedungT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->invgedung_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Gedung dan Bangunan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'invgedung_id',
                'asalaset.asalaset_nama',
                'barang.barang_nama',
                array(
                    'label' => 'Gambar Barang',
                    'type' => 'raw',
                    'value' => CHtml::image(Params::urlBarangDirectory() . $model->barang->barang_image, '', array('style' => 'max-height:120px; max-width:120px;')),
                ),
                'lokasi.lokasiaset_namalokasi',
                'pemilikbarang.pemilikbarang_nama',
                'invgedung_kode',
                'invgedung_noregister',
                'invgedung_namabrg',
                'invgedung_kontruksi',
                'invgedung_luaslantai',
                'invgedung_alamat',
                'invgedung_tgldokumen',
                'invgedung_tglguna',
                'invgedung_nodokumen',
                'invgedung_harga',
                'invgedung_akumsusut',
                'invgedung_ket',
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
            ),
        )); ?>

    <div class="form-actions">
        <?php $this->widget('UserTips',array('type'=>'view'));?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Gedung dan Bangunan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    </div>
</div>
</div>