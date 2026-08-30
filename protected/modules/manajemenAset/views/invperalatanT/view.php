<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Aset Peralatan dan Mesin</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Guinvperalatan Ts' => array('index'),
            $model->invperalatan_id,
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Inventarisasi Peralatan dan Mesin', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvperalatanT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvperalatanT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' MAInvperalatanT', 'icon'=>'pencil','url'=>array('update','id'=>$model->invperalatan_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' MAInvperalatanT','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->invperalatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Peralatan dan Mesin', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'invperalatan_id',
                'asal.asalaset_nama',
                'barang.barang_nama',
                array(
                    'label' => 'Gambar Barang',
                    'type' => 'raw',
                    'value' => CHtml::image(Params::urlBarangDirectory() . $model->barang->barang_image, '', array('style' => 'max-height:120px; max-width:120px;')),
                ),
                'lokasi.lokasiaset_namalokasi',
                'pemilik.pemilikbarang_nama',
                'invperalatan_kode',
                'invperalatan_noregister',
                'invperalatan_namabrg',
                'invperalatan_merk',
                'invperalatan_ukuran',
                'invperalatan_bahan',
                'invperalatan_thnpembelian',
                'invperalatan_tglguna',
                'invperalatan_nopabrik',
                'invperalatan_norangka',
                'invperalatan_nomesin',
                'invperalatan_nopolisi',
                'invperalatan_nobpkb',
                'invperalatan_harga',
                'invperalatan_akumsusut',
                'invperalatan_ket',
                'invperalatan_kapasitasrata',
                'invperalatan_ijinoperasional',
                'invperalatan_serftkkalibrasi',
                'invperalatan_umurekonomis',
                'invperalatan_keadaan',
                'create_time',
                'update_time',
                'create_loginpemakai_id',
                'update_loginpemakai_id',
                'create_ruangan',
            ),
        )); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Inventarisasi Peralatan dan Mesin', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('invperalatanT/Admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    </div>
</div>