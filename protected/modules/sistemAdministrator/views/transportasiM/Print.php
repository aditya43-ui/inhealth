
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
if ($caraPrint=='EXCEL') {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>4));      
    } else {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
    
    }     

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'lookup_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->lookup_id',
                ),
		'lookup_type',
		'lookup_name',
		array(
                        'header'=>'Nama Lain',
                        'value'=>'$data->lookup_value',
                ),
		'lookup_kode',
		/*
		'lookup_aktif',
		*/
 
        ),
    )); 
?>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF" && $caraPrint!="EXCEL"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>