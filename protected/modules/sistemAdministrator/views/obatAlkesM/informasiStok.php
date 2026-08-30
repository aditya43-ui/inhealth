<legend class="rim2">Informasi Stok Obat Alkes</legend>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#stokobatalkes-search').submit(function(){
	$.fn.yiiGridView.update('informasistokobatalkesruangan-i-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'informasistokobatalkesruangan-i-grid',
	'dataProvider'=>$model->searchInformasiStok(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
         'mergeHeaders'=>array(
            array(
                'name'=>'<center>Jumlah</center>',
                'start'=>7, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Sub Total Harga</center>',
                'start'=>10, //indeks kolom 3
                'end'=>12, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                array(
                    'header'=>'Ruangan',
                    'value'=>'$data->ruangan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Jenis Obat Alkes / Golongan',
                    'value'=>'$data->jenisobatalkes_nama." / ".$data->obatalkes_golongan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Kode',
                    'value'=>'$data->obatalkes_kode',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Nama',
                    'value'=>'$data->obatalkes_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Asal Barang',
                    'value'=>'$data->sumberdana_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Stok',
                    'value'=>'number_format($data->qtystok_current)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'header'=>'Satuan',
                    'value'=>'$data->satuankecil_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php $this->renderPartial($this->path_view.'_searchStok',array('model'=>$model)); ?>