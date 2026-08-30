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
	'id'=>'tableLaporanEksternal',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCssClass,
	'overflowx'=>true,
	 'mergeHeaders'=>array(
                    array(
                        'name'=>'<p style="margin: 0; text-align: center;">Rencana Biaya</p>',
                        'start'=>'10',
                        'end'=>'13',
                    ),
                ),
	'columns'=>array(
            array(
                 'header'=>'No.',
                 'value' => $row,
            ),
			array(
				'header' => 'No. Rencana',
				'value' => '$data->norencanadiklat'
			),
            array(
                'header'=>'Pelatihan',
                'type'=>'raw',
                'value'=>'$data->namadiklat',
            ),
              array(
                'header'=>'Tanggal',
                'type'=>'raw',
				'value'=>function($data){
					$awal = MyFormatter::formatDateTimeForUser($data->rencanadiklat_periode);
					$akhir = MyFormatter::formatDateTimeForUser($data->rencanadiklat_sampaidgn);
					
					$mAwal = date("m", strtotime($data->rencanadiklat_periode));					
					$mAkhir = date("m", strtotime($data->rencanadiklat_sampaidgn)); 
					
					$dAwal = date("d", strtotime($data->rencanadiklat_periode));					
					$dAkhir = date("d", strtotime($data->rencanadiklat_sampaidgn)); 
					
					if ($mAwal == $mAkhir){
						if ($dAwal ==  $dAkhir){
							return $akhir;
						}else{
							return date('d', strtotime($data->rencanadiklat_periode)).' - '.$akhir;
						}
					}else{
						return $awal.' - '.$akhir;
					}
				},				
            ),
            array(
                'header'=>'Waktu',				
				'value'=>function($data){
					$selisih = CustomFunction::hitungHari($data->jam_mulai, $data->jam_akhir);
					if ($selisih <= 0){
						return $data->total_jam.' jam';
					}else{
						return ($data->total_jam * $selisih).' jam';
					}
				},
            ),
            array(
                'header'=>'Jumlah Peserta',				
				'value'=> '"1"'				
            ),           
            array(
                'header'=>'Nama Peserta',
                'type'=>'raw',				
				'value'=>'$data->namaLengkap'
            ),
			array(
				'header' => 'Jabatan',
				'value'=>'$data->jabatan_nama'
			),
			array(
				'header' => 'Tempat',
				'value'=>'$data->tempat_diklat'
			),	
			array(
				'header' => 'Pelatihan',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->biaya_pelatihan,0,"",".")'
			),	
			array(
				'header' => 'Transportasi',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->biaya_transportasi,0,"",".")'
			),	
			array(
				'header' => 'Penginapan',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->biaya_penginapan,0,"",".")'
			),	
			array(
				'header' => 'Perjalanan Dinas',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->biaya_perjalanandinas,0,"",".")'
			),	
			array(
				'header' => 'Lain - Lain',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->biaya_lainlain,0,"",".")'
			),	
			array(
				'header' => 'Total Biaya',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->total_biaya,0,"",".")'
			),	
			array(
				'header' => 'Keterangan',
				'value'=>'$data->keterangan_diklat'
			),
			array(
				'header' => 'Status',
				'type' => 'raw',
				'value' => function ($data){
					
					if ($data->status_rencana == Params::STATUS_RENCANA_DIKLAT_RENCANA){
						$btn = 'btn btn-info nohover';
					}elseif ($data->status_rencana == Params::STATUS_RENCANA_DIKLAT_BATAL){
						$btn = 'btn btn-danger  nohover';
					}
					
					
					return CHtml::tag('span',array('class'=>$btn,),$data->status_rencana);
				}
			),
	),
					
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>