<?php
$itemCssClass='table table-striped table-bordered table-condensed';
if($caraPrint=='EXCEL')
{
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
header('Cache-Control: max-age=0');
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)){
$data = $model->searchPrint();
$template = "{items}";
$sort = false;
if ($caraPrint == "EXCEL"){
$table = 'ext.bootstrap.widgets.BootExcelGridView';
}if ($caraPrint == "PDF"){
$itemCssClass='table border';
}
} else{
$data = $model->searchPrint();
$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'sajenis-kelas-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		////'karcis_id',
		  array(
                                'header' => 'No.',
                                'value' => '$row+1',
                                ),
                             array(
                             'header'=>'Nama Instalasi',
                             'type'=>'raw',
                             'name'=>'instalasi_id',
                             'value'=>function($data) {
                                $modul = InstalasiM::model()->findByPk($data->instalasi_id);
                            if (empty($modul)) return "Tidak diset";
                            return $modul->instalasi_nama;
                                 },
                                     
                             ),
                            
                             array(
                             'header'=>'Nama Ruangan',
                              'name'=>'ruangan_id',   
                             'type'=>'raw',
                             'value'=>function($data) {
                                $modul = RuanganM::model()->findByPk($data->ruangan_id);
                            if (empty($modul)) return "Tidak diset";
                            return $modul->ruangan_nama;
                                 },
                                  
                             ),
                            'layanansurvei_nama',
                            'layanansurvei_ask',
                            'layanansurvei_desc',            
        ),
    )); 
?>