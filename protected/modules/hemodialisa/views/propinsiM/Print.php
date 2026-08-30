<?php
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
    {
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
                'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
                'template'=>"{items}",
                 'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'No',
                    'value'=>'$row+1'
                ),
                'propinsi_nama',
                'propinsi_namalainnya',
            array
                (
                        'header'=>'Status',
                        'type'=>'raw',
                        'value'=>'($data->propinsi_aktif==1)? Yii::t("mds","Aktif") : Yii::t("mds","Tidak Aktif")',
                ),
             ), 
              
	
    )); ?>
