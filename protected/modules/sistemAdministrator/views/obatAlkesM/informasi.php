<legend class="rim2">Informasi Kartu Stok Obat Alkes</legend><br/>
<legend class="rim"> Tabel Kartu Stok Obat Alkes</legend>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#search').submit(function(){
	$.fn.yiiGridView.update('informasistokobatalkesruangan-i-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'informasistokobatalkesruangan-i-grid',
	'dataProvider'=>$model->searchInformasi(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Jumlah</center>',
                'start'=>9, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Sub Total Harga</center>',
                'start'=>12, //indeks kolom 3
                'end'=>14, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                        array(
                            'header'=>'Ruangan',
                            'value'=>'$data->ruangan_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tanggal Transaksi',
                            'value'=>'$data->tglstok_in',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Jenis Obat Alkes / Golongan',
                            'value'=>'$data->jenisobatalkes_nama." / ".$data->obatalkes_golongan',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
//                        array(
//                            'header'=>'Golongan',
//                            'value'=>'$data->obatalkes_golongan',
//                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
//                        ),
                        array(
                            'header'=>'Kode',
                            'value'=>'$data->obatalkes_kode',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Nama',
                            'name'=>'obatalkes_nama',
                            'value'=>'$data->obatalkes_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Asal Barang',
                            'value'=>'$data->sumberdana_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Satuan',
                            'value'=>'$data->satuankecil_nama',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Harga',
                            'value'=>'"Rp. ".number_format($data->harganetto_oa,0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tanggal Kadaluarsa',
                            'value'=>'(empty($data->tglkadaluarsa)) ? "-" : $data->tglkadaluarsa',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'In',
                            'value'=>'number_format($data->qtystok_in,0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Out',
                            'value'=>'number_format($data->qtystok_out,0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Current',
                            'value'=>'number_format($data->qtystok_current,0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
             // Sub Total Harga In Out CUrrent //
                        array(
                            'header'=>'In',
                            'value'=>'"Rp. ".number_format(($data->qtystok_in*$data->harganetto_oa),0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Out',
                            'value'=>'"Rp. ".number_format(($data->qtystok_out*$data->harganetto_oa),0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Current',
                            'value'=>'"Rp. ".number_format(($data->qtystok_current*$data->harganetto_oa),0,",",".")',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
            
            // end Sub Total Harga In Out Current //
//                        array(
//                            'header'=>'Diskon',
//                            'value'=>'$data->discount',
//                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
//                        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php $this->renderPartial($this->path_view.'_searchinformasi',array('model'=>$model,'format'=>$format)); ?>
