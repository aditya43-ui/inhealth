<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Blacklist</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#pasienblacklist-info-search').submit(function(){
	$('#informasipasienblacklist-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipasienblacklist-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
                </div>
                <!--search-form-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Blacklist</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipasienblacklist-grid',
                    'dataProvider' => $model->search(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Blacklist',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pasienblacklist_tgl)',
                        ),
                        array(
                            'header' => 'No. Blacklist',
                            'type' => 'raw',
                            'value' => '$data->pasienblacklist_no',
                        ),
                        array(
                            'header' => 'Tanggal Pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
                        array(
                            'header' => 'No. Pendaftaran / No. Rekam Medik',
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran . " / " . $data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Total Tagihan',
                            'type' => 'raw',
                            'value' => '$data->totalsisatagihan',
                        ),
                        array(
                            'header' => 'Kasus',
                            'type' => 'raw',
                            'value' => '$data->pasienblacklist_karenakasus',
                        ),
                        array(
                            'header' => 'Dengan Pegawai',
                            'type' => 'raw',
                            'value' => '$data->nama_pegawai',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->pasienblacklist_ket',
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '($data->isblacklist == 1) ? "Blacklist" : "Tidak" ',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>