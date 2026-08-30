
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}


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
     width:20cm;
     height:12cm;
    }
');

//echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan));
}

$konfig = KonfigsystemK::model()->find();
$classHidden = true;
if (isset($konfig->tampilhargagu)) {
    if ($konfig->tampilhargagu == false) {
        $classHidden = false;
    }
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
                        $array = array(
                            array(
                                'header' => 'No.',
                                'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align:center;'),
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Tanggal Inventarisasi',
                                //'name'=>'invbarang_tgl',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->invbarang_tgl)',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'No. Inventarisasi',
                                //'name'=>'invbarang_no',
                                'type' => 'raw',
                                'value' => '$data->invbarang_no',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Tanggal Formulir',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'No. Formulir',
                                //'name'=>'forminvbarang_no',
                                'type' => 'raw',
                                'value' => '$data->forminvbarang_no',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            //				array (
                            //					'header'=>'Jenis Inventarisasi',
                            //					'name'=>'invbarang_jenis',
                            //					'type'=>'raw',
                            //					'value'=>'$data->invbarang_jenis'
                            //				),
                            array(
                                'header' => 'Total HPP (Rp)',
                                'type' => 'raw',
                                'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'MyFormatter::formatNumberForPrint($data->invbarang_totalnetto)' : '"Hidden"',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right; ',
                                ),
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Keterangan',
                                //'name'=>'invbarang_ket',
                                'type' => 'raw',
                                'value' => '$data->invbarang_ket',
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            )
                        );
                        $prov = $model->searchInformasi();
                        $prov->pagination = false;

                        $this->widget($grid_view, array(
                            'id' => 'infoinvbarang-grid',
                            'dataProvider' => $prov,
                            'template' => "{items}",
                            'itemsCssClass' => 'table table-bordered table-condensed',
                            'columns' => $array,
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
        $array = array(
            array(
                'header' => 'No.',
                'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:center;'),
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tanggal Inventarisasi',
                //'name'=>'invbarang_tgl',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->invbarang_tgl)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'No. Inventarisasi',
                //'name'=>'invbarang_no',
                'type' => 'raw',
                'value' => '$data->invbarang_no',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Tanggal Formulir',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'No. Formulir',
                //'name'=>'forminvbarang_no',
                'type' => 'raw',
                'value' => '$data->forminvbarang_no',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            //				array (
            //					'header'=>'Jenis Inventarisasi',
            //					'name'=>'invbarang_jenis',
            //					'type'=>'raw',
            //					'value'=>'$data->invbarang_jenis'
            //				),
            array(
                'header' => 'Total HPP (Rp)',
                'type' => 'raw',
                'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'MyFormatter::formatNumberForPrint($data->invbarang_totalnetto)' : '"Hidden"',
                'htmlOptions' => array(
                    'style' => 'text-align: right; ',
                ),
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Keterangan',
                //'name'=>'invbarang_ket',
                'type' => 'raw',
                'value' => '$data->invbarang_ket',
                'headerHtmlOptions' => array('style' => 'text-align:center;'),
            )
        );
        $prov = $model->searchInformasi();
        $prov->pagination = false;

        $this->widget($grid_view, array(
            'id' => 'infoinvbarang-grid',
            'dataProvider' => $prov,
            'template' => "{items}",
            'itemsCssClass' => 'table table-bordered table-condensed',
            'columns' => $array,
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

    <?php
}
if ($caraPrint == 'CSV') {


    $array = array(
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Tanggal Inventarisasi',
            //'name'=>'invbarang_tgl',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->invbarang_tgl)',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'No. Inventarisasi',
            //'name'=>'invbarang_no',
            'type' => 'raw',
            'value' => '$data->invbarang_no',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Tanggal Formulir',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->forminvbarang_tgl)',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'No. Formulir',
            //'name'=>'forminvbarang_no',
            'type' => 'raw',
            'value' => '$data->forminvbarang_no',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        //				array (
        //					'header'=>'Jenis Inventarisasi',
        //					'name'=>'invbarang_jenis',
        //					'type'=>'raw',
        //					'value'=>'$data->invbarang_jenis'
        //				),
        array(
            'header' => 'Total HPP (Rp)',
            'type' => 'raw',
            'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'MyFormatter::formatNumberForPrint($data->invbarang_totalnetto)' : '"Hidden"',
            'htmlOptions' => array(
                'style' => 'text-align: right; ',
            ),
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => 'Keterangan',
            //'name'=>'invbarang_ket',
            'type' => 'raw',
            'value' => '$data->invbarang_ket',
            'headerHtmlOptions' => array('style' => 'text-align:center;'),
        )
    );
    $prov = $model->searchInformasi();
    $prov->pagination = false;

    $this->widget($grid_view, array(
        'id' => 'infoinvbarang-grid',
        'dataProvider' => $prov,
        'template' => "{items}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => $array,
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
}
?>


