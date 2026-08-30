
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
        font-size:8pt;
    }
    body{
        font-size:8pt;
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
     width:20cm;
     height:12cm;
    }
');

   // echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan));
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
                                'id' => 'rencana-m-grid',
                                'dataProvider' => $prov,
                                'template' => "{items}",
                                'itemsCssClass' => 'table table-bordered table-condensed',
                                'columns' => array(
                                    array(
                                        'name' => 'renkebbarang_tgl',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                                    ),
                                    'renkebbarang_no',
                                    array(
                                        'name' => 'ro_barang_bulan',
                                        'value' => '$data->ro_barang_bulan',
                                        'htmlOptions' => array('style' => 'text-align:right;')
                                    ),
                                    array(
                                        'header' => 'Sumber Dana',
                                        'type'=>'raw',
                                        'value' => '$data->sumberdana_nama',
                                    ),
                                    array(
                                        'header' => 'Pegawai Mengetahui',
                                        'type' => 'raw',
                                        'value' => 'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
                                    ),
                                    array(
                                        'header' => 'Pegawai Menyetujui',
                                        'type' => 'raw',
                                        'value' => 'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
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
                                'id' => 'rencana-m-grid',
                                'dataProvider' => $prov,
                                'template' => "{items}",
                                'itemsCssClass' => 'table table-bordered table-condensed',
                                'columns' => array(
                                    array(
                                        'name' => 'renkebbarang_tgl',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                                    ),
                                    'renkebbarang_no',
                                    array(
                                        'name' => 'ro_barang_bulan',
                                        'value' => '$data->ro_barang_bulan',
                                        'htmlOptions' => array('style' => 'text-align:right;')
                                    ),
                                    array(
                                        'header' => 'Sumber Dana',
                                        'type'=>'raw',
                                        'value' => '$data->sumberdana_nama',
                                    ),
                                    array(
                                        'header' => 'Pegawai Mengetahui',
                                        'type' => 'raw',
                                        'value' => 'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
                                    ),
                                    array(
                                        'header' => 'Pegawai Menyetujui',
                                        'type' => 'raw',
                                        'value' => 'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
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
                                'id' => 'rencana-m-grid',
                                'dataProvider' => $prov,
                                'template' => "{items}",
                                'itemsCssClass' => 'table table-bordered table-condensed',
                                'columns' => array(
                                    array(
                                        'name' => 'renkebbarang_tgl',
                                        'type' => 'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                                    ),
                                    'renkebbarang_no',
                                    array(
                                        'name' => 'ro_barang_bulan',
                                        'value' => '$data->ro_barang_bulan',
                                        'htmlOptions' => array('style' => 'text-align:right;')
                                    ),
                                    array(
                                        'header' => 'Sumber Dana',
                                        'type'=>'raw',
                                        'value' => '$data->sumberdana_nama',
                                    ),
                                    array(
                                        'header' => 'Pegawai Mengetahui',
                                        'type' => 'raw',
                                        'value' => 'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
                                    ),
                                    array(
                                        'header' => 'Pegawai Menyetujui',
                                        'type' => 'raw',
                                        'value' => 'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            ));
                  
    
}
?>
