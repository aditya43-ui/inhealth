
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->search();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeColumns' => array('supplier_nama','supplier_kode','supplier_alamat'),
	'columns'=>array(
		array(
                    'header' => 'No.',
                    'value'=>'$row+1',
                ),
                array(
                    'header'=>'Kode Supplier',
                    'type'=>'raw',
                    'name'=>'supplier_kode',
                    'value'=>'(isset($data->supplier->supplier_kode) ? $data->supplier->supplier_kode : "")',
                ),
                array(
                    'header'=>'Nama Supplier',
                    'type'=>'raw',
                    'name'=>'supplier_nama',
                    'value'=>'(isset($data->supplier->supplier_nama) ? $data->supplier->supplier_nama : "")',
                ),
                array(
                    'header'=>'Alamat Supplier',
                    'type'=>'raw',
                    'name'=>'supplier_alamat',
                    'value'=>'(isset($data->supplier->supplier_id) ? $data->supplier->supplier_alamat : "-")',
                ),
                array(
                    'header'=>'Nama Obat Alkes',
                    'type'=>'raw',
                    'name'=>'obatalkes_nama',
                    'value'=>'(isset($data->obatalkes->obatalkes_nama) ? $data->obatalkes->obatalkes_nama : "Tidak Diset")',
                ),
                array(
                    'header'=>'Satuan Kecil',
                    'type'=>'raw',
                    'name'=>'satuankecil_id',
                    'value'=>'(isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "Tidak Diset")',
                ),
                array(
                    'header'=>'Satuan Besar',
                    'type'=>'raw',
                    'name'=>'satuanbesar_id',
                    'value'=>'(isset($data->satuanbesar->satuanbesar_nama) ? $data->satuanbesar->satuanbesar_nama : "Tidak Diset")',
                ),
                array(
                    'header'=>'Harga Beli <br> Satuan Besar',
                    'type'=>'raw',
                    'name'=>'hargabelibesar',
                    'value'=>'(isset($data->hargabelibesar) ? $data->hargabelibesar : "Tidak Diset" )',
                ),
                array(
                    'header'=>'Harga Beli <br> Satuan Kecil',
                    'type'=>'raw',
                    'name'=>'hargabelikecil',
                    'value'=>'(isset($data->hargabelikecil) ? $data->hargabelikecil : "Tidak Diset")',
                ),
                array(
                    'header'=>'Keringanan(%)',
                    'type'=>'raw',
                    'name'=>'diskon_persen',
                    'value'=>'(isset($data->diskon_persen) ? $data->diskon_persen : "Tidak Diset")',
                ),
                array(
                    'header'=>'Ppn(%)',
                    'type'=>'raw',
                    'name'=>'ppn_persen',
                    'value'=>'(isset($data->ppn_persen) ? $data->ppn_persen : "Tidak Diset")',
                ),
//                 array(
//                    'header' => 'Status',
//                    'value'=>'($data->supplier->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
//                    'htmlOptions'=>array('style'=>'text-align:center;'),
//                ),
        ),
    )); 
?>