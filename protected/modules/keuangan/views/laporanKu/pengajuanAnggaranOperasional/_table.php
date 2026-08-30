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
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
				'header' => 'Tanggal Pengajuan',
				'value' => 'MyFormatter::formatDateTimeForUser($data->pengajuanpetty_tgl)'
			),      
			array(
				'header' => 'No. Pengajuan',
				'value' => '$data->pengajuanpetty_no'
			),
			array(
				'header' => 'Untuk Pengajuan Pembelian',
				'value' => '$data->pengajuanpetty_untuk'
			),
			array(
				'header' => 'Yang Mengajukan',
				'value' => '$data->NamaLengkapMengajukan'
			),
			array(
				'header' => 'Divisi',
				'value' => function($data){
					$u = PengajuanpettyT::model()->findByPk($data->pengajuanpetty_id);
					
					if (!empty($u->unitkerja->namaunitkerja)){
						return $u->unitkerja->namaunitkerja;
					}else{
						return '-';
					}
				},
				'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'Grand Total',
			),
			array(
				'header' => 'Total Harga',
				'name' => 'pengajuanpetty_total',
				'value' => 'number_format($data->pengajuanpetty_total,0,"",".")',
				'htmlOptions' => array('style'=>'text-align: right;'),
				'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold;'),
                'footer'=>'sum(pengajuanpetty_total)',
			),		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>