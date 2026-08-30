<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 9));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode));
                        }
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">

                        <?php
                        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
                        $sort = false;
                        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
                        $data = $model->searchPrintLaporan();
                        $rim = '';
                        $template = "{items}";
                        if ($caraPrint == "EXCEL") {
                            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
                        $itemCss = 'table border';
                        $nama = "";
                        $npwp = "";
                        /*
                          if(count((array)$data)>0){
                          $pegawai_id = "";
                          foreach ($data->data as $datapajak){
                          $pegawai_id = $datapajak->pegawai_id;
                          }

                          if(!empty($pegawai_id)){
                          $pegData = PegawaiM::model()->findByPk($pegawai_id);
                          $nama = $pegData->namaLengkap;
                          $npwp = $pegData->npwp;
                          }
                          }
                         * 
                         */
                        ?>
                        <?php if (!empty($nama)) {
                            ?>
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td width="150" nowrap>Nama Dokter</td>
                                    <td width="100%">: <?php echo $nama; ?></td>
                                </tr>
                                <tr>
                                    <td width="150" nowrap>NPWP</td>
                                    <td width="100%">: <?php echo $npwp; ?></td>
                                </tr>
                            </table>
                        <?php }
                        ?>

                        <br>
                        <?php
                        $this->widget($table, array(
                            'id' => 'laporanrekapjasadokter-grid',
                            'dataProvider' => $data,
                            'enableSorting' => $sort,
                            'template' => $template,
                            'itemsCssClass' => $itemCss,
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                                    'footer' => "Jumlah",
                                    'footerHtmlOptions' => array(
                                        'style' => 'text-align: right; font-weight: bold;',
                                        'colspan' => 5,
                                    ),
                                ),
                                array(
                                    'header' => 'Periode',
                                    'type' => 'raw',
                                    'value' => 'date("F Y", strtotime($data->tglbayarjasa))',
                                ),
                                array(
                                    'header' => 'Dokter',
                                    'type' => 'raw',
                                    'value' => function($data) use (&$peg) {
                                        $peg = PegawaiM::model()->findByPk($data->pegawai_id);

                                        if (empty($peg)) {
                                            return "-";
                                        }

                                        return $peg->namaLengkap;
                                    }
                                ),
                                array(
                                    'header' => 'NPWP',
                                    'type' => 'raw',
                                    'value' => function($data) use (&$peg) {
                                        if (empty($peg)) {
                                            return "-";
                                        }

                                        return $peg->npwp;
                                    }
                                ),
                                array(
                                    'header' => 'Nomor Bukti Potong',
                                    'type' => 'raw',
                                    'value' => '$data->no_perhitungan',
                                ),
                                array(
                                    'header' => 'Penghasilan Bruto',
                                    'type' => 'raw',
                                    'name' => 'penghasilanbruto',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->penghasilanbruto)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'footerHtmlOptions' => array(
                                        'style' => 'text-align: right; font-weight: bold;',
                                    ),
                                    'footer' => "sum(penghasilanbruto)",
                                ),
                                array(
                                    'header' => 'Dasar Pengenaan Pajak (DPP)',
                                    'type' => 'raw',
                                    'name' => 'pkp',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->pkp)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'footerHtmlOptions' => array(
                                        'style' => 'text-align: right; font-weight: bold;',
                                    ),
                                    'footer' => "sum(pkp)",
                                ),
                                array(
                                    'header' => 'Tarif (%)',
                                    'type' => 'raw',
                                    'value' => '$data->getTarifPersen($data->pkpkumulatif)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'footerHtmlOptions' => array(
                                        'style' => 'text-align: right; font-weight: bold;',
                                    ),
                                    'footer' => " ",
                                ),
                                array(
                                    'header' => 'PKP Kumulatif',
                                    'type' => 'raw',
                                    'name' => 'pkpkumulatif',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->pkpkumulatif)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'footerHtmlOptions' => array(
                                        'style' => 'text-align: right; font-weight: bold;',
                                    ),
                                    'footer' => "sum(pkpkumulatif)",
                                ),
                                array(
                                    'header' => 'Pajak Progressif',
                                    'type' => 'raw',
                                    'name' => 'pajakprogressif',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakprogressif)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'footerHtmlOptions' => array(
                                        'style' => 'text-align: right; font-weight: bold;',
                                    ),
                                    'footer' => "sum(pajakprogressif)",
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
            <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?>
    </div>
    <div class="content">

        <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
        $sort = false;
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        $data = $model->searchPrintLaporan();
        $rim = '';
        $template = "{items}";
        if ($caraPrint == "EXCEL") {
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
        $itemCss = 'table border';
        $nama = "";
        $npwp = "";
        /*
          if(count((array)$data)>0){
          $pegawai_id = "";
          foreach ($data->data as $datapajak){
          $pegawai_id = $datapajak->pegawai_id;
          }

          if(!empty($pegawai_id)){
          $pegData = PegawaiM::model()->findByPk($pegawai_id);
          $nama = $pegData->namaLengkap;
          $npwp = $pegData->npwp;
          }
          }
         * 
         */
        ?>
        <?php if (!empty($nama)) {
            ?>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="150" nowrap>Nama Dokter</td>
                    <td width="100%">: <?php echo $nama; ?></td>
                </tr>
                <tr>
                    <td width="150" nowrap>NPWP</td>
                    <td width="100%">: <?php echo $npwp; ?></td>
                </tr>
            </table>
        <?php }
        ?>

        <br>
        <?php
        $this->widget($table, array(
            'id' => 'laporanrekapjasadokter-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            'template' => $template,
            'itemsCssClass' => $itemCss,
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'footer' => "Jumlah",
                    'footerHtmlOptions' => array(
                        'style' => 'text-align: right; font-weight: bold;',
                        'colspan' => 5,
                    ),
                ),
                array(
                    'header' => 'Periode',
                    'type' => 'raw',
                    'value' => 'date("F Y", strtotime($data->tglbayarjasa))',
                ),
                array(
                    'header' => 'Dokter',
                    'type' => 'raw',
                    'value' => function($data) use (&$peg) {
                        $peg = PegawaiM::model()->findByPk($data->pegawai_id);

                        if (empty($peg)) {
                            return "-";
                        }

                        return $peg->namaLengkap;
                    }
                ),
                array(
                    'header' => 'NPWP',
                    'type' => 'raw',
                    'value' => function($data) use (&$peg) {
                        if (empty($peg)) {
                            return "-";
                        }

                        return $peg->npwp;
                    }
                ),
                array(
                    'header' => 'Nomor Bukti Potong',
                    'type' => 'raw',
                    'value' => '$data->no_perhitungan',
                ),
                array(
                    'header' => 'Penghasilan Bruto',
                    'type' => 'raw',
                    'name' => 'penghasilanbruto',
                    'value' => 'MyFormatter::formatNumberForPrint($data->penghasilanbruto)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footerHtmlOptions' => array(
                        'style' => 'text-align: right; font-weight: bold;',
                    ),
                    'footer' => "sum(penghasilanbruto)",
                ),
                array(
                    'header' => 'Dasar Pengenaan Pajak (DPP)',
                    'type' => 'raw',
                    'name' => 'pkp',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pkp)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footerHtmlOptions' => array(
                        'style' => 'text-align: right; font-weight: bold;',
                    ),
                    'footer' => "sum(pkp)",
                ),
                array(
                    'header' => 'Tarif (%)',
                    'type' => 'raw',
                    'value' => '$data->getTarifPersen($data->pkpkumulatif)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footerHtmlOptions' => array(
                        'style' => 'text-align: right; font-weight: bold;',
                    ),
                    'footer' => " ",
                ),
                array(
                    'header' => 'PKP Kumulatif',
                    'type' => 'raw',
                    'name' => 'pkpkumulatif',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pkpkumulatif)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footerHtmlOptions' => array(
                        'style' => 'text-align: right; font-weight: bold;',
                    ),
                    'footer' => "sum(pkpkumulatif)",
                ),
                array(
                    'header' => 'Pajak Progressif',
                    'type' => 'raw',
                    'name' => 'pajakprogressif',
                    'value' => 'MyFormatter::formatNumberForPrint($data->pajakprogressif)',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                    'footerHtmlOptions' => array(
                        'style' => 'text-align: right; font-weight: bold;',
                    ),
                    'footer' => "sum(pajakprogressif)",
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

    <?php
}
