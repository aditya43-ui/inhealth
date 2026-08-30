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
                <?php  $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$itemCssClass='table table-striped table-condensed';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
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
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        /* array(
          'header'=>'No.',
          'value' => $row,
          'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
          ), */
        array(
            'header' => 'Tanggal Penerimaan',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterimabahan)))',
        ),
        array(
            'header' => 'No. Penerimaan',
            'value' => '$data->nopenerimaanbahan',
        ),
        array(
            'header' => 'Tanggal Faktur',
            'value' => 'isset($data->tglfaktur)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur))):""',
        ),
        array(
            'header' => 'No. Faktur',
            'value' => '$data->nofaktur'
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier_nama'
        ),
        array(
            'header' => 'Pegawai Penerima',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Bahan Makanan',
            'value' => '$data->namabahanmakanan',
        //'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold'),
        //'htmlOptions'=>array('style'=>'text-align:right;'),
        //'footer'=>'sum(hargasatuan)',
        ),
        array(
            'header' => 'Jml Terima',
            'value' => 'number_format($data->qty_terima,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Harga Netto',
            'value' => '(Params::cekHiddenHargaGizi()==true) ? number_format($data->harganettobhn,0,"",".") : "Hidden"',
            'htmlOptions' => array('style' => 'text-align: right;'),
        //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
        //'footer'=>'-',
        ),
        array(
            'header' => 'Subtotal',
            'value' => '(Params::cekHiddenHargaGizi()==true) ? number_format($data->totalharganetto,0,"","."):"Hidden"',
            'htmlOptions' => array('style' => 'text-align: right;'),
        //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
        //'footer'=>'-',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
<?php $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$itemCssClass='table table-striped table-condensed';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
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
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        /* array(
          'header'=>'No.',
          'value' => $row,
          'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
          ), */
        array(
            'header' => 'Tanggal Penerimaan',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterimabahan)))',
        ),
        array(
            'header' => 'No. Penerimaan',
            'value' => '$data->nopenerimaanbahan',
        ),
        array(
            'header' => 'Tanggal Faktur',
            'value' => 'isset($data->tglfaktur)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur))):""',
        ),
        array(
            'header' => 'No. Faktur',
            'value' => '$data->nofaktur'
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier_nama'
        ),
        array(
            'header' => 'Pegawai Penerima',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Bahan Makanan',
            'value' => '$data->namabahanmakanan',
        //'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold'),
        //'htmlOptions'=>array('style'=>'text-align:right;'),
        //'footer'=>'sum(hargasatuan)',
        ),
        array(
            'header' => 'Jml Terima',
            'value' => 'number_format($data->qty_terima,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Harga Netto',
            'value' => 'number_format($data->harganettobhn,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
        //'footer'=>'-',
        ),
        array(
            'header' => 'Subtotal',
            'value' => 'number_format($data->totalharganetto,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
        //'footer'=>'-',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
                        <?php  $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$itemCssClass='table table-striped table-condensed';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrint();
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
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        /* array(
          'header'=>'No.',
          'value' => $row,
          'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
          ), */
        array(
            'header' => 'Tanggal Penerimaan',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterimabahan)))',
        ),
        array(
            'header' => 'No. Penerimaan',
            'value' => '$data->nopenerimaanbahan',
        ),
        array(
            'header' => 'Tanggal Faktur',
            'value' => 'isset($data->tglfaktur)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglfaktur))):""',
        ),
        array(
            'header' => 'No. Faktur',
            'value' => '$data->nofaktur'
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier_nama'
        ),
        array(
            'header' => 'Pegawai Penerima',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Bahan Makanan',
            'value' => '$data->namabahanmakanan',
        //'footerHtmlOptions'=>array('style'=>'text-align:right;font-weight:bold'),
        //'htmlOptions'=>array('style'=>'text-align:right;'),
        //'footer'=>'sum(hargasatuan)',
        ),
        array(
            'header' => 'Jml Terima',
            'value' => 'number_format($data->qty_terima,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Harga Netto',
            'value' => 'number_format($data->harganettobhn,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
        //'footer'=>'-',
        ),
        array(
            'header' => 'Subtotal',
            'value' => 'number_format($data->totalharganetto,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        //'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
        //'footer'=>'-',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
?>