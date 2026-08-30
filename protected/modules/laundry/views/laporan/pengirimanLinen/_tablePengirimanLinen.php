<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    $itemCssClass= 'table table-striped table-condensed';
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';}
        echo "
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

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
          $itemCssClass='table border';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCssClass,
    'columns'=>array(
        array(
			'header'=>'No.',
			'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
			'type'=>'raw',
        ),
		array(
			'header'=>'No. Pengiriman',
			'value'=>'$data->pengperawatanlinen_no',
			'type'=>'raw',
        ),
		array(
			'header'=>'Tanggal Pengiriman',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengperawatanlinen)',
			'type'=>'raw',
        ),
		array(
			'header'=>'Instalasi Tujuan',
			'value'=>'$data->instalasi_nama',
			'type'=>'raw',
        ),
		array(
			'header'=>'Ruangan Tujuan',
			'value'=>'$data->ruangan_nama',
			'type'=>'raw',
        ),
    ),
)); ?> 
