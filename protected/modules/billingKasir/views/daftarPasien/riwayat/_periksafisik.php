


<div class="anamnesis_judul">PEMERIKSAAN FISIK</div>
<table class="anamnesa_content">
    <tr>
        <td width="150">Tgl. Pemeriksaan Fisik</td>
        <td width="10">:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modPemeriksaanFisik->tglperiksafisik); ?></td>
    </tr>
    <tr>
        <td>Keadaan</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->keadaanumum) ? $modPemeriksaanFisik->keadaanumum : "-"); ?></td>
    </tr>
    <tr>
        <td>Detak Nadi</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->detaknadi) ? $modPemeriksaanFisik->detaknadi : " - ") . ' x/Menit'; ?></td>
    </tr>
    <tr>
        <td>Denyut Jantung</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->denyutjantung) ? $modPemeriksaanFisik->denyutjantung : " - "); ?></td>
    </tr>
    <tr>
        <td>Tekanan Darah</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' MmHg'; ?></td>
    </tr>
    <tr>
        <td>Mean Arterial Pressure</td>
        <td>:</td>
        <td><?php echo isset($modPemeriksaanFisik->meanarteripressure) ? $modPemeriksaanFisik->meanarteripressure : " - "; ?></td>
    </tr>
    <tr>
        <td>Suhu Tubuh</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->suhutubuh) ? $modPemeriksaanFisik->suhutubuh : " - ") . ' &deg;C'; ?></td>
    </tr>
    <tr>
        <td>Tinggi/Berat Badan</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm) ? $modPemeriksaanFisik->tinggibadan_cm : " - ") . ' Cm / ' . (isset($modPemeriksaanFisik->beratbadan_kg) ? $modPemeriksaanFisik->beratbadan_kg : " - ") . ' Kg'; ?></td>
    </tr>
    <tr>
        <td>Indeks Masa Tubuh</td>
        <td>:</td>
        <td>
        <?php
        $bmi_definisi = "-";
        $bmi = "-";
        if (!empty($modPemeriksaanFisik->tinggibadan_cm) && !empty($modPemeriksaanFisik->beratbadan_kg) && is_numeric($modPemeriksaanFisik->tinggibadan_cm) && is_numeric($modPemeriksaanFisik->beratbadan_kg) && $modPemeriksaanFisik->tinggibadan_cm != 0) {
            $bmi = floor((float)$modPemeriksaanFisik->beratbadan_kg / ((float)$modPemeriksaanFisik->tinggibadan_cm * (float)$modPemeriksaanFisik->tinggibadan_cm / 10000));
            $criteria2 = new CDbCriteria();
            $criteria2->select = 'max(bmi_minimum) as max_bmi';
            $modBMI = BodymassindexM::model()->find($criteria2);
            $criteria = new CDbCriteria();
            $criteria->addCondition($bmi . ' >= bmi_minimum');
            $criteria->addCondition($bmi . ' <= bmi_maksimum');
            $data = array();
            $bmi_hasil = BodymassindexM::model()->find($criteria);
            $bmi_definisi = (!empty($bmi_hasil->bmi_defenisi) ? $bmi_hasil->bmi_defenisi : "");
        }
        ?>
        <?php echo $bmi . " - " . $bmi_definisi; ?></td>
    </tr>
    <tr>
        <td>Pernapasan</td>
        <td>:</td>
        <td><?php echo (isset($modPemeriksaanFisik->pernapasan) ? $modPemeriksaanFisik->pernapasan : " - ") . ' x/Menit'; ?></td>
    </tr>
    <tr>
        <td>Kelainan pada Bagian Tubuh</td>
        <td>:</td>
        <td><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh) ? $modPemeriksaanFisik->kelainanpadabagtubuh : " - "; ?></td>
    </tr>
    <tr>
        <td>Reflek Cahaya</td>
        <td>:</td>
        <td><?php echo isset($modPemeriksaanFisik->tandavital_reflekcahaya) ? $modPemeriksaanFisik->tandavital_reflekcahaya : " - "; ?></td>
    </tr>
    <tr>
        <td>SpO2</td>
        <td>:</td>
        <td><?php echo isset($modPemeriksaanFisik->tandavital_spo2) ? $modPemeriksaanFisik->tandavital_spo2 : " - "; ?></td>
    </tr>
</table>
<hr />