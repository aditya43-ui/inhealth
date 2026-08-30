<?php
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
        width: 21.7cm;
    }

    .content td {
        height: 32px;
    }

    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: center;
    }
</style>
<?php echo $this->renderPartial($this->path_view . '_headerPrint'); ?>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
        <td style="width:20%">NO. RM</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">UMUR</td>
        <td style="width:30%"><?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tgl. Periksa</td>
        <td style="width:20%"><?php echo MyFormatter::formatDateTimeId($modPemeriksaanFisik->tglperiksafisik); ?></td>
        <td style="width:20%">Ruangan</td>
        <td style="width:20%"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
</table>
<br><br>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>PERIKSA FISIK</b></td>
    </tr>
    <tr>
        <td width="30%">Tekanan Darah</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' /MmHg'; ?></td>
        <td width="30%">Mean Arterial Pressure</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->meanarteripressure) ? $modPemeriksaanFisik->meanarteripressure : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Detak Nadi</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->detaknadi) ? $modPemeriksaanFisik->detaknadi : " - ") . ' /Menit'; ?></td>
        <td width="30%">Denyut Jantung</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->denyutjantung) ? $modPemeriksaanFisik->denyutjantung : " - "); ?></td>
    </tr>
    <tr>
        <td width="30%">Pernapasan</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->pernapasan) ? $modPemeriksaanFisik->pernapasan : " - ") . ' /Menit'; ?></td>
        <td width="30%">Suhu Tubuh</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->suhutubuh) ? $modPemeriksaanFisik->suhutubuh : " - ") . ' &deg; Celcius'; ?></td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td width="30%">Tinggi badan / Berat badan</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm) ? $modPemeriksaanFisik->tinggibadan_cm : " - ") . ' Cm / ' . (isset($modPemeriksaanFisik->beratbadan_kg) ? $modPemeriksaanFisik->beratbadan_kg : " - ") . ' Kg'; ?></td>
        <td width="30%">Index Masa Tubuh</td>
        <td width="20%"><?php echo (isset($modPemeriksaanFisik->indexmassatubuh) ? $modPemeriksaanFisik->indexmassatubuh : " - "); ?></td>
    </tr>
    <tr>

    </tr>
    <tr>
        <td width="30%">Kelainan Pada Bagian Tubuh</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh) ? $modPemeriksaanFisik->kelainanpadabagtubuh : " - "; ?></td>
        <td width="30%">Inspeksi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->inspeksi) ? $modPemeriksaanFisik->inspeksi : " - "; ?></td>
    </tr>
    <tr>
        <td width="30%">Palpasi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->palpasi) ? $modPemeriksaanFisik->palpasi : " - "; ?></td>
        <td width="30%">Perkusi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->perkusi) ? $modPemeriksaanFisik->perkusi : " - "; ?></td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td width="30%">Auskultasi</td>
        <td width="20%"><?php echo isset($modPemeriksaanFisik->auskultasi) ? $modPemeriksaanFisik->auskultasi : " - "; ?></td>
        <td width="30%"></td>
        <td width="20%"></td>
    </tr>
</table>
<br>
<table width="100%" class="content" border="0">
    <tr>
        <td width="70%">
            <div align="center" id="imgtag">
                <img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh() . $modGambarTubuh->FileNameGambar; ?>" class="taggd" />
                <div id="tagbox"></div>
            </div>
        </td>
        <td width="30%" style="vertical-align:top;">
            <table border="1" width="100%">
                <tr>
                    <td colspan="3">
                        <p style="margin: 0; text-align: center;"><b>Glasgow Coma Scale</b></p>
                    </td>
                </tr>
                <tr>
                    <td><b>GCS Eye</b></td>
                    <td><?php echo !empty($modPemeriksaanFisik->gcs_eye) ? $modPemeriksaanFisik->metodegcseye->metodegcs_nama : ' - '; ?></td>
                </tr>
                <tr>
                    <td><b>GCS Verbal</b></td>
                    <td><?php echo !empty($modPemeriksaanFisik->gcs_verbal) ? $modPemeriksaanFisik->metodegcsverbal->metodegcs_nama : ' - '; ?></td>
                </tr>
                <tr>
                    <td><b>GCS Motorik</b></td>
                    <td><?php echo !empty($modPemeriksaanFisik->gcs_motorik) ? $modPemeriksaanFisik->metodegcsmotorik->metodegcs_nama : ' - '; ?></td>
                </tr>
                <tr>
                    <td><b> Nilai GCS</b></td>
                    <td><?php echo !empty($modPemeriksaanFisik->namaGCS) ? $modPemeriksaanFisik->namaGCS : ' - '; ?></td>
                </tr>
            </table>
            <br><br>
            <table border="1" width="100%">
                <tr>
                    <td colspan="3">
                        <p style="margin: 0; text-align: center;"><b>Anatomi Tubuh</b></p>
                    </td>
                </tr>
                <?php
                if (count((array)$modPemeriksaanGambar) > 0) { ?>
                    <tr>
                        <td>
                            <p style="margin: 0; text-align: center;"><b>No.</b></p>
                        </td>
                        <td><b>Bagian Tubuh</b></td>
                        <td><b>Keterangan</b></td>
                    </tr>
                    <?php foreach ($modPemeriksaanGambar as $i => $v) { ?>
                        <tr>
                            <td>
                                <p style="margin: 0; text-align: center;"><?= $i + 1; ?></p>
                            </td>
                            <td><?= $v->bagiantubuh->namabagtubuh; ?></td>
                            <td><?= $v->keterangan_periksa_gbr; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>
<br><br><br>
<table width="100%" border="1">
    <tr>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Jalan Nafas</b></td>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><b>Pernapasan</b></td>
    </tr>
    <tr>
        <td width="30%">Paten</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->jn_paten) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%">Simetri</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgd_simetri) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Obstruktif Partial</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifpartial) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%">Asimetri</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgd_asimetri) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Obstruktif Total</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifnormal) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%">Normal</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Stridor</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->jn_stridor) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%">Kussmaul</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_kussmaul) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Gargling</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->jn_gargling) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%">Takipena</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_takipnea) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%"></td>
        <td width="20%"></td>
        <td width="30%">Retraktif</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_retraktif) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%"></td>
        <td width="20%"></td>
        <td width="30%">Dangkal</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->pgp_dangkal) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
