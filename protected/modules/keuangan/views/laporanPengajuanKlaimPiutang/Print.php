<style>
	 @page {
        margin-top: 12mm;
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
			width:100%;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;
            padding-left: 1mm;
            height:auto;
			width:100%;
        }
    }
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
                        <br>
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
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
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
</div>

<?php
}
if ($caraPrint == 'GRAFIK'){
 ?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?> </div>
                        <br>
                        <?php
    $this->Widget('ext.jQPlot.jQPlotWidget', array(
        'dataProvider' => $model->searchGrafik(),
        'id'=>'tes',
        'type' => $data['type'],
        'options' => array(
            'title' => $data['title'],
            'seriesDefaults'=>array(
                    'renderer'=>'js:$.jqplot.BarRenderer',
                    'dataLabels'=>'value',
                    'barDirection'=>'vertical',
                    'rendererOptions'=>array(
                        'fillToZero'=>true,
                        'barPadding'=>8,
                        'barMargin'=>10,
                        'barWidth'=>50,
                        'barHeight'=>100,
                        'padding'=>20,
                        'sliceMargin'=>5,
                        ),
                    'pointLabels'=>array( 'show'=> true ),
                    ),
            'animate'=>true,
            'axes'=>array(
                'xaxis'=>array(
                    'renderer'=> 'js:$.jqplot.CategoryAxisRenderer',
                    'width'=>10,
                    'ticks'=>true,
                    'tickOptions'=>array(
                        'mark'=>'inside',
                        'showLabel'=>true,
                    ),
                ),
                'yaxis'=> array(
                    'labelRenderer'=>'js:$.jqplot.CanvasAxisLabelRenderer',
                )
            ),
          ),
       )
    );
    ?>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
  
<?php
}
?>