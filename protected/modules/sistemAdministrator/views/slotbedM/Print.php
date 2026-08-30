
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan));      

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'slotbed_id',
		array(
                        'name'=>'slotbed_id',
                        'value'=>'$data->slotbed_id',
                        'filter'=>false,
                ),
		array(
                       'name'=>'instalasi_id',
                       'filter'=>  CHtml::listData(RuanganM::model()->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
                       'value'=>'$data->instalasi->instalasi_nama',
               ),
		'jadwal_hari',                  
		'jadwal_buka',
 
        ),
    )); 
?>

<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>