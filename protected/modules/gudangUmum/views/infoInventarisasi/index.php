<?php $linkHalaman = CustomFunction::getUrlByMenuID(720); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Inventarisasi Barang',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('infoinvbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php
$konfig = KonfigsystemK::model()->find();
$classHidden = true;
if (isset($konfig->tampilhargagu)) {
    if ($konfig->tampilhargagu == false) {
        $classHidden = false;
    }
}
?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Inventarisasi Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body search-form">
                <!--fieldset class="box search-form"-->
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
                <!--/fieldset-->
                <!-- search-form -->
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Inventarisasi Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'infoinvbarang-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '($this->grid->dataProvider->pagination) ?
												($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
												: ($row+1)',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align:center;'),
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Tanggal Inventarisasi',
                                'name' => 'invbarang_tgl',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->invbarang_tgl)',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'No. Inventarisasi',
                                'name' => 'invbarang_no',
                                'type' => 'raw',
                                'value' => '$data->invbarang_no',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Tanggal Formulir',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'No. Formulir',
                                'name' => 'forminvbarang_no',
                                'type' => 'raw',
                                'value' => '$data->forminvbarang_no',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Jenis Inventarisasi',
                                'type' => 'raw',
                                'value' => '$data->invbarang_jenis',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Keterangan',
                                'name' => 'invbarang_ket',
                                'type' => 'raw',
                                'value' => '$data->invbarang_ket',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Total Nilai Persediaan (Rp)',
                                'type' => 'raw',
                                'value' => '"Rp. " . MyFormatter::formatNumberForPrint($data->totalnilaipersediaan,2)',
                                'htmlOptions' => array(
                                    'style' => 'text-align:right',
                                ),
                                'headerHtmlOptions' => array('style' => 'text-align:center; '),
                            ),
                            array(
                                'header' => 'Pegawai Mengetahui',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $pgNama = "";
                                    if (!empty($data->mengetahui_id)) {
                                        $peg = PegawaiM::model()->findByPk($data->mengetahui_id);
                                        $pgNama = (isset($peg) ? $peg->namaLengkap : "");
                                    }
                                    return $pgNama;
                                },
                            ),
                            array(
                                'header' => 'Pegawai 1',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $pgNama = "";
                                    if (!empty($data->petugas1_id)) {
                                        $peg = PegawaiM::model()->findByPk($data->petugas1_id);
                                        $pgNama = (isset($peg) ? $peg->namaLengkap : "");
                                    }
                                    return $pgNama;
                                },
                            ),
                            array(
                                'header' => 'Pegawai 2',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $pgNama = "";
                                    if (!empty($data->petugas2_id)) {
                                        $peg = PegawaiM::model()->findByPk($data->petugas2_id);
                                        $pgNama = (isset($peg) ? $peg->namaLengkap : "");
                                    }
                                    return $pgNama;
                                },
                            ),
                            array(
                                'header' => 'Detail Inventarisasi',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-formulir\"></i>","' . $this->getUrlPrint() . '&invbarang_id=$data->invbarang_id&frame=true",
											array("class"=>"",
												"target"=>"inventarisasi",
												"onclick"=>"$(\"#dialogInventarisasi\").dialog(\"open\");",
												"rel"=>"tooltip",
												"title"=>"Klik untuk melihat detail formulir",
											))',
                                'htmlOptions' => array('style' => 'text-align:center;'),
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::link('<i class="icon-form-silang"></i>', "#", array(
                                        'rel' => 'tooltip',
                                        'name' => 'Klik untuk membatalkan inventarisasi.',
                                        'onclick' => 'batalInventarisasi(' . $data->invbarang_id . '); return false;'
                                    ));
                                }
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
            <div class="panel-body search-form">
                <!--fieldset class="box search-form"-->
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
                <!--/fieldset-->
                <!-- search-form -->
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogInventarisasi',
    'options' => array(
        'title' => 'Detail Inventarisasi Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="inventarisasi" width="100%" height="500">
</iframe>';
$this->endWidget();
?>
<script>
    function batalInventarisasi(id) {
        myConfirm("Anda yakin untuk membatalkan inventarisasi ini ?", "Peringatan", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl("batalInventarisasi"); ?>", {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert("Transaksi Inventarisasi berhasil dibatalkan");
                        $.fn.yiiGridView.update("infoinvbarang-grid");
                    } else {
                        myAlert(data.msg);
                    }
                }, "json");
            }
        });
    }
</script>