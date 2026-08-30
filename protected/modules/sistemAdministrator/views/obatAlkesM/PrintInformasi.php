<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchCategoryprint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchCategoryprint();
         $template = "{summary}\n{items}\n{pager}";
    }
   ?>

<?php $this->widget($table,array(
	'id'=>'informasistokobatalkesruangan-i-grid',
	'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Jumlah</center>',
                'start'=>8, //indeks kolom 3
                'end'=>10, //indeks kolom 4
            ),
        ),
	'columns'=>array(
                        array(
                            'header'=>'No',
                            'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ),
//                        array(
//                            'header'=>'Tanggal Transaksi',
//                            'value'=>'$data->tglstok_in',
//                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
//                        ),
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
                            'value'=>'"Rp. ".number_format($data->hargajual_oa)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Tanggal Kadaluarsa',
                            'value'=>'$data->tglkadaluarsa',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'In',
                            'value'=>'"Rp. ".number_format($data->qtystok_in)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Out',
                            'value'=>'"Rp. ".number_format($data->qtystok_out)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
                        array(
                            'header'=>'Current',
                            'value'=>'"Rp. ".number_format($data->qtystok_current)',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        ),
//                        array(
//                            'header'=>'Diskon',
//                            'value'=>'$data->discount',
//                            'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
//                        ),
	),
)); ?>