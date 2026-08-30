<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-eye"></i> Lihat <b>Inventarisasi Tanah</b></div>
    </div>
    <div class="panel-body">

    <?php
    $this->breadcrumbs=array(
            'Guinvtanah Ts'=>array('index'),
            $model->invtanah_id,
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Inventarisasi Tanah', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvtanahT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvtanahT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' MAInvtanahT', 'icon'=>'pencil','url'=>array('update','id'=>$model->invtanah_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' MAInvtanahT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->invtanah_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Tanah', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'invtanah_id',
                'asal.asalaset_nama',
                'barang.barang_nama',
                array(
                    'label' => 'Gambar Barang',
                    'type' => 'raw',
                    'value' => CHtml::image(Params::urlBarangDirectory() . $model->barang->barang_image, '', array('style' => 'max-height:120px; max-width:120px;')),
                ),
                'lokasi.lokasiaset_namalokasi',
                'pemilik.pemilikbarang_nama',
                'invtanah_kode',
                'invtanah_noregister',
                'invtanah_namabrg',
                'invtanah_luas',
                'invtanah_thnpengadaan',
                'invtanah_tglguna',
                'invtanah_alamat',
                'invtanah_status',
                'invtanah_tglsertifikat',
                'invtanah_nosertifikat',
                'invtanah_penggunaan',
                'invtanah_harga',
                'invtanah_ket',
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
            ),
    )); ?>
<div class="form-actions">
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Tanah', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('invtanahT/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
</div>
</div>
</div>