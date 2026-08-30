<?php $linkHalaman = CustomFunction::getUrlByMenuID(2602); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Pulang',
);
?>
<!--<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Pulang</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Pulang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasienPulang-form').submit(function(){
            $('#daftarPasienPulang-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasienPulang-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php echo $this->renderPartial('_formPencarian', array('modPasienYangPulang' => $modPasienYangPulang)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Pulang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasienPulang-grid',
                    'dataProvider' => $modPasienYangPulang->searchPI(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        //                'tglpasienpulang',
                        array(
                            'header' => 'Tanggal Pasien Pulang',
                            'value' => '$data->tglpasienpulang',
                        ),
                        array(
                            'header' => 'Cara/<br>Kondisi Pulang',
                            'type' => 'raw',
                            'value' => '$data->CaradanKondisiPulang'
                        ),
                        array(
                            'header' => 'Lama Dirawat/<br>Nama Kamar',
                            'value' => '$data->lamadirawat_kamar',
                        ),
                        //                'lamadirawat_kamar',
                        array(
                            'header' => 'Tanggal Admisi',
                            'value' => '$data->tgladmisi',
                        ),
                        //                'tgladmisi',
                        array(
                            'header' => 'No. Rekam Medik/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->NoRMdanNoPendaftaran'
                        ),
                        array(
                            'header' => 'Nama/<br>Alias',
                            'type' => 'raw',
                            'value' => '$data->NamadanNamaBIN'
                        ),
                        //                'umur',
                        //                 array(
                        //                       'header'=>'Jenis Penjamin / Penjamin',
                        //                        'type'=>'raw',
                        //                        'value'=>'$data->CaraBayardanPenjamin'
                        //                    ),
                        array(
                            'header' => 'Kelas Pelayanan/<br>No. Masuk Kamar',
                            'type' => 'raw',
                            'value' => '$data->KelasPelayanandanNoMasukKamar'
                        ),
                        array(
                            'header' => 'Nama Jenis Kasus Penyakit',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        //                'jeniskasuspenyakit_nama',
                        //                array(
                        //                       'header'=>'Batal Pulang',
                        //                       'type'=>'raw',
                        //                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ","javascript:cekHakAkses($data->pasienpulang_id,$data->pasienadmisi_id,$data->pasien_id,$data->pendaftaran_id)" ,array("title"=>"Klik untuk Membatalkan Kepulangan"))',
                        //                    ),
                        array(
                            'header' => 'Batal Pulang',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i>", 
                                       Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/batalPulang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                           array("title"=>"Klik untuk Batal Pulang", "target"=>"iframeBatalPulang", "onclick"=>"$(\"#dialogBatalPulang\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ), /*
                        array(
                            'header' => 'Rincian Tagihan',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/rincianTagihanPasienDetail", array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)), array("rel"=>"tooltip","title"=>"Lihat Rincian Tagihan Pasien Pulang","target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ), */
                        array(
                            'header' => 'Rincian Sudah Bayar',
                            'type' => 'raw',
                            'value' => '(!empty($data->IDpembayaranpelayanan($data->pendaftaran_id)) ? CHtml::Link("<i class=\"icon-form-rincianrs\"></i>",Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("pendaftaran_id"=>$data->pendaftaran_id, "instalasi_id"=>4, "frame"=>true)),
                                        array("class"=>"", 
                                              "target"=>"iframeRincianTagihan",
                                              "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat Rincian Tagihan",
                                        )) : "Belum Bayar")',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                echo CHtml::hiddenField('pasien_id', '', array('readonly' => TRUE));
                echo CHtml::hiddenField('pendaftaran_id', '', array('readonly' => TRUE));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk batal Rawat Intensif =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalPulang',
    'options' => array(
        'title' => 'Pembatalan Pulang Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeBatalPulang" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>