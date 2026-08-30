<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'PRINT'){
    
    
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
     $itemCssClass='table table-bordered table-striped table-condensed';
    // $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $mod = $model->searchLaporanPrint();
        $template = "{items}";
        $sort = false;
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
        $mod = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php 
$totalharga = 0;
$pajakppn = 0;
$pajakpph = 0;
$discount = 0;
$totalhargabruto = 0;
							
$prov = $model->searchLaporanPrint();
$cloneProv = clone $prov;

foreach ($cloneProv->data as $dataClone){
    $totalharga += $dataClone->totalharga;
    $pajakppn += $dataClone->pajakppn;
    $pajakpph += $dataClone->pajakpph;
    $discount += $dataClone->discount;
    $totalhargabruto += $dataClone->totalhargabruto;
}

$this->widget($table,array(
	'id'=>'laporan-grid',
	'dataProvider'=>$mod,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns' => array(
		array(
                    'header' => 'No.',
                    'headerHtmlOptions' => array('style' => 'text-align:left;'),
                    'value' => $row,
                    'footerHtmlOptions' => array('colspan'=>6,'style' => 'text-align:right;'),
                    'footer' =>' '
		),		
		array(
			'header' => 'Tgl. Faktur/<br> No Faktur',
			'type' => 'raw',
			'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))."/ <br>".$data->nopenerimaan',
		),      
		array(
                    'header' => 'Tgl. Jatuh Tempo',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
		),
		array(
                    'header' => 'Umur Utang',
                    'type' => 'raw',
                    'value' => '$data->umurHutang',
                    'footer' => '<b>Total Utang :</b>',	
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
		),		
		array(
                    'header' => 'Keterangan Faktur',
                    'type' => 'raw',
                    'value' => '$data->keterangan_persediaan',
		),
		array(
					'header'=>'Status Bayar',
					'type' => 'raw',
					'value' => function($data){
							if (empty($data->bayarkesupplier_id)){
								return Params::STATUSBAYAR_BELUM_LUNAS;
							}else{
								return Params::STATUSBAYAR_LUNAS;
							}
					}
				),
		array(
			'header' => 'Supplier',
			'value' => '$data->supplier_nama'
		),
                 array(
			'header' => 'Total Harga Bruto',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto,0,false,true)',
            'footer'=>MyFormatter::formatNumberForPrint($totalhargabruto,0,false,true),
			'footerHtmlOptions' => array('style' => 'text-align:right;'),
			'htmlOptions' => array('style'=>'text-align: right;'),
			'name'=>'totalhargabruto'
		),		
		array(
                    'header' => 'Total Keringanan',
                   'name' => 'discount',
                  //  'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->discount,0,false,true)',
                    // 'footer' => 'sum(discount)',
                    'footer'=>MyFormatter::formatNumberForPrint($discount,0,false,true),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
                    'header' => 'Total PPh',
                    'name' => 'pajakpph',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakpph,0,false,true)',
                    // 'footer' => 'sum(pajakpph)',
                    'footer'=>MyFormatter::formatNumberForPrint($pajakpph,0,false,true),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
                    'header' => 'Pajak PPN',
                    'name' => 'pajakppn',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakppn,0,false,true)',
                    // 'footer' => 'sum(pajakppn)',
                    'footer'=>MyFormatter::formatNumberForPrint($pajakppn,0,false,true),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align:right;')
		),
		array(
                    'header' => 'Total Harga Netto',
                    'name' => 'totalharga',                    
                    'value' => 'MyFormatter::formatNumberForPrint($data->totalharga,0,false,true)',
                    //'footer'=>"<b>Rp".number_format($model->getTotalharga(),0,"",".")."</b>",
                    //'footer'=>'sum(totalharga)',
                    'footer'=>MyFormatter::formatNumberForPrint($totalharga,0,false,true),
                    'footerHtmlOptions' => array('style' => 'text-align:right;'),
                    'htmlOptions' => array('style'=>'text-align: right;'),
					//''
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
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
if ($caraPrint == 'PDF' || $caraPrint == 'PRINT'){
?>
<div class="header">
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>

    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
        <br>
    <?php $this->renderPartial($this->path_view.'_tableBaru', array('model'=>$model, 'caraPrint'=>$caraPrint)); ?>
    </div>
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