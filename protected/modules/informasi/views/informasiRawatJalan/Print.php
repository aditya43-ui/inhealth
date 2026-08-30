
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

 $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasiPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchInformasiPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'ininformasiTarif-grid',
	'dataProvider'=>$data,
        'enableSorting'=>false,
        'template'=>$template,
         'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Kelas</p>',
                'start'=>5, //indeks kolom 5
                'end'=>8, //indeks kolom 8
            ),
        ),
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No.',
                'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ),
            array(
                    'header'=>'Instalasi / Ruangan ',
                    'type'=>'raw',
                    'value'=>'$data->InstalasiRuangan',
                ),
                'kelompoktindakan_nama',
                'kategoritindakan_nama',
                'daftartindakan_nama',
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">I</p>',
                    'value'=>'$this->grid->owner->renderPartial("_tarifKelas",array(instalasi_id=>$data->instalasi_id ,kelaspelayanan_id=>2, daftartindakan_id=>$data->daftartindakan_id),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">II</p>',
                    'value'=>'$this->grid->owner->renderPartial("_tarifKelas",array(instalasi_id=>$data->instalasi_id ,kelaspelayanan_id=>3, daftartindakan_id=>$data->daftartindakan_id),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">III</p>',
                    'value'=>'$this->grid->owner->renderPartial("_tarifKelas",array(instalasi_id=>$data->instalasi_id ,kelaspelayanan_id=>4, daftartindakan_id=>$data->daftartindakan_id),true)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">VIP</p>',
                    'value'=>'$this->grid->owner->renderPartial("_tarifKelas",array(instalasi_id=>$data->instalasi_id ,kelaspelayanan_id=>1, daftartindakan_id=>$data->daftartindakan_id),true)',
                ),
             
           
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>