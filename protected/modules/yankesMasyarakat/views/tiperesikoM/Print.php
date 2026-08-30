
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));      
}else{
   echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));      
   echo '<div style="margin-top:20px">';
   echo '</div>';
}
    $table = 'ext.bootstrap.widgets.BootGridView';
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
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'No',
                            'value'=>'$row+1',
                        ),
                        array(
                            'header' => 'Nama',
                            'name' => 'tiperesiko_nama',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_nama)){
                                    return $data->tiperesiko_nama;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Nama Lain',
                            'name' => 'tiperesiko_namalain',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_namalain)){
                                    return $data->tiperesiko_namalain;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Kode',
                            'name' => 'tiperesiko_kode',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_kode)){
                                    return $data->tiperesiko_kode;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Keterangan',
                            'name' => 'tiperesiko_keterangan',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_keterangan)){
                                    return $data->tiperesiko_keterangan;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->tiperesiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
 
	),
)); 
?>