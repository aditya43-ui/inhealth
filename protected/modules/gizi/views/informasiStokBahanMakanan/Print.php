<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerPrint', array('judulLaporan' => "Informasi Stok Barang", 'colspan' => 10, 'caraPrint' => $caraPrint));

$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
$row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
$itemCss = 'table table-striped table-bordered table-condensed';

if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchInformasiPrint();
    $template = "{items}";
    $sort = false;
    
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else if ($caraPrint == "PDF") {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        $itemCss = 'table border';
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    
} else {
    $data = $model->searchInformasiPrint();
    $template = "{summary}\n{items}\n{pager}";
}

?>
<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table width="100%">
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
			<div class="judulcontent"> <?php echo $judulLaporan; ?> </div>
                        <br>
                <?php  


$this->widget($table, array(
    'id' => 'informasistokbhnmkn-grid',
    'dataProvider' => $data,
    'itemsCssClass' => $itemCss,
    'template' => $template,                      
    'mergeHeaders'=>array(
        array(
            'name'=>'<center>Kondisi Bahan Makanan</center>',
            'start'=>5, 
            'end'=>6, 
        ),
    ),
    'columns'=>array(
        array(
                   'header' => 'No.',
                   'type'=>'raw',
                   'value' => '$row+1',
        ),
        array(
                'header' => 'Kelompok Bahan Makanan',
                'type'=>'raw',
                'value' => '$data->kelbahanmakanan',
        ),
        array(
            'header' => 'Nama Bahan Makanan',
            'type'=>'raw',
            'value' => '$data->namabahanmakanan',
        ),
        array(
            'header' => 'Minimal Stok',
            'type'=>'raw',
            'value' => '$data->jmlminimal',
        ),
         array(
            'header' => 'Tanggal Kadaluarsa',
            'type'=>'raw',
            'value' => '(!empty($data->tglkadaluarsabahan)? MyFormatter::formatDateTimeForUser($data->tglkadaluarsabahan): "")',
        ),
         array(
            'header' => 'Baik',
            'type'=>'raw',
            'value' => '(round($data->qtystok_baik * 100) / 100)." ".$data->satuanbahan',
        ),
         array(
            'header' => 'Rusak',
            'type'=>'raw',
            'value' => '(round($data->qtystok_rusak * 100) / 100)." ".$data->satuanbahan',
        ),
        array(
            'header' => 'Jumlah Bahan Makanan',
            'type'=>'raw',
            'value' => '(round($data->qtystok * 100) / 100)." ".$data->satuanbahan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));     ?>
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
    <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
     <br>
<?php 

$this->widget($table, array(
    'id' => 'informasistokbarang-grid',
    'dataProvider' => $data,
    'itemsCssClass' => $itemCss,
    'template' => $template,   
    'mergeHeaders'=>array(
        array(
            'name'=>'<center>Kondisi Bahan Makanan</center>',
            'start'=>5, 
            'end'=>6, 
        ),
    ),
    'columns'=>array(
        array(
                   'header' => 'No.',
                   'type'=>'raw',
                   'value' => '$row+1',
        ),
        array(
                'header' => 'Kelompok Bahan Makanan',
                'type'=>'raw',
                'value' => '$data->kelbahanmakanan',
        ),
        array(
            'header' => 'Nama Bahan Makanan',
            'type'=>'raw',
            'value' => '$data->namabahanmakanan',
        ),
        array(
            'header' => 'Minimal Stok',
            'type'=>'raw',
            'value' => '$data->jmlminimal',
        ),
         array(
            'header' => 'Tanggal Kadaluarsa',
            'type'=>'raw',
            'value' => '(!empty($data->tglkadaluarsabahan)? MyFormatter::formatDateTimeForUser($data->tglkadaluarsabahan): "")',
        ),
         array(
            'header' => 'Baik',
            'type'=>'raw',
            'value' => '$data->qtystok_baik." ".$data->satuanbahan',
        ),
         array(
            'header' => 'Rusak',
            'type'=>'raw',
            'value' => '$data->qtystok_rusak." ".$data->satuanbahan',
        ),
        array(
            'header' => 'Jumlah Bahan Makanan',
            'type'=>'raw',
            'value' => '$data->qtystok." ".$data->satuanbahan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));    ?>
</div>

<?php
}

 ?>