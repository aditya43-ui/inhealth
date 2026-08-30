<style>
	  
    @page {
        margin-top: 12mm;
    }
    
    @media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;            
			padding-bottom:1cm;  
			padding-left:0.5cm;			
            height:auto;
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
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
            $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
                'header'=>'Tgl. BKK/<br>No. BKK',
				'type' => 'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglkaskeluar)."/<br> ".$data->nokaskeluar',
            ),            
            array(
                'header'=>'Tgl. Jatuh Tempo',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
            ),
            array(
                'header'=>'Tgl. Faktur/<br>No Faktur',
				'type' => 'raw',
				'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur)))."/<br> ".$data->nofaktur',
            ),
			array(
				'header'=>'Supplier',
				'value'=>'$data->supplier_nama',
				'footer'=>'<b>Total</b>',
				'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;')
			),
			array(
				'header' => 'Jumlah Tagihan',
				'value'=>'number_format($data->totaltagihan,0,"",".")',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'name'=>'totaltagihan',
				'footer'=>'sum(totaltagihan)',
				'footerHtmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'header' => 'Jumlah Pembayaran',
				'value'=>'number_format($data->jmldibayarkan,0,"",".")',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'name'=>'jmldibayarkan',
				'footer'=>'sum(jmldibayarkan)',
				'footerHtmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'header' => 'Sisa Tagihan',
				'value'=>'number_format($data->sisahutang,0,"",".")',
				'name'=>'sisahutang',
				'footer'=>'sum(sisahutang)',
				'footerHtmlOptions'=>array('style'=>'text-align:right;'),
				'htmlOptions' => array('style' => 'text-align: right;'),
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
if ($caraPrint == 'PDF'){
?>
<div class="header">
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>

    <div class="content">
    <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
    <br>
    <?php 
        $itemCssClass='table table-bordered table-striped table-condensed';
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
                $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
                    'header'=>'Tgl. BKK/<br>No. BKK',
                    'type' => 'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglkaskeluar)."/<br> ".$data->nokaskeluar',
                ),            
                array(
                    'header'=>'Tgl. Jatuh Tempo',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
                ),
                array(
                    'header'=>'Tgl. Faktur/<br>No Faktur',
                    'type' => 'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur)))."/<br> ".$data->nofaktur',
                ),
                array(
                    'header'=>'Supplier',
                    'value'=>'$data->supplier_nama',
                    'footer'=>'<b>Total</b>',
                    'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;')
                ),
                array(
                    'header' => 'Jumlah Tagihan',
                    'value'=>'number_format($data->totaltagihan,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'name'=>'totaltagihan',
                    'footer'=>'sum(totaltagihan)',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header' => 'Jumlah Pembayaran',
                    'value'=>'number_format($data->jmldibayarkan,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'name'=>'jmldibayarkan',
                    'footer'=>'sum(jmldibayarkan)',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header' => 'Sisa Tagihan',
                    'value'=>'number_format($data->sisahutang,0,"",".")',
                    'name'=>'sisahutang',
                    'footer'=>'sum(sisahutang)',
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
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
