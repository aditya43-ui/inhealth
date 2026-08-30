<?php
/**
* digunakan untuk Master pasal perjanjian
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}else{
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
    echo '<div style="margin-top:20px;">';
    echo '</div>';
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
	'id'=>'pasalperjanjian-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                        'header'=>'No',
                        'value'=>'$row+1',
                ),
                'pasalperjanjian_nama',
                'pasalperjanjian_uraian',
                array(
                    'header' => 'Isi Pasal Perjanjian',
                    'name' => 'pasalperjanjian_isi',
                    'type'=>'raw',
                    'value' => function($data){
                        return $data->pasalperjanjian_isi;
                    },
                ),
		array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->pasalperjanjian_aktif == TRUE ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
 
        ),
    )); 
?>