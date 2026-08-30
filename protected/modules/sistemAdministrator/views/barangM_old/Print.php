
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
		////'barang_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->barang_id',
                ),
		array(
                        'name'=>'bidang_id',
                        'filter'=>  CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
                        'value'=>'$data->bidang->bidang_nama',
                ),
		'barang_type',
		'barang_kode',
		'barang_nama',
		'barang_namalainnya',
		 array(
                        'header' => 'Status',
                        'value'=>'($data->barang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		/*
		'barang_merk',
		'barang_noseri',
		'barang_ukuran',
		'barang_bahan',
		'barang_thnbeli',
		'barang_warna',
		'barang_statusregister',
		'barang_ekonomis_thn',
		'barang_satuan',
		'barang_jmldlmkemasan',
		'barang_aktif',
		*/
 
        ),
    )); 
?>