<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
// echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

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
//    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        echo "<style>            
					.table{
						border-collapse: collapse;
					}

                    .table thead:first-child{
                        border-top:1px solid #000;        
                    }

                    thead th{
                        background:none;
                        color:#333;
                        border:1px solid #333;
                    }
                    
                    .a tbody td{
                        border:1px solid #333;
                    }
                    
                    .a{
                        box-shadow:none;
                    }

                    .table tbody tr:hover td, .table tbody tr:hover th {
                        background-color: none;                        
                    }
            </style>";
        $itemsCssClass='table a';
		$row = '$row+1';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-bordered datatable';
    }
    
    $totharganetto = 0;
    $jmldiscount = 0;
    $totalpajakpph = 0;
    $totalpajakppn = 0;
    $totalhargabruto = 0;
                                
    $prov = $model->searchPrint();
    $cloneProv = clone $prov;

    foreach ($cloneProv->data as $dataClone){
        $totharganetto += $dataClone->totharganetto;
        $jmldiscount += $dataClone->jmldiscount;
        $totalpajakpph += $dataClone->totalpajakpph;
        $totalpajakppn += $dataClone->totalpajakppn;
        $totalhargabruto += $dataClone->totalhargabruto;
    }

    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
	'enableSorting'=>$sort,
    'columns'=>array( 
	    array(
		'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
				'value' => $row
	    ),
		array(
                    'header'=>'Tanggal Faktur/ <br> No Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'type' => 'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)."/<br>".$data->nofaktur ',
                ),
				array(
                    'header'=>'Tgl. Jatuh Tempo',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
                ),
				array(
					'header' => 'Umur Utang',
					'value' => '$data->UmurHutang',
				),                                
                array(
                    'header'=>'Keterangan Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => '$data->keteranganfaktur',
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
                    'header'=>'Supplier',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'$data->supplier->supplier_nama',
                    'footer'=>'<b>Total</b>',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>7)
                ),
