
<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php

if (!empty($caraPrint) && $caraPrint != 'CSV') {

    echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
//        font-size:8pt;
    }
    body{
//        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    
    .table{
        box-shadow:none;
        border: 1px solid black;
        border-radius: 0px;
    }
    
    .table-bordered {
        border-collapse: collapse;
    }
        
    .table th, .table td {
        border: 1px solid black;
        color: black !important;    
    }
    
    .table-bordered th + th {
        border-left: none;
    }
    
    .table-bordered td + td {
        border-left: none;
    }

    .kertas{
//     width:20cm;
//     height:12cm;
    }
');

    
}

$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}


$prov = $model->searchInformasi();
$prov->pagination = false;
$prov->sort = false;

?>

<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'CSV') {
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
                        <div class="judulcontent"> <?php echo $judulLaporan ?> <br> <?php echo $periode ?></div>
                        <br>
                        <?php
        
$this->widget($grid_view, array(
    'id' => 'guterimapersediaan-t-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
       
        array(
            'header' => 'Tanggal Terima',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)'
        ),
        array(
            'header' => 'No Penerimaan',
            'value' => '$data->nopenerimaan',
        ),
        array(
            'header' => 'Tgl Permintaan / <br> No Permintaan',
            'value' => function($data) {
                $tgl = !empty($data->pembelianbarang_id) ? MyFormatter::formatDateTimeForUser($data->pembelianbarang->tglpembelian) : '';
                $no = !empty($data->pembelianbarang_id) ? $data->pembelianbarang->nopembelian : '';

                echo $tgl . ' / <br>' . $no;
            },
        ),
        array(
            'header' => 'Pegawai Penerima',
            'value' => 'isset($data->peg_penerima_id)?$data->penerima->namaLengkap:"-"',
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'value' => 'isset($data->peg_mengetahui_id)?$data->mengetahui->namaLengkap:"-"',
        ),
        array(
            'header' => 'Supplier',
            'value' => '!empty($data->supplier_id)?$data->supplier->supplier_nama:"-"'
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan ?> <br> <?php echo $periode ?></div>
        <br>
        <?php
        
$this->widget($grid_view, array(
    'id' => 'guterimapersediaan-t-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
       
        array(
            'header' => 'Tanggal Terima',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)'
        ),
        array(
            'header' => 'No Penerimaan',
            'value' => '$data->nopenerimaan',
        ),
        array(
            'header' => 'Tgl Permintaan / <br> No Permintaan',
            'value' => function($data) {
                $tgl = !empty($data->pembelianbarang_id) ? MyFormatter::formatDateTimeForUser($data->pembelianbarang->tglpembelian) : '';
                $no = !empty($data->pembelianbarang_id) ? $data->pembelianbarang->nopembelian : '';

                echo $tgl . ' / <br>' . $no;
            },
        ),
        array(
            'header' => 'Pegawai Penerima',
            'value' => 'isset($data->peg_penerima_id)?$data->penerima->namaLengkap:"-"',
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'value' => 'isset($data->peg_mengetahui_id)?$data->mengetahui->namaLengkap:"-"',
        ),
        array(
            'header' => 'Supplier',
            'value' => '!empty($data->supplier_id)?$data->supplier->supplier_nama:"-"'
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
        
        
        ?>
    </div>

    <?php
}
if ($caraPrint == 'CSV') {


$this->widget($grid_view, array(
    'id' => 'guterimapersediaan-t-grid',
    'dataProvider' => $prov,
    //	'filter'=>$model,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        ////'terimapersediaan_id',
        //		array(
        //                        'name'=>'terimapersediaan_id',
        //                        'value'=>'$data->terimapersediaan_id',
        //                        'filter'=>false,
        //                ),
        array(
            'header' => 'Tanggal Terima',
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglterima))))'
        ),
        array(
            'header' => 'No Penerimaan',
            'value' => '$data->nopenerimaan',
        ),
        array(
            'header' => 'Tgl Permintaan / <br> No Permintaan',
            'value' => function($data) {
                $tgl = !empty($data->pembelianbarang_id) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->pembelianbarang->tglpembelian))) : '';
                $no = !empty($data->pembelianbarang_id) ? $data->pembelianbarang->nopembelian : '';

                echo $tgl . ' / <br>' . $no;
            },
        ),
        array(
            'header' => 'Pegawai Penerima',
            'value' => 'isset($data->peg_penerima_id)?$data->penerima->namaLengkap:"-"',
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'value' => 'isset($data->peg_mengetahui_id)?$data->mengetahui->namaLengkap:"-"',
        ),
        array(
            'header' => 'Supplier',
            'value' => '!empty($data->supplier_id)?$data->supplier->supplier_nama:"-"'
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
}
?>