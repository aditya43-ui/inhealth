<?php 
$result = isset($model->is_ews)? $model->is_ews : "";
if ($result) : ?>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed">
        <tr>
            <td colspan="3"><b>Early Warning System (EWS)</b></td>
        </tr>
        <tr>
            <td><b>Parameter</b></td>
            <td width="100"><b>Penilaian</b></td>
            <td width="50"><b>Skor</b></td>
        </tr>
        <tr>
            <td>Pernapasan (per menit)</td>
            <td style="text-align: right;"><?php echo $model->ews_pernafasan; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_pernafasanskor; ?></td>
        </tr>
        <tr>
            <td>Saturasi Oksigen Skala 1 (%)</td>
            <td style="text-align: right;"><?php echo $model->ews_so2skala1; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_so2skala1skor; ?></td>
        </tr>
        <tr>
            <td>Saturasi Oksigen Skala 2 (%)</td>
            <td style="text-align: right;"><?php echo $model->ews_so2skala2; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_so2skala2skor; ?></td>
        </tr>
        <tr>
            <td>Pemberian O2</td>
            <td><?php echo $model->ews_pemberiano2; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_pemberiano2skor; ?></td>
        </tr>
        <tr>
            <td>Tekanan Darah Sistolik</td>
            <td style="text-align: right;"><?php echo $model->ews_tdsistolik; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_tdsistolikskor; ?></td>
        </tr>
        <tr>
            <td>Nadi</td>
            <td style="text-align: right;"><?php echo $model->ews_nadi; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_nadiskor; ?></td>
        </tr>
        <tr>
            <td>Pesadaran</td>
            <td><?php echo $model->ews_kesadaran; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_kesadaranskor; ?></td>
        </tr>
        <tr>
            <td>Suhu</td>
            <td><?php echo $model->ews_suhu; ?></td>
            <td style="text-align: right;"><?php echo $model->ews_suhuskor; ?></td>
        </tr>
        <tr>
            <td colspan="2">Total Skor</td>
            <td style="text-align: right;"><?php echo $model->ews_totalskor; ?></td>
        </tr>
        <tr>
            <td>Frekuensi Monitor</td>
            <td colspan="2"><?php echo $model->ews_frekmonitor; ?></td>
        </tr>
        <tr>
            <td>Eskalasi Perawatan</td>
            <td colspan="2"><?php echo $model->ews_eskalasi; ?></td>
        </tr>
    </table>

<?php endif; ?>

<?php 
$results = isset($model->is_pews)? $model->is_pews : "";
if ($results) : ?>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed">
        <tr>
            <td colspan="3"><b>Pediatric Early Warning System (PEWS)</b></td>
        </tr>
        <tr>
            <td width="200"><b>Parameter</b></td>
            <td><b>Penilaian</b></td>
            <td width="50"><b>Skor</b></td>
        </tr>
        <tr>
            <td>Keadaan Umum</td>
            <td><?php echo $model->pews_keadaanumum; ?></td>
            <td style="text-align: right;"><?php echo $model->pews_skorkesadaranumum; ?></td>
        </tr>
        <tr>
            <td>Kardiovaskuler</td>
            <td><?php echo $model->pews_kardiovaskuler; ?></td>
            <td style="text-align: right;"><?php echo $model->pews_skorkardiovaskuler; ?></td>
        </tr>
        <tr>
            <td>Respirasi</td>
            <td><?php echo $model->pews_respirasi; ?></td>
            <td style="text-align: right;"><?php echo $model->pews_skorrespirasi; ?></td>
        </tr>
        <tr>
            <td colspan="2">Total Skor</td>
            <td style="text-align: right;"><?php echo $model->pews_totalskor; ?></td>
        </tr>
        <tr>
            <td>Frekuensi Monitor</td>
            <td colspan="2"><?php echo $model->pews_frekmonitor; ?></td>
        </tr>
        <tr>
            <td>Eskalasi Perawatan</td>
            <td colspan="2"><?php echo $model->pews_eskalasi; ?></td>
        </tr>
    </table>

<?php endif; ?>

<?php 

$resultsx = isset($model->is_mews)? $model->is_mews : "";
if ($resultsx) : ?>

    <table id="tblDaftarAnamnesa" class="table table-bordered table-condensed">
        <tr>
            <td colspan="3"><b>Maternity Early Warning System (MEWS)</b></td>
        </tr>
        <tr>
            <td><b>Parameter</b></td>
            <td width="100"><b>Penilaian</b></td>
            <td width="100"><b>Skor</b></td>
        </tr>
        <tr>
            <td>Pernapasan (per menit)</td>
            <td style="text-align: right;"><?php echo $model->mews_pernafasan; ?></td>
            <td><?php echo $model->mews_pernafasannilai; ?></td>
        </tr>
        <tr>
            <td>Saturasi O2</td>
            <td style="text-align: right;"><?php echo $model->mews_so2; ?></td>
            <td><?php echo $model->mews_so2nilai; ?></td>
        </tr>
        <tr>
            <td>Tekanan Darah Sistolik</td>
            <td style="text-align: right;"><?php echo $model->mews_tdsistolik; ?></td>
            <td><?php echo $model->mews_tdsistoliknilai; ?></td>
        </tr>
        <tr>
            <td>Tekanan Darah Diastolik</td>
            <td style="text-align: right;"><?php echo $model->mews_tddiastolik; ?></td>
            <td><?php echo $model->mews_tddiastoliknilai; ?></td>
        </tr>
        <tr>
            <td>Nadi</td>
            <td style="text-align: right;"><?php echo $model->mews_nadi; ?></td>
            <td><?php echo $model->mews_nadinilai; ?></td>
        </tr>
        <tr>
            <td>Pesadaran</td>
            <td><?php echo $model->mews_kesadaran; ?></td>
            <td><?php echo $model->mews_kesadarannilai; ?></td>
        </tr>
        <tr>
            <td>Suhu</td>
            <td style="text-align: right;"><?php echo $model->mews_suhu; ?></td>
            <td><?php echo $model->mews_suhunilai; ?></td>
        </tr>
        <tr>
            <td>Total Skor</td>
            <td colspan="2">
                <?php
                if (!empty($model->mews_totalkriteria)) {
                    $total_kr = explode(".", $model->mews_totalkriteria);
                    if (count((array)$total_kr) == 3) {
                        echo $total_kr[0] . " Merah, ";
                        echo $total_kr[1] . " Kuning, ";
                        echo $total_kr[2] . " Putih";
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Frekuensi Monitor</td>
            <td colspan="2"><?php echo $model->mews_frekmonitor; ?></td>
        </tr>
        <tr>
            <td>Eskalasi Perawatan</td>
            <td colspan="2"><?php echo $model->mews_eskalasi; ?></td>
        </tr>
    </table>

<?php endif; ?>