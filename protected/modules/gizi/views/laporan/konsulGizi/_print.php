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
                        <?php $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
                        $itemsCssClass = 'table table-striped table-condensed';
                        $sort = true;
                        if (isset($caraPrint)) {
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
                            $itemsCssClass = 'table border';
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
                                    'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'value' => '$data->no_rekam_medik',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'value' => '$data->nama_pasien',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'No. Pendaftaran',
                                    'value' => '$data->no_pendaftaran',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'No. Gizi',
                                    'value' => '$data->no_masukpenunjang',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Jenis Diet',
                                    'value' => '$data->jenisdiet_nama',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Jumlah',
                                    'value' => '$data->qty_tindakan',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Harga (Rp)',
                                    'value' => '(Params::cekHiddenHargaGizi()==true) ? number_format($data->tarif_tindakan,0,"","."):"Hidden"',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Ruangan',
                                    'value' => '$data->ruanganasal_nama',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Kelas Pelayanan',
                                    'value' => '$data->kelaspelayanan_nama',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Tanggal Transaksi',
                                    'type' => 'raw',
                                    //                    'value'=> '$data->tglmasukpenunjang',
                                    'value' => 'date("d M Y", strtotime($data->tglmasukpenunjang))',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
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
        <?php $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
        $itemsCssClass = 'table table-striped table-condensed';
        $sort = true;
        if (isset($caraPrint)) {
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
            $itemsCssClass = 'table border';
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
                    'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'value' => '$data->no_rekam_medik',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Nama Pasien',
                    'value' => '$data->nama_pasien',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'value' => '$data->no_pendaftaran',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'No. Gizi',
                    'value' => '$data->no_masukpenunjang',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Jenis Diet',
                    'value' => '$data->jenisdiet_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Jumlah',
                    'value' => '$data->qty_tindakan',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Harga (Rp)',
                    'value' => 'number_format($data->tarif_tindakan,0,"",".")',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Ruangan',
                    'value' => '$data->ruanganasal_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Kelas Pelayanan',
                    'value' => '$data->kelaspelayanan_nama',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                ),
                array(
                    'header' => 'Tanggal Transaksi',
                    'type' => 'raw',
                    //                    'value'=> '$data->tglmasukpenunjang',
                    'value' => 'date("d M Y", strtotime($data->tglmasukpenunjang))',
                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
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
                        <?php $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
                        $itemsCssClass = 'table table-striped table-condensed';
                        $sort = true;
                        if (isset($caraPrint)) {
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
                            $itemsCssClass = 'table border';
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
                                    'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'value' => '$data->no_rekam_medik',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'value' => '$data->nama_pasien',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'No. Pendaftaran',
                                    'value' => '$data->no_pendaftaran',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'No. Gizi',
                                    'value' => '$data->no_masukpenunjang',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Jenis Diet',
                                    'value' => '$data->jenisdiet_nama',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Jumlah',
                                    'value' => '$data->qty_tindakan',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Harga (Rp)',
                                    'value' => 'number_format($data->tarif_tindakan,0,"",".")',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Ruangan',
                                    'value' => '$data->ruanganasal_nama',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Kelas Pelayanan',
                                    'value' => '$data->kelaspelayanan_nama',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
                                ),
                                array(
                                    'header' => 'Tanggal Transaksi',
                                    'type' => 'raw',
                                    //                    'value'=> '$data->tglmasukpenunjang',
                                    'value' => 'date("d M Y", strtotime($data->tglmasukpenunjang))',
                                    'headerHtmlOptions' => array('style' => 'vertical-align:middle;'),
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