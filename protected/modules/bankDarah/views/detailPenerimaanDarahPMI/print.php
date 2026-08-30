<style>
    body {
        color: black;
    }

    .tab_detail {
        width: 100%;
    }

    .tab_detail th,
    .tab_detail td {
        color: black;
        border: 1px solid black;
        padding: 3px;
    }

    .tab_detail th {
        font-weight: bold;
    }

    .tab_header {
        width: 100%;
        margin-bottom: 10px;

        .tab_header td {
            padding: 3px;
            border: none;
        }
</style>
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
                    <div class="judulcontent"> <?php echo $judul_print ?>
                    </div>
                    <table class='tab_header'>
                        <tr>
                            <td>No. Pemesanan</td>
                            <td>:</td>
                            <td width="100%">
                                <?php echo CHtml::encode($modPermintaandarah->no_permintaan); ?>
                            </td>
                            <td nowrap>No. Penerimaan</td>
                            <td>:</td>
                            <td nowrap><?php echo CHtml::encode($modPenerimaan->no_penerimaan); ?></td>

                        </tr>
                        <tr>
                            <td nowrap>Tgl. Pemesanan</td>
                            <td>:</td>
                            <td><?php echo CHtml::encode($modPermintaandarah->tgl_permintaan); ?></td>
                            <td nowrap>Tgl. Penerimaan</td>
                            <td>:</td>
                            <td nowrap><?php echo CHtml::encode($modPenerimaan->tgl_penerimaan); ?></td>
                        </tr>
                    </table>

                    <table id="tableObatAlkes" class="tab_detail">
                        <thead>

                            <th>No.</th>
                            <th>Jenis Darah</th>
                            <th>Golongan Darah</th>
                            <th>Rhesus</th>
                            <th>No Kantong darah</th>
                            <th>Tgl. Aftap</th>
                            <th>Tanggal kedaluwarsa</th>
                            <!--<th>Ukuran<br>Bahan</th>-->

                        </thead>
                        <tbody>
                            <?php
                            $k = 0;
                            foreach ($modDetail as $key => $value) {

                                $jeniskomponenedarah_nama = "";
                                if (!empty($value->jeniskomponendarah_id)) {
                                    $mod = JeniskomponendarahM::model()->findByPk($value->jeniskomponendarah_id);
                                    $jeniskomponenedarah_nama = $mod->jeniskomponenedarah_nama;
                                }

                                $modKantong = KantongdarahT::model()->findAllByAttributes(array('penerimaandarahpmidet_id' => $value->penerimaandarahpmidet_id));

                                foreach ($modKantong as $key => $kantong) {
                                    echo '
                                        <tr>
                                            <td>' . ($k + 1) . '</td>
                                            <td style="text-align: center">' . $jeniskomponenedarah_nama . '</td>
                                            <td style="text-align: center">' . $value->golongandarah . '</td>
                                            <td style="text-align: center">' . $value->rhesus . '</td>
                                            <td style="text-align: center">' . $kantong->no_kantongdarah . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($kantong->tgl_aftap) . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($kantong->tgl_kadaluarsa) . '</td>
                                        </tr>
                                    ';
                                    $k++;
                                }
                            }

                            ?>

                        </tbody>
                    </table>

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
                                            <div>Petugas Menerima:</div>
                                            <div style="margin-top:60px;"><?php echo isset($modPenerimaan->petugas_penerima_id) ? $modPenerimaan->petugas->NamaLengkap : "" ?></div>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
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