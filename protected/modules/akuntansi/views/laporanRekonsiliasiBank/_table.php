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
	$data = $model->searchLaporan();
    if (isset($caraPrint)){
        $data = $model->searchLaporanPrint();
        
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
        $data = $model->searchLaporan();
		$template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		array(
			'header'=>'No. Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'$data->rekonsiliasibank_no',
		),
		array(
			'header'=>'Tanggal Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->rekonsiliasibank_tgl)',
		),
		array(
			'header'=>'Bank',
			'type'=>'raw',
			'value'=>'$data->namabank',
		),
		array(
			'header'=>'Jenis Rekonsiliasi Bank',
			'type'=>'raw',
			'value'=>'$data->jenisrekonsiliasibank_nama',
		),
		array(
			'header'=>'Kode Rekening',
			'type'=>'raw',
			'value'=>'$data->kdrekening5',
		),
		array(
			'name'=>'Nama Rekening',
			'type'=>'raw',
			'value'=>'$data->getNamaRekening()',
		),
		array(
			'name'=>'Saldo Debit',
			'type'=>'raw',
			'value'=>'number_format($data->saldodebit,0,"",".")',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
		array(
			'name'=>'Saldo Kredit',
			'type'=>'raw',
			'value'=>'number_format($data->saldokredit,0,"",".")',
			'htmlOptions'=>array(
				'style'=>'text-align:right;',
			),
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>