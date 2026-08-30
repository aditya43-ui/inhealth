
<?php
$itemCssClass='table table-striped table-bordered table-condensed';
if($caraPrint=='EXCEL')
{
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
header('Cache-Control: max-age=0');
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));
}else{
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));
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
$itemCssClass = 'table border';
}
} else{
$data = $model->searchPrint();
$template = "{summary}\n{items}\n{pager}";
}

$this->widget($table,array(
'id'=>'domain-m-grid',
'enableSorting'=>false,
'dataProvider'=>$data,
'template'=>$template,
'enableSorting'=>$sort,
'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		////'asalrujukan_id',
                 array(
                    'header' => 'No',
                    'value' => '$row+1',
                    ),		
                'terminologi',
                'domain_nama',
                'domain_kode',
                'domain_kelas',
                // 'domain_nama',
                array(
                        'header'=>'Aktif',
                        'type'=>'raw',
                        'value'=>'(($data->domain_aktif)? "Ya" : "Tidak")',
                ),
                ),
    )); 
?>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>