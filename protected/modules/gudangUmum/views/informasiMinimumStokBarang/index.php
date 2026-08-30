<?php
$this->breadcrumbs = array(
    'Informasi Minimum Stok Barang' => array('index'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#informasiminimumstokbarang-search').submit(function(){
	$.fn.yiiGridView.update('informasiminimumstokbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Minimum Stok Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                        'disabled' => $disabled,
                    )); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Minimum Stok Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'informasiminimumstokbarang-grid',
                    'dataProvider' => $model->searchInformasiMinimum(),
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Kondisi Barang</p>',
                            'start' => 8,
                            'end' => 10,
                        ),
                    ),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Kode Barang',
                            'type' => 'raw',
                            'value' => '$data->barang_kode',
                        ),
                        array(
                            'header' => 'Jenis Barang',
                            'type' => 'raw',
                            'value' => '$data->jenisbarang_nama',
                        ),
                        array(
                            'header' => 'Nama Barang',
                            'type' => 'raw',
                            'value' => '$data->barang_nama',
                        ),
                        array(
                            'header' => 'Merk',
                            'type' => 'raw',
                            'value' => '$data->barang_merk',
                        ),
                        array(
                            'header' => 'No. Seri',
                            'type' => 'raw',
                            'value' => '$data->barang_noseri',
                        ),
                        array(
                            'header' => 'Tahun Beli',
                            'type' => 'raw',
                            'value' => '$data->barang_thnbeli',
                        ),
                        array(
                            'header' => 'Harga Beli (Rp)',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatNumberForPrint($data->inventarisasi_hargabeli_avg)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Baik',
                            'type' => 'raw',
                            'value' => '$data->qtykeadaan_baik." ".$data->barang_satuan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Dalam Perbaikan',
                            'type' => 'raw',
                            'value' => '$data->qtykeadaan_dalamperbaikan." ".$data->barang_satuan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Rusak',
                            'type' => 'raw',
                            'value' => '$data->qtykeadaan_rusak." ".$data->barang_satuan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Jumlah Barang',
                            'type' => 'raw',
                            'value' => '$data->inventarisasi_stok." ".$data->barang_satuan',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Minimal Stok',
                            'type' => 'raw',
                            'value' => '$data->minimalstok',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>