//                'totharganetto',
                array(
                    'header'=>'Total Harga Netto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => 'MyFormatter::formatNumberForPrint($data->totharganetto,0,false,true)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totharganetto',
                    // 'footer'=>'sum(totharganetto)',
                    'footer'=>MyFormatter::formatNumberForPrint($totharganetto,0,false,true),
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
//                'jmldiscount',
                array(
                    'header'=>'Total Keringanan',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => 'MyFormatter::formatNumberForPrint($data->jmldiscount,0,false,true)',
                    'htmlOptions' => array('style'=>'text-align:right'),
                    'name'=>'jmldiscount',
                    'footer'=>MyFormatter::formatNumberForPrint($jmldiscount,0,false,true),
					// 'footer'=>'sum(jmldiscount)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
//                'biayamaterai',
//                'totalpajakpph',
					array(
                    'header'=>'Total PPh',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakpph,0,false,true)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totalpajakpph',
                    // 'footer'=>'sum(totalpajakpph)',
                    'footer'=>MyFormatter::formatNumberForPrint($totalpajakpph,0,false,true),
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
					array(
                    'header'=>'Total PPN',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => 'MyFormatter::formatNumberForPrint($data->totalpajakppn,0,false,true)',
                    'htmlOptions' => array('style'=>'text-align:right'),
                    'name'=>'totalpajakppn',
                    'footer'=>MyFormatter::formatNumberForPrint($totalpajakppn,0,false,true),
					// 'footer'=>'sum(totalpajakppn)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
                
//                'totalpajakppn',
                
//                'totalhargabruto', 
                array(
                    'header'=>'Total Harga Bruto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => 'MyFormatter::formatNumberForPrint($data->totalhargabruto,0,false,true)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totalhargabruto',
                    // 'footer'=>'sum(totalhargabruto)',
                    'footer'=>MyFormatter::formatNumberForPrint($totalhargabruto,0,false,true),
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
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
if ($caraPrint == 'PDF' || $caraPrint == 'PRINT'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
<?php
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "PDF"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        echo "<style>            
					.table{
						border-collapse: collapse;
					}

                    .table thead:first-child{
                        border-top:1px solid #000;        
                    }

                    thead th{
                        background:none;
                        color:#333;
                        border:1px solid #333;
                    }
                    
                    .a tbody td{
                        border:1px solid #333;
                    }
                    
                    .a{
                        box-shadow:none;
                    }

                    .table tbody tr:hover td, .table tbody tr:hover th {
                        background-color: none;                        
                    }
            </style>";
        $itemsCssClass='table a';
		$row = '$row+1';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-bordered datatable';
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
	'enableSorting'=>$sort,
    'columns'=>array( 
	    array(
		'header' => 'No.',
                'headerHtmlOptions'=>array('style'=>'text-align:left;'),
				'value' => $row
	    ),
		array(
                    'header'=>'Tanggal Faktur/ <br> No Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'type' => 'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)."/<br>".$data->nofaktur ',
                ),
				array(
                    'header'=>'Tgl. Jatuh Tempo',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
                ),
				array(
					'header' => 'Umur Utang',
					'value' => '$data->UmurHutang',
				),                                
                array(
                    'header'=>'Keterangan Faktur',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value' => '$data->keteranganfaktur',
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
                    'header'=>'Supplier',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'$data->supplier->supplier_nama',
					'footer'=>'<b>Total</b>',
					'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>7)
                ),
//                'totharganetto',
                array(
                    'header'=>'Total Harga Netto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totharganetto)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totharganetto',
					'footer'=>'sum(totharganetto)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
//                'jmldiscount',
                array(
                    'header'=>'Total Keringanan',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->jmldiscount)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'jmldiscount',
					'footer'=>'sum(jmldiscount)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
//                'biayamaterai',
//                'totalpajakpph',
					array(
                    'header'=>'Total PPh',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalpajakpph)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totalpajakpph',
					'footer'=>'sum(totalpajakpph)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
					array(
                    'header'=>'Total PPN',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalpajakppn)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totalpajakppn',
					'footer'=>'sum(totalpajakppn)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
                
//                'totalpajakppn',
                
//                'totalhargabruto', 
                array(
                    'header'=>'Total Harga Bruto',
                    'type'=>'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align:left;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalhargabruto)',
                    'htmlOptions' => array('style'=>'text-align:right'),
					'name'=>'totalhargabruto',
					'footer'=>'sum(totalhargabruto)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;')
                ),
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?>
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
                        <?php     $this->Widget('ext.jQPlot.jQPlotWidget', array(
    'dataProvider' => $model->searchGrafik(),
    'id' => 'grafik',
    'type' => $data['type'],

    'options' => array(
        'title' => $data['title'],
        'seriesDefaults' => array(
            'renderer' => 'js:$.jqplot.BarRenderer',
            'dataLabels' => 'value',
            'barDirection' => 'vertical',
            'rendererOptions' => array(
                'fillToZero' => true,
                'barPadding' => 8,
                'barMargin' => 10,
                'barWidth' => 50,
//                'barHeight' => 100,
//                'padding' => 20,
//                'sliceMargin' => 5, 
            ),
            'pointLabels' => array('show' => true),
        ),
        'animate' => true,
        'axesDefaults' => array(
            'tickRenderer' => 'js:$.jqplot.CanvasAxisTickRenderer',
            'tickOptions' => array(
                'angle' => -30,
                'fontSize' => '10pt'
            ),
        ),
        'axes' => array(
            'xaxis' => array(
                'renderer' => 'js:$.jqplot.CategoryAxisRenderer',
                'width' => 10,
                'ticks' => true,
                'tickOptions' => array(
                    'mark' => 'inside',
                    'showLabel' => true,
                ),
            ),
            'yaxis' => array(
                'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
                'min'=>0,
            )
        ),
    ),
    'htmlOptions'=>array(
            'style'=>' width:100%',
    )
        )
); ?>
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