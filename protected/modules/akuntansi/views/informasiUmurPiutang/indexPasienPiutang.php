<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Umur Piutang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#rekonsiliasibank-info-search').submit(function(){
	$('#informasirekonsiliasibank-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasirekonsiliasibank-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        $format = new MyFormatter();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading" style="background-color: white !important; color: #373e4a !important;">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_searchPasienPiutang', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan Klaim Piutang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasirekonsiliasibank-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'name' => 'pembayaranpelayanan_id',
                            'value' => '$row+1'
                        ),
                        array(
                            'header' => 'Tanggal Pembayaran',
                            'name' => 'tglpembayaran',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaran)'
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'name' => 'nama_pasien',
                            'value' => '$data->pasien->namadepan." ".$data->pasien->nama_pasien'
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'name' => 'no_pendaftaran',
                            'value' => '$data->pendaftaran->no_pendaftaran'
                        ),
                        array(
                            'header' => 'Total Piutang (Rp)',
                            'name' => 'totalpiutang',
                            'value' => 'number_format($data->totalpiutang,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Umur Piutang',
                            'name' => 'lama_piutang',
                            'value' => 'number_format($data->lama_piutang,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '0-30 Hari (Rp)',
                            'name' => 'lama_piutang',
                            'value' => function ($data) {
                                if (($data->lama_piutang >= 0) && ($data->lama_piutang <= 30)) {
                                    return number_format($data->totalpiutang, 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '31-60 Hari (Rp)',
                            'name' => 'lama_piutang',
                            'value' => function ($data) {
                                if (($data->lama_piutang >= 31) && ($data->lama_piutang <= 60)) {
                                    return number_format($data->totalpiutang, 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '61-90 Hari (Rp)',
                            'name' => 'lama_piutang',
                            'value' => function ($data) {
                                if (($data->lama_piutang >= 61) && ($data->lama_piutang <= 90)) {
                                    return number_format($data->totalpiutang, 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '> 90 Hari (Rp)',
                            'name' => 'lama_piutang',
                            'value' => function ($data) {
                                if (($data->lama_piutang > 90)) {
                                    return number_format($data->totalpiutang, 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>