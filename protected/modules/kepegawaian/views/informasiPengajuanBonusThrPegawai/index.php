<?php $linkHalaman = CustomFunction::getUrlByMenuID(3518); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Bonus/THR Pegawai',
);
Yii::app()->clientScript->registerScript('search', "
$('#pengajuanbonusthr-t-search').submit(function(){
    if(requiredCheckInformasi(this)){
	$.fn.yiiGridView.update('pengajuanbonusthr-t-grid', {
		data: $(this).serialize()
    });
    }
	return false;
});
");
$dataMengetahui = 0;
$dataMengetahuipt = 0;
$dataMenyetujui = 0;
$prov = $model->searchInformasi();
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
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan THR dan Bonus Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan THR dan Bonus Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pengajuanbonusthr-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'type' => 'raw',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'No. Pengajuan / Tgl. Pengajuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->nopengajuan . '/' . MyFormatter::formatDateTimeForUser($data->tglpengajuan);
                            }
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Status Pegawai',
                            'type' => 'raw',
                            'value' => '$data->statuspegawai',
                        ),
                        array(
                            'header' => 'Tanggal Masuk',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglditerima)',
                        ),
                        array(
                            'header' => 'Jenis Transaksi',
                            'type' => 'raw',
                            'value' => '$data->jenisgajipegawai',
                        ),
                        array(
                            'header' => 'Mengetahui (RS) <br>' . (($dataMengetahui > 0) ? CHtml::link('<icon class="icon-form-check"></icon>', "", array('id' => 'approveId', "onclick" => "approveAllHeader('mengetahuirs');", "rel" => "tooltip", "title" => "Klik untuk Approve mengetahui ALL", "target" => "frameApproveAll")) : ""),
                            'filter' => false,
                            'type' => 'raw',
                            'value' => '(isset($data->pegawai_mengetahuirs)? $data->pegawai_mengetahuirs : "-").
                                             (isset($data->tgl_mengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahui) :
                                             (CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui", array("pengbonusthr_id"=>$data->pengbonusthr_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                             )',
                        ),
                        array(
                            'header' => 'Mengetahui (PT) <br>' . (($dataMengetahui == 0) ? (($dataMengetahuipt > 0) ? CHtml::link('<icon class="icon-form-check"></icon>', "javascript:approveAllHeader('mengetahuipt')", array('id' => 'approveId', "onclick" => "approveAllHeader('mengetahuipt');", "rel" => "tooltip", "title" => "Klik untuk Approve Mengetahui PT ALL")) : "") : ""),
                            'filter' => false,
                            'type' => 'raw',
                            'value' => '(isset($data->pegawai_mengetahuipt)? $data->pegawai_mengetahuipt : "-").
                                             (isset($data->tgl_mengetahuipt) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_mengetahuipt) :
                                             (!isset($data->tgl_mengetahui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahuiPT", array("pengbonusthr_id"=>$data->pengbonusthr_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
                                             )',
                        ),
                        array(
                            'header' => 'Menyetujui <br>' . (($dataMengetahui == 0 && $dataMengetahuipt == 0) ? (($dataMenyetujui > 0) ? CHtml::link('<icon class="icon-form-check"></icon>', "javascript:approveAllHeader('menyetujui')", array('id' => 'approveId', "onclick" => "approveAllHeader('menyetujui');", "rel" => "tooltip", "title" => "Klik untuk Approve Menyetujui ALL", "target" => "frameMenyetujuiAll")) : "") : ""),
                            'filter' => false,
                            'type' => 'raw',
                            'value' => '(isset($data->pegawai_menyetujui)? $data->pegawai_menyetujui : "-").
                                             (isset($data->tgl_menyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tgl_menyetujui) :
                                             (isset($data->tgl_mengetahuipt) ? CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui", array("pengbonusthr_id"=>$data->pengbonusthr_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');")) : "")
                                             )',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keteranganpengajuan',
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",Yii::app()->createUrl("kepegawaian/InformasiPengajuanBonusThrPegawai/rincian",array("pengbonusthrdetail_id"=>$data->pengbonusthrdetail_id,"pengbonusthr_id"=>$data->pengbonusthr_id)) ,array("title"=>"Klik untuk Melihat Slip Pembayaran ".$data->jenisgajipegawai,"target"=>"iframe", "onclick"=>"setDialogPengajuan(\'".$data->jenisgajipegawai."\')", "rel"=>"tooltip"))',
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '"Belum Bayar"',
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalpengajuan(" . $data->pengbonusthrdetail_id . "," . $data->pengbonusthr_id . ")", array("id" => "$data->pengbonusthr_id", "rel" => "tooltip", "title" => "Klik untuk membatalkan pengajuan Bonus/THR Pegawai", "data-placement" => "left"));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Slip Pembayaran <span class="detailpengajuan"></span>',
        'autoOpen' => false,
        'minWidth' => 1100,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--Dialog untuk mengetahui-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('pengajuanbonusthr-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMengetahui' style="width: 100%; height: 98%;"></iframe>
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
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('pengajuanbonusthr-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameMenyetujui' style="width: 100%; height: 98%;"></iframe>
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
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('pengajuanbonusthr-t-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<!--<iframe name='frameApproveAll' width="100%" height="100%">-->
<div id="frameApproveAll"></div>
<!--</iframe>-->
<?php $this->endWidget(); ?>
<script style="text/javascript">
    function setDialogPengajuan(value) {
        $('.detailpengajuan').html(value);
        $('#dialogRincian').dialog('open');
    }

    function batalpengajuan(pengbonusthrdetail_id, pengbonusthr_id) {
        myConfirm("Anda yakin akan membatalkan Pengajuan Bonus/THR Pegawai ini?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPengajuan'); ?>',
                    data: {
                        pengbonusthrdetail_id: pengbonusthrdetail_id,
                        pengbonusthr_id: pengbonusthr_id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        if (data != null) {
                            myAlert(data.pesan);
                            if (data.status == true) {
                                $.fn.yiiGridView.update('pengajuanbonusthr-t-grid', {
                                    data: $(this).serialize()
                                });
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
    //
    function approveAllHeader($type) {
        $('#type_approve').val($type);
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveAll'); ?>',
            data: $('#pengajuanbonusthr-t-search').serialize(),
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $('#dialogMengetahuiAll').find('#frameApproveAll').html("");
                    $('#dialogMengetahuiAll').find('#frameApproveAll').html(data.form);
                    $('#dialogMengetahuiAll').dialog('open');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    //
    //
    //function kirimEmail(id) {
    //    myConfirm("Anda yakin untuk kirim slip gaji ini?", "Peringatan", function(r) {
    //        if (r) {
    //            $.post('<?php // echo $this->createUrl('kirimEmail'); 
                            ?>', {id: id}, function(data) {
    //                if (data.ok == 1) {
    //                    myAlert("Slip gaji berhasil dikirim.");
    //                } else {
    //                    myAlert("Slip gaji gagal dikirim.<br>"+data.msg);
    //                }
    //            }, 'json');
    //        }
    //        $("#gjpenggajianpeg-t-grid").removeClass('animation-loading');
    //    });
    //    return false;
    //}
    //
    //function kirimSemua() {
    //    myConfirm("Anda yakin untuk kirim slip gaji ini?", "Peringatan", function(r) {
    //        if (r) {
    //            $.post('<?php // echo $this->createUrl('kirimSemuaEmail'); 
                            ?>', $("#gjpenggajianpeg-t-search").serialize(), function(data) {
    //                myAlert(data.msg);
    //            }, 'json');
    //        }
    //        $("#gjpenggajianpeg-t-grid").removeClass('animation-loading');
    //    });
    //    return false;
    //}
</script>