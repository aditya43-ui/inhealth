<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
//    if (isset($caraPrint)){
        $data = $model->searchPrintInformasi();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
//    } else{
//        $data = $model->search();
//         $template = "{summary}\n{items}\n{pager}";
//    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$model->searchPrintInformasi(),
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'No',
                    'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                ),
		 array(
                        'header'=>'Kode Obat',
                        'name'=>'obatalkes_kode',
                        'value'=>'$data->obatalkes_kode',
                ),
		array(
                        'header'=>'Nama Obat',
                        'name'=>'obatalkes_nama',
                        'value'=>'$data->obatalkes_nama',
                ),
		array(
                        'header'=>'Asal Barang',
                        'name'=>'sumberdanaNama',
//                        'filter'=>  CHtml::listData(SumberdanaM::model()->findAll(), 'sumberdana_id', 'sumberdana_nama'),
                        'value'=>'$data->sumberdana->sumberdana_nama',
                ),
		array(
                        'header'=>'Jenis Obat',
                        'name'=>'jenisobatalkes_id',
//                        'filter'=>  CHtml::listData($model->JenisObatAlkesItems, 'jenisobatalkes_id', 'jenisobatalkes_nama'),
                        'value'=>'$data->jenisobatalkes->jenisobatalkes_nama',
                ),
		array(
                        'header'=>'Satuan Besar',
                        'name'=>'satuanbesar_id',
//                        'filter'=>  CHtml::listData($model->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'),
                        'value'=>'$data->satuanbesar->satuanbesar_nama',
                ),
                
		array(
                        'header'=>'Satuan Kecil',
                        'name'=>'satuankecil_id',
//                        'filter'=>  CHtml::listData($model->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'),
                        'value'=>'$data->satuankecil->satuankecil_nama',
                ),
                array(
                        'header'=>'Tgl. Kadaluarsa',
                        'name'=>'tglkadaluarsa',
                        'value'=>'$data->tglkadaluarsa',
                ),
		array(
                        'header'=>'Isi Kemasan  / <br> Min. Stok',
//                        'name'=>'obatalkes_kategori',
                        'type'=>'raw',
                        'value'=>'$data->kemasanbesar ."/ <br/>". $data->minimalstok',
                ),
                array(
                    'header'=>'Harga Netto',
                    'name'=>'harganetto',
                    'value'=>'"Rp. ".CustomFunction::formatnumber($data->harganetto)',
                    'filter'=>false,
                ),
                array(
                    'header'=>'Harga Jual',
                    'name'=>'hargajual',
                    'value'=>'"Rp. ".CustomFunction::formatnumber($data->hargajual)',
                    'filter'=>false,
                ),
        ),
    )); 
?>