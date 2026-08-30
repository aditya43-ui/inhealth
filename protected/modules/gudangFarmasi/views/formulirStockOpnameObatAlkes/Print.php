<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => '', 'colspan' => 10));
}
if (!isset($_GET['frame'])) {
?>
    <style>
        .control-label {
            float: left;
            text-align: right;
            width: 50%;
            color: black;
            padding-right: 10px;
            font-size: 8pt;
        }

        body {
            font-size: 8pt;
            font-family: "Arial" !important;
        }

        td .uang {
            text-align: right;
        }

        .border th,
        .border td {
            border: 1px solid #000;
        }

        .table thead:first-child {
            border-top: 1px solid #000;
            font-family: "Arial" !important;
        }

        thead th {
            background: none;
            color: #333;
            font-family: "Arial" !important;
        }

        .table {
            box-shadow: none;
        }

        .table tbody tr:hover td,
        .table tbody tr:hover th {
            background-color: none;
        }

        @page {
            font-size: 10pt !important;
            margin: 0;
            font-family: "Arial" !important;
        }

        table thead th {
            font-family: "Arial" !important;
        }

        TABLE,
        TBODY,
        TFOOT,
        TR,
        TH,
        TD {
            font-family: "Arial" !important;
            font-size: 9pt !important;
        }

        @media print {

            html,
            body {
                size: auto;
                margin: 0cm, 0.25cm, 0cm, 0.25cm;
                margin-top: 0.25cm;
                margin-right: 0.1cm;
                margin-left: 0.2cm;
                margin-bottom: 1cm;
                font-family: "Arial" !important;
            }

            .content {
                font-family: "Arial" !important;
            }
        }
    </style>
    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header">
                        <?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                    <?php
                }
                    ?>
                    <table class="table" style="margin: 0;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align:center;" valig="middle" colspan="6">
                                <b><?php echo $judulLaporan ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td><b>No. Formulir Opname</b></td>
                            <td>:</td>
                            <td> <?php echo $model->noformulir; ?></td>

                            <td><b>Total Volume</b></td>
                            <td>:</td>
                            <td> <?php echo $format->formatNumberForPrint($model->totalvolume); ?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Formulir Opname</b></td>
                            <td>:</td>
                            <td> <?php echo $format->formatDateTimeForUser($model->tglformulir); ?></td>

                            <td><b>Total Harga</b></td>
                            <td>:</td>
                            <td> <?php echo $format->formatNumberForPrint($model->totalharga); ?></td>
                        </tr>
                    </table><br>
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Obat Alkes</th>
                                <th>Kode</th>
                                <th>Nama Obat / Kekuatan</th>
                                <th>Golongan / Kategori</th>
                                <th>Satuan Kecil</th>
                                <th>HPP</th>
                                <th>Stok Sistem</th>
                                <th>Stok Fisik</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Kondisi Obat</th>
                                <th>Tanggal Periksa Fisik</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modDetails as $i => $obat) {
                            ?>
                                <tr>
                                    <td><?php echo ($i + 1); ?></td>
                                    <td><?php echo (isset($obat->obatalkes->jenisobatalkes->jenisobatalkes_nama) ? $obat->obatalkes->jenisobatalkes->jenisobatalkes_nama : ""); ?></td>
                                    <td><?php echo $obat->obatalkes->obatalkes_kode; ?></td>
                                    <td><?php echo $obat->obatalkes->obatalkes_nama . "</br>" . $obat->obatalkes->kekuatan; ?></td>
                                    <td><?php echo $obat->obatalkes->obatalkes_golongan . "</br>" . $obat->obatalkes->obatalkes_kategori; ?></td>
                                    <td><?php echo (isset($obat->obatalkes->satuankecil->satuankecil_nama) ? $obat->obatalkes->satuankecil->satuankecil_nama : ""); ?></td>
                                    <td style="text-align:right;"><?php echo $format->formatNumberForPrint($obat->obatalkes->hpp); ?></td>
                                    <td><?php echo $format->formatNumberForPrint($obat->volume_stok) ?></td>
                                    <td><?php echo !empty($obat->stokopnamedet->volume_fisik) ? $obat->stokopnamedet->volume_fisik : ' '; ?></td>
                                    <td> <?= GFObatalkesfarmasiV::getTglKadaluarsa($obat->obatalkes_id) ?> </td>
                                    <td><?php echo !empty($obat->stokopnamedet->kondisibarang) ? $obat->stokopnamedet->kondisibarang : ' '; ?></td>
                                    <td><?php echo !empty($obat->stokopnamedet->tglperiksafisik) ? MyFormatter::formatDateTimeForUser($obat->stokopnamedet->tglperiksafisik) : " " ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    if (isset($_GET['frame'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
                        echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('EXCEL')"));
                    ?>
                        <script type='text/javascript'>
                            /**
                             * print
                             */
                            function print(caraPrint) {
                                formuliropname_id = '<?php echo isset($model->formuliropname_id) ? $model->formuliropname_id : ''; ?>';
                                window.open('<?php echo $this->createUrl('print'); ?>&formuliropname_id=' + formuliropname_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=640,height=480');
                            }
                        </script>
                    <?php
                    } else { ?>
                        <table width="100%" style="margin-top:20px;">
                            <tr>
                                <td width="100%" align="left" align="top">
                                    <table style="width: 100%; border: none;">
                                        <tr>
                                            <td width="35%" align="center">
                                            </td>
                                            <td width="35%" align="center">
                                            </td>
                                            <td width="35%" align="center">
                                                <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                                                <div>Petugas</div>
                                                <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>
                    <?php
                    if (!isset($_GET['frame'])) {
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
        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    </div>
<?php } ?>