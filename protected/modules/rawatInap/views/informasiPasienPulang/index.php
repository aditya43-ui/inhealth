<?php $linkHalaman = CustomFunction::getUrlByMenuID(270); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Pulang'
);
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_formPencarian', array('modPasienYangPulang' => $modPasienYangPulang)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Pulang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasienPulang-grid',
                    'dataProvider' => $modPasienYangPulang->searchRI(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        //                'tglpasienpulang',
                        array(
                            'header' => 'Tanggal Pulang',
                            'value' => '$data->tglpasienpulang',
                        ),
                        array(
                            'header' => 'Tanggal Masuk/ <br>No Masuk',
                            'type' => 'raw',
                            'value' => '$data->tglmasukkamar."/ <br>".$data->nomasukkamar',
                        ),
                        //                'lamadirawat_kamar',
                        //                'tgladmisi',
                        array(
                            'header' => 'Tanggal Pendaftaran/ <br> No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->tgl_pendaftaran."/ <br>".$data->no_pendaftaran'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->namadepan." ".$data->nama_pasien'
                        ),
                        array(
                            'header' => 'Kamar/ <br> No. Bed',
                            'type' => 'raw',
                            'value' => '$data->kamarruangan_nokamar."/ <br>".$data->kamarruangan_nobed'
                        ),
                        //                'umur',
                        //                 array(
                        //                       'header'=>'Jenis Penjamin / Penjamin',
                        //                        'type'=>'raw',
                        //                        'value'=>'$data->CaraBayardanPenjamin'
                        //                    ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '$data->kelaspelayanan_nama'
                        ),
                        array(
                            'header' => 'Kasus Penyakit',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Dokter Penerima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->dokterpenerima_id)) return "-";
                                $peg = PegawaiM::model()->findByPk($data->dokterpenerima_id);
                                return $peg->namaLengkap;
                            },
                        ),
                        array(
                            'header' => 'Dokter PJP',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $str = '<ul>';
                                if (!empty($data->pegawai_id)) {
                                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                    $str .= '<li>' . $peg->namaLengkap . '</li>';
                                }
                                if (!empty($data->dpjp2_id)) {
                                    $peg = PegawaiM::model()->findByPk($data->dpjp2_id);
                                    $str .= '<li>' . $peg->namaLengkap . '</li>';
                                }
                                if (!empty($data->dpjp3_id)) {
                                    $peg = PegawaiM::model()->findByPk($data->dpjp3_id);
                                    $str .= '<li>' . $peg->namaLengkap . '</li>';
                                }
                                $str .= '</ul>';
                                return $str;
                            },
                        ),
                        array(
                            'header' => 'Lama Dirawat',
                            'type' => 'raw',
                            'value' => '$data->lamadirawat_kamar." Hari"',
                        ),
                        array(
                            'header' => 'Cara/ Kondisi Pulang',
                            'type' => 'raw',
                            'value' => '$data->CaradanKondisiPulang'
                        ),
                        //                'jeniskasuspenyakit_nama',
                        //                array(
                        //                       'header'=>'Batal Pulang',
                        //                       'type'=>'raw',
                        //                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ","javascript:cekHakAkses($data->pasienpulang_id,$data->pasienadmisi_id,$data->pasien_id,$data->pendaftaran_id)" ,array("title"=>"Klik untuk Membatalkan Kepulangan"))',
                        //                    ),
                        /*array(
                                        'header'=>'Rincian',
                                        'type'=>'raw',
                                        'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->createUrl("billingKasir/RinciantagihanpasienV/rincianBelumBayarRI", array("id"=>$data->pendaftaran_id)), array("rel"=>"tooltip","title"=>"Lihat Rincian Pasien Pulang","target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                                        'htmlOptions'=>array('style'=>'text-align:left;'),
                                    ),*/
                        array(
                            'header' => 'Operator',
                            'value' => function ($data) {
                                $l = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                if (!empty($l)) {
                                    if (!empty($data->pegawai_id)) {
                                        return $l->pegawai->namaLengkap;
                                    } else {
                                        return '';
                                    }
                                } else {
                                    return '';
                                }
                            }
                        ),
                        array(
                            'header'=>'Surat Pulang',
                            'type'=>'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-print\"></i>",Yii::app()->controller->createUrl("/rawatInap/pasienRawatInap/printPasienPulang",array("pasienpulang_id"=>$data->pasienpulang_id,"frame"=>true)),
                                array("class"=>"", 
                                    "target"=>"iframeRincianTagihan",
                                    "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Cetak Lembar Surat Pulang",
                                ))',          'htmlOptions' => array('style' => 'text-align: left; width:40px')
                        ),
                        [
                            'header' => 'Riwayat Periksa Pasien',
                            'type' => 'raw',
                            'value' => function($data) {
                                echo  CHtml::link(
                                    '<i class="icon-form-lihat"></i> Lihat Riwayat',
                                    Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id, 'lihat' => 1)),
                                    array(
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat riwayat pasien",
                                        "target" => "blank",
                                    )
                                );
                            }
                        ],
                        array(
                            'header' => 'Batal Pulang',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i>", 
                                         Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/batalPulang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                                         array("title"=>"Klik untuk Batal Pulang", "target"=>"iframeBatalPulang", "onclick"=>"$(\"#dialogBatalPulang\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions' => array('style' => 'text-align:left; width:40px'),
                        ),
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
                <!--/div-->
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk batal Rawat Inap =========================
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
<iframe src="" name="iframeBatalPulang" width="100%" height="550">
</iframe>
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