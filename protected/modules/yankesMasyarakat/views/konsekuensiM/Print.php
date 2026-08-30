
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
                            'header' => 'Domain',
                            'name' => 'konsekuensi_domain',
                            'value' => function($data){
                                if(!empty($data->konsekuensi_domain)){
                                    return $data->konsekuensi_domain;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Bobot Domain',
                            'name' => 'konsekuensi_bobot',
                            'value' => function($data){
                                if(!empty($data->konsekuensi_bobot)){
                                    return $data->konsekuensi_bobot;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Bobot Nama',
                            'name' => 'konsekuensi_namabobot',
                            'value' => function($data){
                                if(!empty($data->konsekuensi_namabobot)){
                                    return $data->konsekuensi_namabobot;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Deskripsi',
                            'name' => 'konsekuensi_deskripsi',
                            'value' => function($data){
                                if(!empty($data->konsekuensi_deskripsi)){
                                    return $data->konsekuensi_deskripsi;
                                }else{
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->konsekuensi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
 
	),
)); 
?>