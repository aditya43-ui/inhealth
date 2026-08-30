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
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasi();
        $data->pagination = false;
        $data->criteria->limit = -1;
        $template = "{items}";
        $sort = false;
       if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
    } else{
        $data = $model->searchInformasi();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-bordered datatable';
    }
    
    $total = 0;
    $prov = $model->searchInformasi();
    $prov->pagination = false;
    $prov->criteria->limit = -1;
    
    foreach ($prov->data as $item) {
        $total += $item->totalharga;
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'columns'=>array( 
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>'Total Pengeluaran',
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                        'colspan'=>8,
                    ),
                    'value' => $data->pagination ? '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1' : '$row+1',
                ),
                array(
                    'name'=>'tglpengeluaran',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpengeluaran))',
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'nopengeluaran',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'jenispengeluaran.jenispengeluaran_nama',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'kelompoktransaksi',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'volume',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'name'=>'satuanvol',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array('name'=>'hargasatuan',
                    'header'=>'Harga Satuan',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->hargasatuan)',
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array('name'=>'totalharga',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalharga)',
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($total),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                    ),
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
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
<?php 
//    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasi();
        $data->pagination = false;
        $data->criteria->limit = -1;
        $template = "{items}";
        $sort = false;
       if ($caraPrint == "PDF")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
    } else{
        $data = $model->searchInformasi();
         $template = "{summary}\n{items}\n{pager}";
         $itemsCssClass='table table-bordered datatable';
    }
    
    $total = 0;
    $prov = $model->searchInformasi();
    $prov->pagination = false;
    $prov->criteria->limit = -1;
    
    foreach ($prov->data as $item) {
        $total += $item->totalharga;
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'columns'=>array( 
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>'Total Pengeluaran',
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                        'colspan'=>8,
                    ),
                    'value' => $data->pagination ? '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1' : '$row+1',
                ),
                array(
                    'header' => 'Tgl. Pengeluaran',
                    //'name'=>'tglpengeluaran',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpengeluaran))',
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'header' => 'No. Pengeluaran',
                    // 'name'=>'nopengeluaran',
                    'value'=>'$data->nopengeluaran',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'header' => 'Jenis Pengeluaran',
                    'name'=>'jenispengeluaran.jenispengeluaran_nama',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'header' => 'Kelompok Transaksi',
                    // 'name'=>'kelompoktransaksi',
                    'value'=>'$data->kelompoktransaksi',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'header' => 'Volume',
                    // 'name'=>'volume',
                    'value'=>'$data->volume',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'header' => 'Satuan Vol',
                    // 'name'=>'satuanvol',
                    'value'=>'$data->satuanvol',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    // 'name'=>'hargasatuan',
                    'header'=>'Harga Satuan',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->hargasatuan)',
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>false,
                    'footerHtmlOptions'=>array(
                        'hidden'=>true,
                    ),
                ),
                array(
                    'header' => 'Total Harga',
                    // 'name'=>'totalharga',
                    'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalharga)',
					'htmlOptions' => array('style' => 'text-align: right;'),
                    'footer'=>MyFormatter::formatNumberForPrint($total),
                    'footerHtmlOptions'=>array(
                        'style'=>'text-align: right; font-weight: bold;',
                    ),
                ),
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
