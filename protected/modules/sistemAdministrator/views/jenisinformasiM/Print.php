
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        /*
        array(
            'header'=>'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
        ),
         * 
         */
        array(
            'name'=>'jenisinformasi_id',
            'header'=>'ID',
            'filter'=>false,
        ),
        array(
            'name'=>'jenissurat_id',
            'type'=>'raw',
            'value'=>function($data) {
                return empty($data->jenissurat) ? "-" : $data->jenissurat->jenissurat_nama;
            },
            'filter'=>CHtml::activeDropDownList($model, 'jenissurat_id', CHtml::listData(JenisSuratM::model()->findAll('jenissurat_aktif = true order by jenissurat_nama asc'), 'jenissurat_id', 'jenissurat_nama'), array('empty'=>'-- Pilih --')),
        ),
        'jenisinformasi_nama',
        'jenisinformasi_namalain',
        //'jenisinformasi_urutan',
        array(
            'name'=>'tipeinput_isiinformasi',
            'filter'=>CHtml::activeDropDownList($model, 'jenissurat_id', Params::getTipeInputIsiInformasiList(), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'jenisinformasi_aktif',
            'value'=>'$data->jenisinformasi_aktif ? "Aktif" : "Tidak Aktif"',
            'filter'=>false,
        ),
    ),
)); 
?>