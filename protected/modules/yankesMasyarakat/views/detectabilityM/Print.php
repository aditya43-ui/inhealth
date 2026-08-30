
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      
}else{
   echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      
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
                            'header' => 'Bobot',
                            'name' => 'detectability_bobot',
                            'value' => function($data){
                                if(!empty($data->detectability_bobot)){
                                    return $data->detectability_bobot;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Deskripisi',
                            'name' => 'detectability_deskripsi',
                            'value' => function($data){
                                if(!empty($data->detectability_deskripsi)){
                                    return $data->detectability_deskripsi;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Kemungkinan Deteksi',
                            'name' => 'detectability_kemungkinan',
                            'value' => function($data){
                                if(!empty($data->detectability_kemungkinan)){
                                    return $data->detectability_kemungkinan;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->detectability_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
 
	),
)); 
?>