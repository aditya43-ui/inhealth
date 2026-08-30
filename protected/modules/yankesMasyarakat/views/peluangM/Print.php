
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
                            'header' => 'Descriptor',
                            'name' => 'peluang_descriptor',
                            'value' => function($data){
                                if(!empty($data->peluang_descriptor)){
                                    return $data->peluang_descriptor;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Bobot Descriptor',
                            'name' => 'peluang_bobotdescriptor',
                            'value' => function($data){
                                if(!empty($data->peluang_bobotdescriptor)){
                                    return $data->peluang_bobotdescriptor;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Deskripsi',
                            'name' => 'peluang_deskripsi',
                            'value' => function($data){
                                if(!empty($data->peluang_deskripsi)){
                                    return $data->peluang_deskripsi;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Frekuensi',
                            'name' => 'peluang_frekuensi',
                            'value' => function($data){
                                if(!empty($data->peluang_frekuensi)){
                                    return $data->peluang_frekuensi;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Kemungkinan',
                            'name' => 'peluang_kemungkinan',
                            'value' => function($data){
                                if(!empty($data->peluang_kemungkinan)){
                                    return $data->peluang_kemungkinan;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->peluang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
 
	),
)); 
?>