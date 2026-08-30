
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if ($caraPrint=='EXCEL') {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      
    } else {
        echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
    
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
		////'kelompokdiagnosa_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->kelompokdiagnosa_id',
                ),
		'kelompokdiagnosa_nama',
		'kelompokdiagnosa_namalainnya',
		array
                (
                        'header'=>'Status',
                        'type'=>'raw',
                        'value'=>'($data->kelompokdiagnosa_aktif==TRUE)?"Aktif":"Tidak Aktif"',
                ),
 
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