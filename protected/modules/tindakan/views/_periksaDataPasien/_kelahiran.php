<?php
if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan));
}
?>
<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 8pt !important;
        height: 24px;
        padding-left: 10px;
    }

    body {
        /*        width: 21.7cm;*/
    }

    .content td {
        height: 48px;
        border: 1px solid #000;
    }
</style>
<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">-->
<table style="width: 100%; border: none;">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Umur</td>
        <td style="width:15%">: <?php echo $modPendaftaran->umur; ?></td>
        <td style="width:15%">Alamat</td>
        <td style="width:15%">: <?php echo $modPasien->alamat_pasien; ?> <?php echo $modPasien->rt; ?> <?php echo $modPasien->rw; ?></td>
    </tr>
</table>
<!--</div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-doc-text"></i> Riwayat Kelahiran Bayi
        </div>
    </div>
    <div class="panel-body">-->

<?php
$total = 0;
foreach ($modPersalinan as $item) {
    $total += count((array)$modKelahiran[$item->persalinan_id]);
}


if ($total > 0) {

    foreach ($modPersalinan as $persalinan) {
?>
        <table width="100%" border="0" class="content">
            <tr>
                <td align="center" valign="middle" colspan="6" style="font-weight:bold; height: 10px; border-top: 2px solid black; border-bottom: 1px solid black;">
                    PERSALINAN
                </td>
            </tr>
            <?php
            foreach ($modKelahiran[$persalinan->persalinan_id] as $modDetail) {
            ?>
                <tr>
                    <td align="center" valign="middle" colspan="6" style="font-weight:bold">
                        KELAHIRAN BAYI</td>
                </tr>
                <tr>
                    <td style="width:15%">Tanggal Lahir Bayi</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->tgllahirbayi) ? MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modDetail->tgllahirbayi))) : "-"); ?></td>
                    <td style="width:15%">Jam Lahir</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->jamlahir) ? $modDetail->jamlahir : "-"); ?></td>
                </tr>
                <tr>
                    <td style="width:15%">Nama Bayi</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->namabayi) ? $modDetail->namabayi : "-"); ?></td>
                    <td style="width:15%">Jenis Kelamin</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->jeniskelamin) ? $modDetail->jeniskelamin : "-"); ?></td>
                </tr>
                <tr>
                    <td style="width:15%">Berat Badan</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->bb_gram) ? $modDetail->bb_gram : "-"); ?> Gram</td>
                    <td style="width:15%">Tinggi Badan</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->tb_cm) ? $modDetail->tb_cm : "-"); ?> Cm</td>
                </tr>
                <tr>
                    <td style="width:15%">Lahir Tunggal</td>
                    <td style="width:25%">:
                        <?php
                        if ($modDetail->islahirtunggal == true) {
                            echo "Ya";
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td style="width:15%">Lahir Kembar</td>
                    <td style="width:25%">: <?php echo (isset($modDetail->lahirkembar) ? $modDetail->lahirkembar : "-"); ?></td>
                    <td style="width:15%">Jumlah Kembar</td>
                    <td style="width:5%">: <?php echo (isset($modDetail->jmlkembar) ? $modDetail->jmlkembar : "-"); ?></td>
                </tr>
                <tr>
                    <td style="width:15%">Kelainan Bayi</td>
                    <td style="width:25%">: <?php echo (!empty($modDetail->kelainanbayi) ? $modDetail->kelainanbayi : "-"); ?></td>
                    <td style="width:15%">Catatan Bayi</td>
                    <td style="width:25%">: <?php echo (!empty($modDetail->catatan_bayi) ? $modDetail->catatan_bayi : "-"); ?></td>
                </tr>
                <tr>
                    <td colspan="6" class="panel_apgar">
                        <hr style="border-top: 1px dashed black; margin-bottom: 0;" />
                        <div style="text-align: center; font-weight: bold;">APGAR</div>
                        <?php
                        $criAp = new CDbCriteria();
                        $criAp->select = " t.*, ma.kriteria, ma.kriteria, ma.nilai_1, ma.nilai_2, ma.nilai_0 ";
                        $criAp->join = "   JOIN metodeapgar_m ma ON ma.metodeapgar_id = t.metodeapgar_id ";
                        $criAp->addCondition(" kelahiranbayi_id = '" . $modDetail->kelahiranbayi_id . "' ");
                        $criAp->order = " ma.metodeapgar_id ASC ";
                        $modApghar = ApgarscoreT::model()->findAll($criAp);

                        $genAphgar = array();
                        $genAphgarp = array();

                        foreach ($modApghar as $det) {
                            $genAphgarp[$det->menitke]['menitke'] = $det->menitke;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['apgarscore_id'] = $det->apgarscore_id;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['metodeapgar_id'] = $det->metodeapgar_id;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['kriteria'] = $det->kriteria;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_0'] = $det->nilai_0;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_1'] = $det->nilai_1;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_2'] = $det->nilai_2;
                            $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_apgar'] = $det->nilai_apgar;
                        }


                        foreach ($genAphgarp as $row) {
                        ?>

                            <label>Menit Ke-<?php echo $row['menitke']; ?></label>
                            <table>
                                <thead>
                                    <tr>
                                        <!--<th>ID</th>-->
                                        <th>Kriteria</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i = 1; ?>
                                    <?php foreach ($row['det'] as $row2) { ?>
                                        <tr>
                                            <!--<td><?php //echo $i;   
                                                    ?></td>-->
                                            <td><?php echo $row2['kriteria']; ?></td>
                                            <?php $nilai = 'nilai_' . $row2['nilai_apgar']; ?>
                                            <td><?php echo $row2[$nilai]; ?></td>

                                            <?php $i++; ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                $login = LoginpemakaiK::model()->findByPk($modDetail->create_loginpemakai_id);
                $peg_nama = "";
                if (!empty($login)) {
                    $peg_nama = !empty($login->pegawai) ? $login->pegawai->namaLengkap : "-";
                }
                echo '<tr><td colspan="6" style="height: 10px !important;">Dibuat Oleh : ' . $peg_nama . '</td></td>';
                ?>
                <tr>
                    <td colspan="6" style="height: 10px !important; border-bottom: 1px solid black;">
                        &nbsp;
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="6" style="height: 18px; font-size: 8pt; font-weight: bold; border-top: 1px solid black; border-bottom: 2px solid black; padding: 5px;">
                    Dibuat Oleh : <?php
                                    $login = LoginpemakaiK::model()->findByPk($item->create_loginpemakai_id);
                                    if (!empty($login->pegawai)) {
                                        echo $login->pegawai->namaLengkap;
                                    } else {
                                        echo $login->nama_pemakai;
                                    }
                                    ?>
                </td>
            </tr>
        </table>
    <?php
    }
} else {
    ?>
    <table width="100%" class="content" style="border: none;">
        <tr>
            <td colspan="6">* Tidak ada riwayat kelahiran bayi</td>
        </tr>
    </table>
<?php } ?>
<!--</div>
</div>-->