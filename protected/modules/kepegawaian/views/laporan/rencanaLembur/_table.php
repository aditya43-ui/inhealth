<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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
				'header' => 'No/Tanggal Rencana',
				'type' => 'raw',
				'value' => '$data->norencana."/<br>".MyFormatter::formatDateTimeForUser($data->tglrencana)'
			),
            array(
				'header' => 'Nama Pegawai',
				'value' => function($data){
					if (!empty($data->nama_pegawai)){
						$peg = PegawaiM::model()->find(" LOWER(nama_pegawai) = '".trim(strtolower($data->nama_pegawai))."' ");

						if (!empty($peg)){
							return $peg->namaLengkap;
						}else{
							return '-';
						}								
					}else{
						return '-';
					}
				}
			),
			array(
				'header' => 'Alasan',
				'value' => '$data->alasanlembur'
			),            
			array(
				'header' => 'Pemberi Tugas',
				'value' => '$data->NamaLengkapPemberi'
			),
			array(
				'header' => 'Jam',
				'value' => function($data){
					$mulai = date('H:i:s', strtotime($data->tglmulai));
					$selesai = date('H:i:s', strtotime($data->tglselesai));
					
					return $mulai.' - '.$selesai;
				}
			),
			array(
				'header' => 'Ruangan',
				'value' => '$data->create_ruangan_nama'
			)
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>