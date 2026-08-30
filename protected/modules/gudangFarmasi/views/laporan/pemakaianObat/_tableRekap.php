<?php 
/**
 * digunakan untuk  laporan
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        $data = $model->searchPrintsRekapPakaiObat();
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
        $data = $model->searchRekapPakaiObat();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporanRekapPakaiObat',
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
				'header' => 'No. Resep',
				'value' => '$data->noresep'
			),  
			array(
				'header' => 'Tanggal Penjualan',
				'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenjualan)'
			),  
			array(
				'header' => 'Jenis Penjualan',
				'value' => '$data->jenispenjualan'
			),  
			array(
				'header' => 'Kode',
				'value' => '$data->obatalkes_kode'
			),  
			array(
				'header' => 'Nama',
				'value' => '$data->obatalkes_nama'
			),  
			array(
				'header' => 'Jumlah',
				'value' => function($data){
						return $data->tot_qty.' '.$data->satuankecil_nama;
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
			),			
           
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>