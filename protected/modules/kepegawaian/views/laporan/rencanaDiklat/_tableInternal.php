<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        $data = $modInternal->searchPrint();
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
        $data = $modInternal->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporanInternal',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCssClass,
	'mergeHeaders'=>array(
				array(
					'name'=>'<p style="margin: 0; text-align: center;">Biaya</p>',
					'start'=>'9',
					'end'=>'12',
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
					
					return $data->jam_mulai.' - '.$data->jam_akhir;
				},
            ),
            array(
                'header'=>'Jumlah Waktu Pelatihan',				
				'value'=> function($data){
					$selisih = CustomFunction::hitungHari($data->rencanadiklat_sampaidgn, $data->rencanadiklat_periode);
					if ($selisih <= 0){
						return $data->total_jam.' jam';
					}else{
						return ($data->total_jam * $selisih).' jam';
					}
				}		
            ),           
            array(
                'header'=>'Nama Peserta',
                'type'=>'raw',				
				'value'=> function ($data){
					$peg = RencanadiklatdetT::model()->findAll(" rencanadiklat_id = '".$data->rencanadiklat_id."' ");
					
					$dt = "<ul>";
					foreach ($peg as $det){
						$dt .= "<li>".$det->pegawai->namaLengkap." (".((!empty($det->pegawai->jabatan_id)?$det->pegawai->jabatan->jabatan_nama:'-')).")</li>";
					}
					$dt .="</ul>";
					
					return $dt;
				}
            ),			
			array(
				'header' => 'Tempat',
				'value' => '$data->tempat_diklat'
			),
			array(
				'header' => 'Pemateri',
				'value' => function ($data){
					$ren = KPRencanadiklatT::model()->findByPk($data->rencanadiklat_id);
					
					return $ren->pemateri;
				}
			),
            array(
				'header' => 'Pemateri',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->internal_biayapemateri,0,"",".")'
			),	    			
			array(
				'header' => 'Konsumsi',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->internal_biayakonsumsi,0,"",".")'
			),
			array(
				'header' => 'Alat Peraga',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->internal_biayaalatperaga,0,"",".")'
			),
			array(
				'header' => 'Lain - Lain',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'value'=>'number_format($data->internal_biayalainlain,0,"",".")'
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