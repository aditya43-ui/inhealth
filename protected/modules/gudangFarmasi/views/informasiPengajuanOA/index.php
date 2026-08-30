<?php $linkHalaman = CustomFunction::getUrlByMenuID(3537); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Perubahan Harga Obat dan Alkes',
);
Yii::app()->clientScript->registerScript('search', "
$('#informasipengajuanoa-t-search').submit(function(){
	$.fn.yiiGridView.update('informasipengajuanoa-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengajuan Perubahan Harga Obat dan Alkes</b>
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
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Perubahan Harga Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'informasipengajuanoa-v-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Pegawai yang Mengajukan',
                            'start' => 3,
                            'end' => 3,
                        ),
                        array(
                            'name' => 'Pegawai Mengetahui',
                            'start' => 4,
                            'end' => 4,
                        ),
                        array(
                            'name' => 'Pegawai Menyetujui',
                            'start' => 5,
                            'end' => 5,
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pengajuan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengajuanhargaoa)',
                        ),
                        array(
                            'header' => 'No. Pengajuan',
                            'type' => 'raw',
                            'value' => '$data->nopengajuanhargaoa',
                        ),
                        array(
                            'header' => 'Keterangan Pengajuan',
                            'type' => 'raw',
                            'value' => '$data->ketpengajuan',
                        ),
                        array(
                            'header' => 'Kepala Instalasi Farmasi',
                            'type' => 'raw',
                            'value' => '$data->pegawai->namaLengkap',
                        ),
                        array(
                            'header' => 'Manager Keuangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (isset($data->pegawaimengetahui_id) ? $data->pegawaimengetahui->namaLengkap : "-") . ' yang bisa mengakses");';
                                if ($data->pegawaimengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMengetahui').dialog('open');";
                                }
                                $html = (isset($data->pegawaimengetahui_id) ? $data->pegawaimengetahui->namaLengkap : "-") . (isset($data->tglmengetahui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tglmengetahui) : (isset($data->pegawaimengetahui_id) ? CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMengetahui', array("pengajuanhargaoa_id" => $data->pengajuanhargaoa_id, "frame" => true)), array("target" => "frameMengetahui", "rel" => "tooltip", "title" => "Klik untuk Approve Manager Keuangan", "onclick" => $dataDialog)) : ""));
                                return $html;
                            },
                        ),
                        array(
                            'header' => 'Direktur',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (isset($data->pegawaimenyetujui_id) ? $data->pegawaimenyetujui->namaLengkap : "-") . ' yang bisa mengakses");';
                                if ($data->pegawaimenyetujui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                }
                                $html = (isset($data->pegawaimenyetujui_id) ? $data->pegawaimenyetujui->namaLengkap : "-") . (isset($data->tglmenyetujui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : (!isset($data->pegawaimenyetujui_id) ? "" : ((empty($data->tglmengetahui)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ApproveMenyetujui', array("pengajuanhargaoa_id" => $data->pengajuanhargaoa_id, "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik untuk Approve Direktur", "onclick" => $dataDialog)))));
                                return $html;
                            },
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '(!empty($data->statuspengajuan)?$data->statuspengajuan:"BELUM DISETUJUI")',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Rincian", array("pengajuanhargaoa_id"=>$data->pengajuanhargaoa_id)),
                                            array("class"=>"", 
                                                      "target"=>"frameRincian",
                                                      "onclick"=>"$(\"#dialogRincian\").dialog(\"open\");",
                                                      "rel"=>"tooltip",
                                                      "title"=>"Klik untuk melihat Rincian Pengajuan Harga Obat dan Alkes",
                                            ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Ubah',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<icon class=\'icon-form-ubah\'></icon> ', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . '/PengajuanPerubahanHargaObat/index', array("pengajuanhargaoa_id" => $data->pengajuanhargaoa_id)), array("target" => "BLANK", "rel" => "tooltip", "title" => "Klik untuk mengubah pengajuan harga obat & alkes"));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return (!empty($data->pegawaibatal_id) ? "SUDAH DIBATALKAN" : CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPengajuan(' . $data->pengajuanhargaoa_id . ')', array("id" => $data->pengajuanhargaoa_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan pengajuan harga", "data-placement" => "left")));
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Pengajuan Harga Obat dan Alkes',
        'autoOpen' => false,
        'minWidth' => 1000,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameRincian" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approval Pengajuan Perubahan Obat dan Alkes',
        'autoOpen' => false,
        'minWidth' => 1000,
        'minHeight' => 100,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipengajuanoa-v-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="frameMengetahui" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approval Pengajuan Perubahan Obat dan Alkes',
        'autoOpen' => false,
        'minWidth' => 1000,
        'minHeight' => 100,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipengajuanoa-v-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="frameMenyetujui" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalPengajuan',
    'options' => array(
        'title' => 'Form Pembatalan Pengajuan Perubahan Harga Obat dan Alkes',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formPembatalan');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function dialogBatalPengajuan(pengajuanhargaoa_id) {
        $('#DialogBatalPengajuan #pengajuanhargaoa_id').val(pengajuanhargaoa_id);
        $('#DialogBatalPengajuan #keterangan_batal').val('');
        $('#DialogBatalPengajuan').dialog('open');
    }

    function ubahPengajuanKarenaBatal() {
        var pengajuanhargaoa_id = $('#DialogBatalPengajuan #pengajuanhargaoa_id').val();
        var tglbatal = $('#DialogBatalPengajuan #tglbatal').val();
        var pegawaibatal_id = $('#DialogBatalPengajuan #pegawaibatal_id').val();
        var keterangan_batal = $('#DialogBatalPengajuan #keterangan_batal').val();
        $('#DialogBatalPengajuan #keterangan_batal').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Ini, wajib diisi");
            $('#DialogBatalPengajuan #keterangan_batal').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('BatalPengajuan'); ?>',
            data: {
                pengajuanhargaoa_id: pengajuanhargaoa_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal,
                pegawaibatal_id: pegawaibatal_id
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == 'ok') {
                    myAlert(data.keterangan);
                    $('#DialogBatalPengajuan').dialog('close');
                    $.fn.yiiGridView.update('informasipengajuanoa-v-grid', {
                        data: $(this).serialize()
                    });
                } else {
                    myAlert(data.keterangan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>