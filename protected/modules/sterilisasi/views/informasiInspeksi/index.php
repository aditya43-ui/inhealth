<?php
$this->breadcrumbs = array(
    'Informasi Proses Inspeksi',
);
Yii::app()->clientScript->registerScript('search', "
$('#inspeksi-info-search').submit(function(){
	$('#inspeksi-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('inspeksi-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Proses Inspeksi</b>
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
                <?php echo $this->renderPartial($this->path_view . '_search', array('model' => $model), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Proses Inspeksi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'inspeksi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                            'value' => '$row+1'
                        ),
                        array(
                            'name' => 'create_time',
                            'header' => 'Tgl. Inspeksi',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->create_time)',
                        ),
                        array(
                            'name' => 'tgl_pembersihan',
                            'header' => 'Tgl. Pembersihan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pembersihan)',
                        ),
                        array(
                            'name' => 'no_pembersihan',
                            'header' => 'No. Pembersihan',
                        ),
                        array(
                            'name' => 'jenisperalatan',
                            'header' => 'Jenis Peralatan',
                        ),
                        array(
                            'name' => 'barang_nama',
                            'header' => 'Nama Peralatan',
                        ),
                        array(
                            'name' => 'jml',
                            'header' => 'Jumlah',
                        ),
                        'ins_kebersihan',
                        'ins_perubahanpermukaan',
                        'ins_lubrikasi',
                        'ins_fungsionalitas',
                        array(
                            'name' => 'tindaklanjut',
                            'header' => 'Tindak Lanjut',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>