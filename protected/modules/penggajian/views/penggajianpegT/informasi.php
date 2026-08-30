<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Gaji',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#jenisasal').html($('#GJPenggajianpegT_kategoripegawaiasal').val());
	$.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$dataMengetahui = 0;
$dataMengetahuipt = 0;
$dataMenyetujui = 0;
$prov = $model->search();
foreach ($prov->data as $i => $itemd) {
    if (empty($itemd->tgl_mengetahui)) {
        $dataMengetahui += 1;
    }
    if (empty($itemd->tgl_mengetahuipt)) {
        $dataMengetahuipt += 1;
    }
    if (empty($itemd->tgl_menyetujui)) {
        $dataMenyetujui += 1;
    }
}
$asal = $this->kategoripegawaiasal;
$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan Gaji <?php echo $this->kategoripegawaiasal ?> <span id="jenisasal"></span></b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Gaji <?php echo $this->kategoripegawaiasal ?> </b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gjpenggajianpeg-t-grid',
                    'dataProvider' => $model->search(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'Periode',
                            'name' => 'periodegaji',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->periodegaji)) return MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->periodegaji)));
                                return MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->tglpenggajian)));
                            },
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Tgl. Pengajuan/<br>No. Pengajuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($data->tglpenggajian) . '/<br>' . $data->nopenggajian . '</u>', Yii::app()->createUrl("penggajian/PenggajianpegT/detailPenggajian", array("id"  => $data->penggajianpeg_id)), array("rel" => "tooltip", "title" => "Klik untuk Detail Penggajian"));
                            } //'MyFormatter::formatDateTimeForUser($data->tglpenggajian)',
                        ),
                        array(
                            'header' => 'Formulir 1721-A1',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->createUrl('/kepegawaian/pengajuanGajiKP/formulir', array(
                                    'penggajianpeg_id' => $data->penggajianpeg_id,
                                )), array(
                                    'target' => 'framePPH',
                                    'onclick' => "$('#dialogPPH').dialog('open');"
                                ));
                            }
                        ),
                        array(
                            'header' => 'Kelompok Pegawai',
                            'value' => '(isset($data->pegawai->kelompokpegawai->kelompokpegawai_nama) ? $data->pegawai->kelompokpegawai->kelompokpegawai_nama : "-")',
                        ),
                        array(
                            'header' => 'Jabatan',
                            'value' => '(isset($data->pegawai->jabatan->jabatan_nama) ? $data->pegawai->jabatan->jabatan_nama : "-")',
                        ),
                        array(
                            'header' => 'NIP',
                            'name' => 'nomorindukpegawai',
                            'value' => '$data->pegawai->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->pegawai->nama_pegawai',
                        ),
                        array(
                            'header' => 'Kategori Pegawai Asal',
                            //										'name'=>'kategoripegawaiasal',
                            'value' => '$data->pegawai->kategoripegawaiasal',
                        ),
                        array(
                            'header' => 'Pegawai RS Mengetahui <br>' . (($dataMengetahui > 0) ? CHtml::link('<icon class="icon-form-kontrakkarya"></icon>', "", array('id' => 'approveId', "onclick" => "approveAllHeader('mengetahuirs');", "rel" => "tooltip", "title" => "Klik untuk Approve mengetahui ALL", "target" => "frameMenyetujuiAll")) : ""),
                            'filter' => false,
                            'type' => 'raw',
                            'value' => '(isset($data->mengetahui)? $data->mengetahui : "-").
                                                (isset($data->tgl_mengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahui) : 
                                                (CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui", array("penggajianpeg_id"=>$data->penggajianpeg_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                                )',
                        ),
                        array(
                            'header' => 'Pegawai PT Mengetahui <br>' . (($dataMengetahui == 0) ? (($dataMengetahuipt > 0) ? CHtml::link('<icon class="icon-form-kontrakkarya"></icon>', "javascript:approveAllHeader('mengetahuipt')", array('id' => 'approveId', "onclick" => "approveAllHeader('mengetahuipt');", "rel" => "tooltip", "title" => "Klik untuk Approve Mengetahui PT ALL")) : "") : ""),
                            //                                                'header'=>'Pegawai PT Mengetahui',
                            'filter' => false,
                            'type' => 'raw',
                            'value' => '(isset($data->mengetahuipt)? $data->mengetahuipt : "-").
                                                (isset($data->tgl_mengetahuipt) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahuipt) : 
                                                (!isset($data->tgl_mengetahui) ? "" : CHtml::link("<icon class=\'icon-form-kontrakkarya\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahuiPT", array("penggajianpeg_id"=>$data->penggajianpeg_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                                )',
                        ),
                        array(
                            'header' => 'Pegawai Menyetujui <br>' . (($dataMengetahui == 0 && $dataMengetahuipt == 0) ? (($dataMenyetujui > 0) ? CHtml::link('<icon class="icon-form-kontrakkarya"></icon>', "javascript:approveAllHeader('menyetujui')", array('id' => 'approveId', "onclick" => "approveAllHeader('menyetujui');", "rel" => "tooltip", "title" => "Klik untuk Approve Menyetujui ALL", "target" => "frameMenyetujuiAll")) : "") : ""),
                            //                                                'header'=>'Pegawai Menyetujui',
                            'filter' => false,
                            'type' => 'raw',
                            'value' => '(isset($data->menyetujui)? $data->menyetujui : "-").
                                                (isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) :
                                                (isset($data->tgl_mengetahuipt) ? CHtml::link("<icon class=\'icon-form-kontrakkarya\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui", array("penggajianpeg_id"=>$data->penggajianpeg_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : "")
                                                )',
                        ),
                        //  array(
                        //     'header'=>'No. Rekening',
                        //     'value'=>'$data->pegawai->norekening',
                        // ),
                        'keterangan',
                        array(
                            'header' => 'Kirim Email ' . CHtml::link('<i class="icon-kirimdok"></i>', 'javascript:kirimSemua()', array(
                                'onclick' => 'kirimSemua(); return false;',
                                'rel' => 'tooltip',
                                'title' => 'Kirim slip gaji ke semua pegawai pencarian'
                            )),
                            'filter' => false,
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->pengeluaranumum_id)) {
                                    return "";
                                }
                                return CHtml::link('<i class="icon-kirimdok"></i>', '#', array(
                                    'onclick' => 'kirimEmail(' . $data->penggajianpeg_id . '); return false',
                                    'rel' => 'tooltip',
                                    'title' => 'Kirim email slip gaji.'
                                ));
                            },
                            'headerHtmlOptions' => array(
                                'style' => 'text-align: center;'
                            ),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            )
                        ),
                        array(
                            'header' => 'Kirim Notifikasi WhatsApp',
                            'filter' => false,
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->pengeluaranumum_id)) {
                                    return "";
                                }
                                return CHtml::link('<i class="icon-idokrekm"></i>', '#', array(
                                    'onclick' => 'kirimWA(' . $data->penggajianpeg_id . '); return false',
                                    'rel' => 'tooltip',
                                    'title' => 'Kirim email slip gaji.'
                                ));
                            },
                            'headerHtmlOptions' => array(
                                'style' => 'text-align: center;'
                            ),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            )
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $col = 'red';
                                $txt = 'BELUM DIBAYAR';
                                if (!empty($data->pengeluaranumum_id)) {
                                    $col = 'green';
                                    $txt = 'SUDAH DIBAYAR';
                                }
                                return CHtml::button($txt, array('class' => 'btn btn-' . $col, 'style' => 'width:150px;'));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            )
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalpengajuangaji($data->penggajianpeg_id)", array("id" => "$data->penggajianpeg_id", "rel" => "tooltip", "title" => "Klik untuk membatalkan pengajuan gaji", "data-placement" => "left"));
                                //                                            return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;",array("id"=>$data->penggajianpeg_id,"rel"=>"tooltip","title"=>"Klik untuk membatalkan pengajuan gaji", 'data-placement'=>'left', 'onclick'=>'myAlert("Apakah Anda Akan Membatalkan Pengajuan Gaji'.$data->nopenggajian.' ","Perhatian")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPH',
    'options' => array(
        'title' => 'Formulir Pajak PPh',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='framePPH' style="overflow:auto; width:100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMengetahui' style="overflow:auto; width:100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="overflow:auto; width:100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--Dialog untuk menyetujui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahuiAll',
    'options' => array(
        'title' => 'Approvement Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<!--<iframe name='frameMenyetujuiAll' width="100%" height="100%">-->
<div id="frameMenyetujuiAll" style="overflow: auto; width: 100%; height: 98%;"></div>
<!--</iframe>-->
<?php $this->endWidget(); ?>
<script>
    function batalpengajuangaji(pengajuangaji_id) {
        myConfirm("Anda yakin akan membatalkan pengajuan gaji ini?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPengajuanGaji'); ?>',
                    data: {
                        pengajuangaji_id: pengajuangaji_id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        if (data.status == true) {
                            myAlert(data.pesan);
                            $.fn.yiiGridView.update('gjpenggajianpeg-t-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            myAlert(data.pesan);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    function approveAllHeader($type) {
        $('#type_approve').val($type);
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveAll'); ?>',
            data: $('#gjpenggajianpeg-t-search').serialize(),
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $('#dialogMengetahuiAll').find('#frameMenyetujuiAll').html("");
                    $('#dialogMengetahuiAll').find('#frameMenyetujuiAll').html(data.form);
                    $('#dialogMengetahuiAll').dialog('open');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function kirimEmail(id) {
        myConfirm("Anda yakin untuk kirim slip gaji ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('kirimEmail'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert("Slip gaji berhasil dikirim.");
                    } else {
                        myAlert("Slip gaji gagal dikirim.<br>" + data.msg);
                    }
                }, 'json');
            }
            $("#gjpenggajianpeg-t-grid").removeClass('animation-loading');
        });
        return false;
    }

    function kirimWA(id) {
        myConfirm("Anda yakin untuk kirim slip gaji ini via WhatsApp ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('kirimWA'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert("Slip gaji berhasil dikirim.");
                    } else {
                        myAlert("Slip gaji gagal dikirim.<br>" + data.msg);
                    }
                }, 'json');
            }
            $("#gjpenggajianpeg-t-grid").removeClass('animation-loading');
        });
        return false;
    }

    function kirimSemua() {
        myConfirm("Anda yakin untuk kirim slip gaji ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('kirimSemuaEmail'); ?>', $("#gjpenggajianpeg-t-search").serialize(), function(data) {
                    myAlert(data.msg);
                }, 'json');
            }
            $("#gjpenggajianpeg-t-grid").removeClass('animation-loading');
        });
        return false;
    }
</script>