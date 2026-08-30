<?php
/**
* - digunakan untuk Admin Teknisi Peralatan
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}else{
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
}

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
		////'golongan_id',
		array(
                                        'header'=>'No',
                                        'value' => '$row+1',
                                        'type'=>'raw',
                                        'htmlOptions'=>array('style'=>'text-align:right;'),
                                    ),
									array(
										'header' => 'Nama Teknisi',
										'name' => 'namateknisi',
										'value' => '$data->namateknisi',
									), 
                                    array(
										'header' => 'Supplier',
										'name' => 'supplier_id',
                                        'value' => function($data){
                                            $supplier = SupplierM::model()->findByPk($data->supplier_id);
                                            return $supplier->supplier_nama;
                                        },
									),
                                    array(
										'header' => 'Domisili',
										'name' => 'kabupaten_id',
                                        'value' => function($data){
                                            $kabupaten = KabupatenM::model()->findByPk($data->kabupaten_id);
                                            return $kabupaten->kabupaten_nama;
                                        },
									),
									array(
										'header' => 'Jenis Kelamin',
										'name' => 'jeniskelamin',
										'value' => '$data->jeniskelamin',
									),  
                                    array(
										'header' => 'No Kontak',
										'name' => 'no_kontak_teknisi',
										'value' => '$data->no_kontak_teknisi',
									),  
                                            array(
										'header'=>'<center>Status</center>',
										'value'=>'($data->teknisiperalatan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
										'htmlOptions'=>array('style'=>'text-align:center;'),
									),
 
        ),
    )); 
?>