<style>
   .clsOdd {
  background-color: #f9f9f9;
}
</style>
<?php
    Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#searchLaporan').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<?php
    
    $itemCssClass='table table-bordered datatable';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$data = $model->searchLaporanOrafin();
    if (isset($caraPrint)){
        $data = $model->searchLaporanOrafinPrint();
        
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            // $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        echo "<style>                    
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
            </style>";
        $itemCssClass='table border';
        //var_dump($itemsCssClass);
    } else{
//        $data = $model->searchLaporan();
		$template = "{summary}\n{items}\n{pager}";
    }
    
    $aa=array();
foreach($data->data as $i=> $itemd) {
    $aa[$itemd->kodejurnal][]=$itemd;
}
$index = 0;
foreach($aa as $i=> $itemd) {
    foreach ($itemd as $itemCheck){
        $itemCheck->checkodd = $index;
    }
     $index++;
}
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
    'rowCssClassExpression' => '($data->checkodd % 2 == 0)?"clsOdd" :"clsEven"',
	'columns'=>array(
		array(
			'header'=>'Status',
			'type'=>'raw',
			'value'=>'"NEW"',
		),
            array(
			'header'=>'Accounting Date',
			'type'=>'raw',
			'value'=>'date("d/m/Y",strtotime($data->tglbukubesar))',
		),
            array(
			'header'=>'Currency Code',
			'type'=>'raw',
			'value'=>'"IDR"',
		),
            array(
			'header'=>'Actual Flag',
			'type'=>'raw',
			'value'=>'"A"',
		),
            array(
			'header'=>'User JE Category Name',
			'type'=>'raw',
			'value'=>'"SHB INV Receiving"',
		),
            array(
			'header'=>'User JE Source Name',
			'type'=>'raw',
			'value'=>'"SHB"',
		),
            array(
			'header'=>'User Currency Conversion Type',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Currency Conversion Rate',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Segment 1',
			'type'=>'raw',
			'value'=>'"12"',
		),
             array(
			'header'=>'Segment 2',
			'type'=>'raw',
			'value'=>'"000"',
		),
             array(
			'header'=>'Segment 3',
			'type'=>'raw',
			'value'=>'"00"',
		),
             array(
			'header'=>'Segment 4',
			'type'=>'raw',
			'value'=>'$data->kdrekening5',
		),
             array(
			'header'=>'Segment 5',
			'type'=>'raw',
			'value'=>'"00"',
		),
             array(
			'header'=>'Segment 6',
			'type'=>'raw',
			'value'=>'"000"',
		),
             array(
			'header'=>'Segment 7',
			'type'=>'raw',
			'value'=>'"000"',
		),
             array(
			'header'=>'Segment 8',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Segment 9',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Segment 10',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Entered Dr',
			'type'=>'raw',
//			'value'=>'$data->saldodebit',
                 'value'=> isset($caraPrint)?($caraPrint == "EXCEL")?'$data->saldodebit':'number_format($data->saldodebit,0,"",".")':'number_format($data->saldodebit,0,"",".")',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
             array(
			'header'=>'Entered Cr',
			'type'=>'raw',
//			'value'=>'$data->saldokredit',
                 'value'=>isset($caraPrint)?($caraPrint == "EXCEL")?'$data->saldokredit':'number_format($data->saldokredit,0,"",".")':'number_format($data->saldokredit,0,"",".")',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
             array(
			'header'=>'Attribute 1',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 2',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 3',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 4',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 5',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 6',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 7',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 8',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 9',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 10',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 11',
			'type'=>'raw',
			'value'=>'',
		),
             array(
			'header'=>'Attribute 12',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Attribute 13',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Attribute 14',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Attribute 15',
			'type'=>'raw',
			'value'=>'',
		),array(
			'header'=>'Attribute 16',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Attribute 17',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Attribute 18',
			'type'=>'raw',
			'value'=>'',
		),array(
			'header'=>'Attribute 19',
			'type'=>'raw',
			'value'=>'',
		),
                 array(
			'header'=>'Reference 1',
			'type'=>'raw',
			'value'=>'$data->jenisjurnal_nama',
		),
            array(
			'header'=>'Reference 2',
			'type'=>'raw',
			'value'=>'$data->jenisjurnal_nama',
		),
            array(
			'header'=>'Reference 3',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Reference 4',
			'type'=>'raw',
			'value'=>'$data->jenisjurnal_nama',
		),  
            array(
			'header'=>'Reference 5',
			'type'=>'raw',
			'value'=>'$data->urianjurnal',
		),
            array(
			'header'=>'Reference 6',
			'type'=>'raw',
			'value'=>'$data->jenisjurnal_nama',
		),
            array(
			'header'=>'Reference 7',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Reference 8',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Reference 9',
			'type'=>'raw',
			'value'=>'',
		),
            array(
			'header'=>'Reference 10',
			'type'=>'raw',
			'value'=>'$data->urianjurnal',
		),
            array(
			'header'=>'Processed Flag',
			'type'=>'raw',
			'value'=>'"U"',
		)
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>