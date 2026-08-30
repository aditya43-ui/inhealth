<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 4));
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
        border-radius: 0;
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

    //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan));
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
$prov->sort = false;
$prov->pagination = false;

?>
<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'CSV') {
?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                                        if ($caraPrint != 'EXCEL') {
                                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                        }

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
                            'id' => 'infoformulirinvbarang-grid',
                            'dataProvider' => $prov,
                            'template' => "{items}",
                            'itemsCssClass' => 'table table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'name' => 'forminvbarang_tgl',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
                                ),
                                array(
                                    'name' => 'forminvbarang_no',
                                ),
                                array(
                                    'header' => 'Total Volume',
                                    'value' => 'number_format($data->forminvbarang_totalvolume,0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Total Harga (Rp)',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->forminvbarang_totalharga,0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
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
            'id' => 'infoformulirinvbarang-grid',
            'dataProvider' => $prov,
            'template' => "{items}",
            'itemsCssClass' => 'table table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'name' => 'forminvbarang_tgl',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
                ),
                array(
                    'name' => 'forminvbarang_no',
                ),
                array(
                    'header' => 'Total Volume',
                    'value' => 'number_format($data->forminvbarang_totalvolume,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Total Harga (Rp)',
                    'type' => 'raw',
                    'value' => 'number_format($data->forminvbarang_totalharga,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
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
        'id' => 'infoformulirinvbarang-grid',
        'dataProvider' => $prov,
        'template' => "{items}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'forminvbarang_tgl',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
            ),
            array(
                'name' => 'forminvbarang_no',
            ),
            array(
                'header' => 'Total Volume',
                'value' => 'number_format($data->forminvbarang_totalvolume,0,"",".")',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'header' => 'Total Harga (Rp)',
                'type' => 'raw',
                'value' => 'number_format($data->forminvbarang_totalharga,0,"",".")',
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
}
?>