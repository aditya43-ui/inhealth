<?php 
/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridViewBySqlProvider';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        $data = $model->searchPrintObatTerpakai();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootGridViewBySqlProvider';
        
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewBySqlProvider';
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
        $data = $model->searchObatTerpakai();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporanPakaiObat',
	'dataProvider'=>$data,
	'nameOfClass'=>'GFLaporanpenjualanobatV',
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                 'header'=>'No.',
                 'value' => $row,
            ),
			array(
				'header' => 'Jenis',
				'value' => '$data["jenisobatalkes_nama"]'
			),  
			array(
				'header' => 'Golongan',
				'value' => '$data["obatalkes_golongan"]'
			),  
			array(
				'header' => 'Kategori',
				'value' => '$data["obatalkes_kategori"]'
			),  
			array(
				'header' => 'Kode',
				'value' => '$data["obatalkes_kode"]'
			),  
			array(
				'header' => 'Nama',
				'value' => '$data["obatalkes_nama"]'
			),  
			array(
				'header' => 'Jumlah',
				'value' => function($data){
						if ($data["tot_qty"] == -1){
							return '0 '.$data["satuankecil_nama"];
						}else{
							return $data["tot_qty"].' '.$data["satuankecil_nama"];
						}
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
			),
			array(
				'header' => 'Status',
				'value' => '$data["status"]'
			),
           /* array(
				'header' => 'Jenis',
				'value' => '$data["jenisobatalkes_nama"]'
			),  
			array(
				'header' => 'Golongan',
				'value' => '$data["obatalkes_golongan"]'
			),  
			array(
				'header' => 'Kategori',
				'value' => '$data["obatalkes_kategori"]'
			),  
			array(
				'header' => 'Kode',
				'value' => '$data["obatalkes_kode"]'
			),  
			array(
				'header' => 'Nama',
				'value' => '$data["obatalkes_nama"]'
			),  
			array(
				'header' => 'Jumlah',
				'value' => '(empty($data["tot_qty"])?"0":$data["tot_qty"])." ".$data["satuankecil_nama"]'
			),  */
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>