<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
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
                'header'=>'Nama Alat Medis',
                'type'=>'raw',
                'value'=>'$data->alatmedis_nama',
            ),
             array(
                'header'=>'Harga Alat Medis',
                'type'=>'raw',
                'value'=>'number_format($data->alatmedis_harga,0,"",".")',
				'htmlOptions' => array('style'=>'text-align:right;')
            ),
            array(
                'header'=>'Jumlah Pemakaian',
				'htmlOptions' => array('style'=>'text-align: right;'),
                'value'=>'$data->jumlah',
            ),
            array(
                'header'=>'HPP/hari',
				'htmlOptions' => array('style'=>'text-align: right;'),
                'value'=>'number_format($data->alatmedis_hppperhari,0,"",".")',
            ),           
//            'NamaNamaBIN',            
            array(
                'header'=>'Subtotal',
                'type'=>'raw',
				'htmlOptions' => array('style'=>'text-align: right;'),
				'value'=>function($data){
					if (empty($data->alatmedis_hppperhari)){
						$data->alatmedis_hppperhari = 0;
					}
					$subtotal = $data->jumlah * $data->alatmedis_hppperhari;
					
					return number_format($subtotal,0,"",".");
				},
            ),
            array(
                'header'=>'Target',
                'type'=>'raw',
				'value'=>function($data) use ($model){
					if (!empty($data->alatmedis_trgtbep_sat) && !empty($data->alatmedis_trgtbep)){
						$alatmedis = AlatmedisM::model()->findByPk($data->alatmedis_id);
						$satuan = Params::getSatuanDate(strtolower($data->alatmedis_trgtbep_sat));
						
																	
						if (!empty($alatmedis->alatmedis_tglkalibrasi)){
							$tgl = date('Y-m-d',strtotime(' +'.$data->alatmedis_trgtbep." $satuan", strtotime($alatmedis->alatmedis_tglkalibrasi)));
							$target = MyFormatter::formatDateTimeForUser($tgl);//.' ('.$data->alatmedis_trgtbep." ".$data->alatmedis_trgtbep_sat.')' ;
						}else{
							$target = 'Tanggal Kalibrasi Belum di Set';
						}
					}else{
						$target = '-';
					}
					
					return $target;
				},
            ),
            array(
                'header'=>'Persentase Realisasi',
                'type'=>'raw',
				'value'=>function($data){
					$realisasi = '-';
					if ( ($data->alatmedis_harga != 0) || (!empty($data->alatmedis_harga)) ){
						$subtotal = $data->jumlah * $data->alatmedis_hppperhari;

						$realisasi = ($subtotal/$data->alatmedis_harga)*100;												
					}
					
					return $realisasi.' %';
				},
            ),           
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>