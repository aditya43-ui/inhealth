<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    //$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchTableLaporanPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
      
		
		
        $itemsCssClass='table border';
		$row = '$row+1';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-striped table-condensed table-bordered';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
	'mergeHeaders'=>array(
		array(
			'name' => '<p style="margin: 0; text-align: center;">Keringanan</p>',
			'start' => '5',
			'end' => '6'
		),
		array(
			'name' => '<p style="margin: 0; text-align: center;">Surat Penagihan</p>',
			'start' => '7',
			'end' => '8'
		)
	),
    'columns'=>array( 
		array(
		    'header' => 'No.',
			'headerHtmlOptions'=>array('style'=>'text-align:left;'),
		    'value' => $row
		),
		array(
			'header' => 'Nama Pasien',			
			'value' => '$data->nama_pasien'
		),
		array(
			'header' => 'Tanggal Pengobatan',
			'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
		),
		array(
			'header' => 'Asuransi',
			'value' => '$data->penjamin_nama'
		),
		array(
			'header' => 'Jumlah Tagihan',
			'value' => 'number_format($data->jmlpiutang,0,"",".")',
			'htmlOptions' => array('style' => 'text-align: right;'),
		),
		array(
			'header' => 'RJ',
			'value' => 'number_format($data->diskon_rj,2,",","")."%"',
			'htmlOptions' => array('style' => 'text-align: right;'),
		),
		array(
			'header' => 'RI',
			'value' => 'number_format($data->diskon_ri,2,",","")."%"',
			'htmlOptions' => array('style' => 'text-align: right;'),
		),		
		array(
			'header' => 'Nomor',
			'value' => '$data->nopengajuanklaimanklaim',			
		),
		array(
			'header' => 'Tanggal',
			'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim)',
		),
		array(
			'header' => 'Lama Pembayaran',
			'value' => function($data){
				return CustomFunction::hitungHari($data->tgljatuhtempo, $data->tglpengajuanklaimanklaim).' Hari';
			}
		),
		array(
			'header' => 'Estimasi Pelunasan',
			'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
		)
		//array(
		//	'header' => ''
		//),
		/*array(
			'name'=>'tglpengajuanklaimanklaim',
			'headerHtmlOptions'=>array('style'=>'text-align:left;'),
			'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpengajuanklaimanklaim))',
		),
		array(
			'name'=>'nopengajuanklaimanklaim',
			'headerHtmlOptions'=>array('style'=>'text-align:left;'),
			'value'=>'$data->nopengajuanklaimanklaim',
		),
		array(
		    'header'=>'Total Pengajuan',
			'name'=>'totalpiutang',
			'headerHtmlOptions'=>array('style'=>'text-align:left;'),
			'value'=>'number_format($data->totalpiutang)',
		),*/
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 
<script>
    $('.integer').each(function(){
       formatNumber(); 
    });
</script>