</table>
<br>
<table width="100%" border="1">
    <tr>
        <td align="center" valign="middle" colspan="4" style="font-weight:bold"><b>Sirkulasi</b></td>
    </tr>
    <tr>
        <td width="30%">Nadi Carotis</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadicarotis) ? $modPemeriksaanFisik->sirkulasi_nadicarotis . ' x/menit' : ' - '; ?></td>
        <td width="30%"> Kulit Cyanosis</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_cyanosis) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Nadi Radialis</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadiradialis) ? $modPemeriksaanFisik->sirkulasi_nadiradialis . ' x/menit' : ' - '; ?></td>
        <td width="30%"> Kulit Pucat</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_pucat) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">CFR</td>
        <td width="20%">
            <?php echo ($modPemeriksaanFisik->cfr_kecil_2) ? '<b>&#8730</b>' : ' - '; ?> <= 2 &nbsp; &nbsp; <?php echo ($modPemeriksaanFisik->cfr_besar_2) ? '<b>&#8730</b>' : ' - '; ?>>= 2
        </td>
        <td width="30%"> Kulit Berkeringat</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_berkeringat) ? '<b>&#8730</b>' : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Kulit Normal</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_normal) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%"> Akral</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->akral) ? $modPemeriksaanFisik->akral : ' - '; ?></td>
    </tr>
    <tr>
        <td width="30%">Kulit Jaundice</td>
        <td width="20%"><?php echo ($modPemeriksaanFisik->kulit_jaundice) ? '<b>&#8730</b>' : ' - '; ?></td>
        <td width="30%"></td>
        <td width="20%"></td>
    </tr>
</table>
<br>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">Pasien / Keluarga pasien</td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($modPemeriksaanFisik->tglperiksafisik))); ?><br>Dokter Pemeriksa</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan) ? $modPendaftaran->pegawai->gelardepan : '') . ' ' . $modPendaftaran->pegawai->nama_pegawai . ' ' . (isset($modPendaftaran->pegawai->gelarbelakang_nama) ? $modPendaftaran->pegawai->gelarbelakang_nama : ''); ?></td>
    </tr>
</table>
<script>
    function titikSesudahSimpan(titikX, titikY, urutan) {
        var titikX = titikX - 85;
        var titikY = titikY - 17;
        var nomor = urutan + 1;
        var color = '#000000';
        var size = '5px';
        $("#imgtag").append(
            $('<div><b>' + nomor + '</b></div>')
            .css('position', 'absolute')
            .css('top', titikY + 'px')
            .css('left', titikX + 'px')
            .css('width', size)
            .css('height', size)
            .css('background-color', color)
            .css('cursor', 'pointer')
            .css('display', 'block')
            .css('padding', '10px')
            .css('-webkit-border-radius', '50%')
            .css('-moz-border-radius', '50%')
            .css('border-radius', '50%')
            .css('vertical-align', 'middle')
            .css('color', '#FFF')
        );
    }

    function loadTitikSesudahSimpan() {
        <?php if (!empty($modPemeriksaanGambar)) {
            foreach ($modPemeriksaanGambar as $i => $v) { ?>
                titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i; ?>);
        <?php }
        } ?>
    }


    $(document).ready(function() {
        loadTitikSesudahSimpan();

    });
</script>