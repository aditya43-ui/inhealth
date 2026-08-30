<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {


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
                        <?php $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
                        $sort = true;
                        $itemsCssClass = 'table table-striped table-condensed';
                        $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
                        if (isset($caraPrint)) {
                            $row = '$row+1';
                            $data = $model->searchPrint();
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
                            $itemsCssClass = 'table border';
                            $template = "{items}";
                            $sort = false;
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
                            'itemsCssClass' => $itemsCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => $row,
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->no_rekam_medik',
                                ),
                                array(
                                    'header' => 'Nama Lengkap',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->nama_pasien',
                                ),
                                array(
                                    'header' => 'No. Pendaftaran',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->no_pendaftaran',
                                ),
                                array(
                                    'header' => 'Jenis',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->jenisdiet_nama'
                                ),
                                array(
                                    'header' => 'Jenis Diet',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->menudiet_nama'
                                ),
                                //                array(
                                //                    'header' => 'No. Gizi',
                                //                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                                //                    'value' => '$data->no_masukpenunjang',
                                //                ),
                                array(
                                    'header' => 'Jumlah',
                                    'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => 'number_format($data->jml_kirim,0,"",".")',
                                    //'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-weight:bold'),
                                    //'footer' => 'Total',
                                ),
                                /*
        array(
            'header' => 'Harga (Rp)',
            'name' => 'hargasatuan',
            'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
            'value' => 'number_format($data->hargasatuan,0,"",".")',
            'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold'),
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(hargasatuan)',
        ),
         * 
         */
                                array(
                                    'header' => 'Ruangan',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->ruangan_nama',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Kelas',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->kelaspelayanan_nama',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Tanggal Transaksi',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Tanggal Pemberian',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Jam Pemberian',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                    'value' => '$data->jeniswaktu_jam',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                //                array(
                                //                    'header' => 'Hari',
                                //                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                                //                    'value' => 'date("l,strtotime($data->tglkirimmenu")',
                                //                ),
                                array(
                                    'header' => 'Waktu',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                    'value' => '$data->jeniswaktu_nama',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {  ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php  }  ?>
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
        <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
        <br>
        <?php $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
        $sort = true;
        $itemsCssClass = 'table table-striped table-condensed';
        $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
        if (isset($caraPrint)) {
            $row = '$row+1';
            $data = $model->searchPrint();
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
            $itemsCssClass = 'table border';
            $template = "{items}";
            $sort = false;
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
            'itemsCssClass' => $itemsCssClass,
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => $row,
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'Nama Lengkap',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->nama_pasien',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'Jenis',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->jenisdiet_nama'
                ),
                array(
                    'header' => 'Jenis Diet',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->menudiet_nama'
                ),
                //                array(
                //                    'header' => 'No. Gizi',
                //                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                //                    'value' => '$data->no_masukpenunjang',
                //                ),
                array(
                    'header' => 'Jumlah',
                    'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'value' => 'number_format($data->jml_kirim,0,"",".")',
                    //'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-weight:bold'),
                    //'footer' => 'Total',
                ),
                /*
        array(
            'header' => 'Harga (Rp)',
            'name' => 'hargasatuan',
            'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
            'value' => 'number_format($data->hargasatuan,0,"",".")',
            'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold'),
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(hargasatuan)',
        ),
         * 
         */
                array(
                    'header' => 'Ruangan',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->ruangan_nama',
                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    //'footer' => '-',
                ),
                array(
                    'header' => 'Kelas',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => '$data->kelaspelayanan_nama',
                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    //'footer' => '-',
                ),
                array(
                    'header' => 'Tanggal Transaksi',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    //'footer' => '-',
                ),
                array(
                    'header' => 'Tanggal Pemberian',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    //'footer' => '-',
                ),
                array(
                    'header' => 'Jam Pemberian',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'value' => '$data->jeniswaktu_jam',
                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    //'footer' => '-',
                ),
                //                array(
                //                    'header' => 'Hari',
                //                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                //                    'value' => 'date("l,strtotime($data->tglkirimmenu")',
                //                ),
                array(
                    'header' => 'Waktu',
                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'value' => '$data->jeniswaktu_nama',
                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                    //'footer' => '-',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>

<?php
}
if ($caraPrint == 'GRAFIK') {
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
                        <?php $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
                        $sort = true;
                        $itemsCssClass = 'table table-striped table-condensed';
                        $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
                        if (isset($caraPrint)) {
                            $row = '$row+1';
                            $data = $model->searchPrint();
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
                            $itemsCssClass = 'table border';
                            $template = "{items}";
                            $sort = false;
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
                            'itemsCssClass' => $itemsCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => $row,
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->no_rekam_medik',
                                ),
                                array(
                                    'header' => 'Nama Lengkap',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->nama_pasien',
                                ),
                                array(
                                    'header' => 'No. Pendaftaran',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->no_pendaftaran',
                                ),
                                array(
                                    'header' => 'Jenis',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->jenisdiet_nama'
                                ),
                                array(
                                    'header' => 'Jenis Diet',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->menudiet_nama'
                                ),
                                //                array(
                                //                    'header' => 'No. Gizi',
                                //                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                                //                    'value' => '$data->no_masukpenunjang',
                                //                ),
                                array(
                                    'header' => 'Jumlah',
                                    'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => 'number_format($data->jml_kirim,0,"",".")',
                                    //'footerHtmlOptions' => array('colspan' => 7, 'style' => 'text-align:right;font-weight:bold'),
                                    //'footer' => 'Total',
                                ),
                                /*
        array(
            'header' => 'Harga (Rp)',
            'name' => 'hargasatuan',
            'headerHtmlOptions' => array('style' => 'text-align: right;vertical-align:middle;'),
            'value' => 'number_format($data->hargasatuan,0,"",".")',
            'footerHtmlOptions' => array('style' => 'text-align:right;font-weight:bold'),
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(hargasatuan)',
        ),
         * 
         */
                                array(
                                    'header' => 'Ruangan',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->ruangan_nama',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Kelas',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => '$data->kelaspelayanan_nama',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Tanggal Transaksi',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Tanggal Pemberian',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'value' => 'date("d/m/Y H:i:s",strtotime($data->tglkirimmenu))',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                array(
                                    'header' => 'Jam Pemberian',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                    'value' => '$data->jeniswaktu_jam',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
                                ),
                                //                array(
                                //                    'header' => 'Hari',
                                //                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                                //                    'value' => 'date("l,strtotime($data->tglkirimmenu")',
                                //                ),
                                array(
                                    'header' => 'Waktu',
                                    'headerHtmlOptions' => array('style' => 'text-align: left;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                    'value' => '$data->jeniswaktu_nama',
                                    //'footerHtmlOptions' => array('style' => 'text-align:right;color:white'),
                                    //'footer' => '-',
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {  ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php  }  ?>
    </div>

<?php
}
?>