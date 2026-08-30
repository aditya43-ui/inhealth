<style>                    
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
                
                .border{
                    box-shadow:none;
                }
            </style>
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
	'itemsCssClass'=>'table border',
	'columns'=>array(
		 array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
								($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
								: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:center; width:5px;'),
		),
		array(
				'name'=>'Periode Anggaran',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglanggaran)',
		),
		array(
				'name'=>'Sampai Dengan',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->sd_tglanggaran)',
		),                
		'deskripsiperiode',
		array(
				'header'=>'Status Closing',
				'type'=>'raw',
				'value'=>'(($data->isclosing_anggaran) ? "Aktif" : "Tidak Aktif")',
		),
),
)); 
?>