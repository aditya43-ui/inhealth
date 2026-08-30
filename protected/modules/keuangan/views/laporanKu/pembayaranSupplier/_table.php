<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        }
        
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
        $data = $model->searchTable();
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
                 'value' => $row,
            ),
			array(
                'header'=>'Tgl. BKK/<br>No. BKK',
				'type' => 'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglkaskeluar)."/<br> ".$data->nokaskeluar',
            ),            
            array(
                'header'=>'Tgl. Jatuh Tempo',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
            ),
            array(
                'header'=>'Tgl. Faktur/<br>No Faktur',
				'type' => 'raw',
				'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur)))."/<br> ".$data->nofaktur',
            ),
			array(
				'header'=>'Supplier',
				'value'=>'$data->supplier_nama',
				'footer'=>'<b>Total</b>',
				'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;')
			),
			array(
				'header' => 'Jumlah Tagihan',
				'value'=>'number_format($data->totaltagihan,0,"",".")',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'name'=>'totaltagihan',
				'footer'=>'sum(totaltagihan)',
				'footerHtmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'header' => 'Jumlah Pembayaran',
				'value'=>'number_format($data->jmldibayarkan,0,"",".")',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'name'=>'jmldibayarkan',
				'footer'=>'sum(jmldibayarkan)',
				'footerHtmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'header' => 'Sisa Tagihan',
				'value'=>'number_format($data->sisahutang,0,"",".")',
				'name'=>'sisahutang',
				'footer'=>'sum(sisahutang)',
				'footerHtmlOptions'=>array('style'=>'text-align:right;'),
				'htmlOptions' => array('style' => 'text-align: right;'),
			),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>