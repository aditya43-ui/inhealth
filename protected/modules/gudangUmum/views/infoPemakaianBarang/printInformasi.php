
<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
       
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-' . date("Y/m/d") . '.xls"');
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

   
}

$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'CSV') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                      <div class="header"><?php
                        if($caraPrint != 'EXCEL'){
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
                        }else{
                            
                           echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 6));
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
                        
                        $prov = $model->search();
$prov->pagination = false;
$prov->sort = false;

$this->widget($grid_view, array(
    'id' => 'informasipemakaianbarang-grid',
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
            'name' => 'instalasi_nama',
            'type' => 'raw',
            'value' => '$data->instalasi_nama',
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'name' => 'tglpemakaianbrg',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianbrg)',
        ),
        array(
            'name' => 'nopemakaianbrg',
            'type' => 'raw',
            'value' => '$data->nopemakaianbrg',
        ),
        array(
            'name' => 'untukkeperluan',
            'type' => 'raw',
            'value' => '$data->untukkeperluan',
        ),
        array(
            'name' => 'keteranganpakai',
            'type' => 'raw',
            'value' => '$data->keteranganpakai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));?>
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
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewest'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan ?> <br> <?php echo $periode ?></div>
        <br>
        <?php
        
        $prov = $model->search();
$prov->pagination = false;
$prov->sort = false;

$this->widget($grid_view, array(
    'id' => 'informasipemakaianbarang-grid',
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
            'name' => 'instalasi_nama',
            'type' => 'raw',
            'value' => '$data->instalasi_nama',
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'name' => 'tglpemakaianbrg',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianbrg)',
        ),
        array(
            'name' => 'nopemakaianbrg',
            'type' => 'raw',
            'value' => '$data->nopemakaianbrg',
        ),
        array(
            'name' => 'untukkeperluan',
            'type' => 'raw',
            'value' => '$data->untukkeperluan',
        ),
        array(
            'name' => 'keteranganpakai',
            'type' => 'raw',
            'value' => '$data->keteranganpakai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
        
        ?>
    </div>

    <?php
}
if ($caraPrint == 'CSV') {

$prov = $model->search();
$prov->pagination = false;
$prov->sort = false;

$this->widget($grid_view, array(
    'id' => 'informasipemakaianbarang-grid',
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
            'name' => 'instalasi_nama',
            'type' => 'raw',
            'value' => '$data->instalasi_nama',
        ),
        array(
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'name' => 'tglpemakaianbrg',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianbrg)',
        ),
        array(
            'name' => 'nopemakaianbrg',
            'type' => 'raw',
            'value' => '$data->nopemakaianbrg',
        ),
        array(
            'name' => 'untukkeperluan',
            'type' => 'raw',
            'value' => '$data->untukkeperluan',
        ),
        array(
            'name' => 'keteranganpakai',
            'type' => 'raw',
            'value' => '$data->keteranganpakai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
}
?>