<?php $linkHalaman = CustomFunction::getUrlByMenuID(2748); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Jasa Dokter',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$pilihJasa = Params::getJenisJasa();
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan Jasa Dokter</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Jasa Dokter</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gjpembayaranjasa-t-grid',
                    'dataProvider' => $model->searchInformasiBaru(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Pengajuan/<br>No. Pengajuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::Link(
                                    "<u>" . MyFormatter::formatDateTimeForUser($data->tglbayarjasa) . '/<br>' . $data->nobayarjasa . "</u>",
                                    Yii::app()->controller->createUrl(Yii::app()->controller->id . "/lihatDetail", array("id" => $data->pembayaranjasa_id)),
                                    array(
                                        "class" => "",
                                        "target" => "iframeDetail",
                                        "onclick" => "$('#dialogDetail').dialog('open');",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk Melihat Rincian Pengajuan Jasa",
                                    )
                                );
                            }
                        ),
                        array(
                            'header' => 'Periode Jasa/<br>Sampai Dengan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->periodejasa) . '/<br>' . MyFormatter::formatDateTimeForUser($data->sampaidgn);
                            }
                        ),
                        array(
                            'header' => 'Jenis Jasa',
                            'type' => 'raw',
                            'value' => function ($data) use (&$pilihJasa) {
                                return (isset($pilihJasa[$data->pilihjasa]) ? $pilihJasa[$data->pilihjasa] : '');
                            }
                        ),
                        array(
                            'header' => 'Kelompok Pegawai',
                            'type' => 'raw',
                            'value' => function ($data) use (&$pilihJasa) {
                                return $data->kelompokpegawai_nama;
                            }
                        ),
                        array(
                            'header' => 'Jabatan',
                            'type' => 'raw',
                            'value' => function ($data) use (&$pilihJasa) {
                                return $data->jabatan_nama;
                            }
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->nama_pegawai;
                            }
                        ),
                        array(
                            'header' => 'Jenis Bukti Potong',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                return $peg->jenisBuktiPotong;
                            }
                        ),
                        array(
                            'header' => 'Kode Objek Pajak',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->kode_objekpajak;
                            }
                        ),
                        array(
                            'name' => 'totaljasa',
                            'header' => 'Total Jasa<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->totaljasa,2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Total Adjusment Fee<br>(Rp)',
                            'type' => 'raw',
                            'value' => '(!empty($data->totaladjsument)? MyFormatter::formatNumberForPrint($data->totaladjsument,2): "0")',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Total Pajak Progressif<br>(Rp)',
                            'type' => 'raw',
                            'value' => function ($data) use (&$pilihJasa) {
                                $modData = PajakdokterT::model()->findByPk($data->pajakdokter_id);
                                $pajakProg = 0;
                                if (isset($modData)) {
                                    $pajakProg = $modData->pajakprogressif;
                                }
                                return MyFormatter::formatNumberForPrint($pajakProg, 2);
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'name' => 'totalbayarjasa',
                            'header' => 'Total Pengajuan<br>(Rp)',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->total_terima, 2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            )
                        ),
                        array(
                            'header' => 'Petugas yang Mengajukan',
                            'value' => function ($data) {
                                $l = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                if (empty($l->pegawai_id)) {
                                    return $l->nama_pemakai;
                                } else {
                                    return $l->pegawai->namaLengkap;
                                }
                            }
                        ),
                        array(
                            'header' => 'Direktur RS Mengetahui',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (isset($data->mengetahui_id) ? $data->mengetahuis->namaLengkap : "-") . ' yang bisa mengakses");';
                                if ($data->mengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMengetahui').dialog('open');";
                                }
                                $html = (isset($data->mengetahui_id) ? $data->mengetahuis->namaLengkap : "-") . (isset($data->tgl_mengetahui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_mengetahui) : (isset($data->mengetahui_id) ? CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Mengetahui', array("pembayaranjasa_id" => $data->pembayaranjasa_id, "frame" => true)), array("target" => "frameMengetahui", "rel" => "tooltip", "title" => "Klik untuk Approve Direktur RS", "onclick" => $dataDialog)) : ""));
                                return $html;
                            },
                        ),
                        //                                    array(
                        //                                        'header' => 'Pegawai PT Mengetahui',
                        //                                        'type' => 'raw',
                        //                                        'value' => function($data) {
                        //                                            $dataDialog = 'myAlert("Hanya ' . (isset($data->mengetahui_pt_id) ? $data->mengetahuipt->namaLengkap : "-") . ' yang bisa mengakses");';
                        //                                            if ($data->mengetahui_pt_id == Yii::app()->user->getState('pegawai_id')) {
                        //                                                $dataDialog = "$('#dialogMengetahuipt').dialog('open');";
                        //                                            }
                        //                                            $html = (isset($data->mengetahui_pt_id) ? $data->mengetahuipt->namaLengkap : "-") . (isset($data->tgl_mengetahuipt) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_mengetahuipt) : (!isset($data->mengetahui_pt_id) ? "" : ((empty($data->tgl_mengetahui)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/MengetahuiPT', array("pembayaranjasa_id" => $data->pembayaranjasa_id, "frame" => true)), array("target" => "frameMengetahuiPt", "rel" => "tooltip", "title" => "Klik untuk Approve Pegawai PT", "onclick" => $dataDialog)))));
                        //                                            return $html;
                        //                                        },
                        //                                    ),
                        array(
                            'header' => 'Direktur PT Menyetujui',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (isset($data->menyetujui_id) ? $data->menyetujuis->namaLengkap : "-") . ' yang bisa mengakses");';
                                if ($data->menyetujui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                }
                                $check = "";
                                if (!empty($data->tgl_mengetahui)) {
                                    $check = "kosong";
                                }
                                $html = (isset($data->menyetujui_id) ? $data->menyetujuis->namaLengkap : "-") . (isset($data->tgl_menyetujui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) : (!isset($data->menyetujui_id) ? "" : ((empty($check)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Menyetujui', array("pembayaranjasa_id" => $data->pembayaranjasa_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Direktur PT", "onclick" => $dataDialog)))));
                                return $html;
                            },
                        ),
                        array(
                            'header' => 'Status Pengajuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->penggajianpeg_id)) {
                                    return Params::getWrStatusPengajuanGaji('SUDAH');
                                } else {
                                    $cek = PengajuanjasapenggajianMetaV::model()->findByAttributes(array('pembayaranjasa_id' => $data->pembayaranjasa_id, 'pegawai_id' => $data->pegawai_id));
                                    if (!empty($cek->is_penggajian) == true) {
                                        return Params::getWrStatusPengajuanGaji('SUDAH');
                                    } else {
                                        return Params::getWrStatusPengajuanGaji('BELUM');
                                    }
                                }
                            }
                        ),
                        array(
                            'header' => 'Pembayaran Jasa Medis',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->penggajianpeg_id)) {
                                    return CHtml::Link("<i class='icon-form-bayar'></i>", $this->createUrl("/Penggajian/PembayaranJasa/Index") . '&pembayaranjasa_id=' . $data->pembayaranjasa_id, array("class" => "", "rel" => "tooltip", "title" => "Klik Melakukan Ke Pembayaran Jasa Medis",));
                                } else {
                                    $cek = PengajuanjasapenggajianMetaV::model()->findByAttributes(array('pembayaranjasa_id' => $data->pembayaranjasa_id, 'pegawai_id' => $data->pegawai_id));
                                    if (!empty($cek->is_penggajian) == true) {
                                        return CHtml::Link("<i class='icon-form-bayar'></i>", $this->createUrl("/Penggajian/PembayaranJasa/Index") . '&pembayaranjasa_id=' . $data->pembayaranjasa_id, array("class" => "", "rel" => "tooltip", "title" => "Klik Melakukan Ke Pembayaran Jasa Medis",));
                                    } else {
                                        return "Status Pengajuan Belum";
                                    }
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Slip Jasa Dokter',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="entypo-print" style="font-size:14pt"></i>', 'javascript:void(0)', array('onclick' => 'printSlip(' . $data->pembayaranjasa_id . ',"PRINT")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Formulir 1721-VI',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/formulir", array(
                                    'pembayaranjasa_id' => $data->pembayaranjasa_id,
                                )), array(
                                    'target' => 'frameFormulirPPh',
                                    'onclick' => "$('#dialogPPH').dialog('open');"
                                ));
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Pengajuan Jasa',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="550"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Direktur RS Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 920,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk mengetahui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahuipt',
    'options' => array(
        'title' => 'Approvement Pegawai PT Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 920,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMengetahuiPt' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Direktur RS Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 920,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPH',
    'options' => array(
        'title' => 'Formulir 1721 - VI',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        //			'close'=>"js:function(){ $.fn.yiiGridView.update('gjpembayaranjasa-t-grid', {
        //					data: $(this).serialize()
        //				}); }",
    ),
));
?>
<iframe name='frameFormulirPPh' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<script type='text/javascript'>
    function printSlip(pembayaranjasa_id, caraPrint) {
        window.open('<?php echo $this->createUrl('PrintSlipDokter'); ?>&pembayaranjasa_id=' + pembayaranjasa_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
</script>