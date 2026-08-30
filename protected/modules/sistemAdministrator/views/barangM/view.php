<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Barang</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Barang' => array('admin'),
            $model->barang_id,
        );

        $arrMenu = array();
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
                array(
                    'label' => 'Harga Netto (Rp)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'value' => number_format($model->barang_harganetto, 0, "", ".")
                ),
                'barang_jmldlmkemasan',
                array(
                    'label' => 'Gambar',
                    'type' => 'raw',
                    'value' => CHtml::image(Params::urlBarangDirectory() . "tumbs/kecil_" . $model->barang_image, '', array('width' => 200))
                ), //<img src='".Params::urlBarangDirectory()."tumbs/kecil_".$model->barang_image."/>
                //'barang_image',
                'barang_aktif',
                'barang_keterangan',
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('/gudangUmum/BarangMGU', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>