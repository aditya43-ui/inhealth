
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
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'invjalan_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->invjalan_id',
                ),
		array(
                        'name'=>'pemilikbarang_id',
                        'filter'=>  CHtml::listData($model->PemilikItems, 'pemilikbarang_id', 'pemilikbarang_nama'),
                        'value'=>'$data->pemilik->pemilikbarang_nama',
                ),
				array(
                        'name'=>'barang_id',
                        'filter'=>  CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'),
                        'value'=>'$data->barang->barang_nama',
                
                ),
				array(
                        'name'=>'asalaset_id',
                        'filter'=>  CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'),
                        'value'=>'(isset($data->asal->asalaset_id) ? $data->asal->asalaset_nama : "")',
                ),
				array(
                        'name'=>'lokasi_id',
                        'filter'=>  CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'),
                        'value'=>'(isset($data->lokasi->lokasi_id) ? $data->lokasi->lokasiaset_namalokasi : "")',
                ),
		'invjalan_kode',
		/*
		'invjalan_noregister',
		'invjalan_namabrg',
		'invjalan_kontruksi',
		'invjalan_panjang',
		'invjalan_lebar',
		'invjalan_luas',
		'invjalan_letak',
		'invjalan_tgldokumen',
		'invjalan_tglguna',
		'invjalan_nodokumen',
		'invjalan_statustanah',
		'invjalan_keadaaan',
		'invjalan_harga',
		'invjalan_akumsusut',
		'invjalan_ket',
		'craete_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		*/
 
        ),
    )); 
?>