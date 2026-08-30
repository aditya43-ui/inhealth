<?php
$hide = '';
$headThorax = 'Pemeriksaan Thorax';
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_POLIK_GIGI) {
    $hide = 'hidden';
    $headThorax = 'Tanda Vital';
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 20px;
        /*        padding-left:10px;*/
    }
    body{
        /*        width: 21.7cm;*/
    }
    .content td{
        /*        height: 32px;*/
    }

    #imgtag
    {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: center;
    }

</style>
<?php //echo $this->renderPartial($this->path_view.'_headerPrint'); ?>
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
                    <table width="100%" border="1">
                        <tr>
                            <td align="left" valign="middle" colspan="4" style="font-weight:bold"><b><div class="judulcontent"> PERIKSA FISIK </div></b></td>
                        </tr>
                    </table>
                    <br><br>
                    <table width="100%" class="content" style="border: none;">   
                        <tr>
                            <th colspan="2" style="text-align:left;">
                                <h6>DATA PEMERIKSAAN</h6>
                            </th>
                            <th>

                            </th>
                            <th colspan="2" style="text-align:left;">
                                <h6>KEPALA LEHER</h6>
                            </th>
                        </tr>
                        <tr>
                            <td>Tanggal Periksa</td>
                            <td><?php echo MyFormatter::formatDateTimeId($modPemeriksaanFisik->tglperiksafisik); ?></td>
                            <td>&nbsp;</td>
                            <td></td>
                            <td>
                                <?php
                                if ($modPemeriksaanFisik->leher_anemia) {
                                    echo "Anemia";
                                } elseif ($modPemeriksaanFisik->leher_leterus) {
                                    echo "Leterus";
                                } elseif ($modPemeriksaanFisik->leher_cyanosis) {
                                    echo "Cyanosis";
                                } elseif ($modPemeriksaanFisik->leher_dyspneu) {
                                    echo "Dyspneu";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Keadaan Umum</td>
                            <td><?php echo $modPemeriksaanFisik->keadaanumum ?></td>
                            <td>&nbsp;</td>
                            <td>Reflek Pupil</td>
                            <td>
                                <?php
                                if ($modPemeriksaanFisik->leher_reflekpupil == true) {
                                    echo "Positif";
                                } elseif ($modPemeriksaanFisik->leher_reflekpupil == false) {
                                    echo "Negatif";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Dokter</td>
                            <td><?php
                                if (!empty($modPemeriksaanFisik->pegawai_id)) {
                                    echo $modPemeriksaanFisik->pegawai->namaLengkap;
                                } else {
                                    echo "-";
                                }
                                ?></td>
                            <td>&nbsp;</td>
                            <td>Pupil</td>
                            <td><?php echo $modPemeriksaanFisik->leher_pupil ?></td>
                        </tr>
                        <tr>
                            <td>Perawat</td>
                            <td><?php echo $modPemeriksaanFisik->paramedis_nama; ?></td>
                            <td>&nbsp;</td>
                            <td>Nasal</td>
                            <td><?php echo $modPemeriksaanFisik->leher_nasal; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>Orofans</td>
                            <td><?php echo $modPemeriksaanFisik->leher_orofans; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>Pembesaran KGB</td>
                            <td><?php
                                if ($modPemeriksaanFisik->leher_kelgetahbening_teraba == true) {
                                    echo "Positif";
                                } elseif ($modPemeriksaanFisik->leher_kelgetahbening_teraba == false) {
                                    echo "Negatif";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>Pembesaran Kelenjar Thyroid</td>
                            <td><?php
                                if ($modPemeriksaanFisik->leher_kelenjartiroid_teraba == true) {
                                    echo "Positif";
                                } elseif ($modPemeriksaanFisik->leher_kelenjartiroid_teraba == false) {
                                    echo "Negatif";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>JVP</td>
                            <td><?php
                                if ($modPemeriksaanFisik->leher_jvp == true) {
                                    echo "Meningkat";
                                } elseif ($modPemeriksaanFisik->leher_jvp == false) {
                                    echo "Tidak Meningkat";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>Lain - Lain</td>
                            <td><?php
                                echo $modPemeriksaanFisik->leher_lainlain
                                ?></td>
                        </tr>
                    </table>
                    <br><br>
                    <table width="100%" border="1">
                        <tr>
                            <th colspan="2" style="text-align:left;">
                                <h6>Tanda Vital</h6>
                            </th>
                            <th>
                                &nbsp;
                            </th>
                            <th colspan="2" style="text-align:left;">
                                <h6>Glasgow Coma Scale</h6>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                Tekanan Darah
                            </td>
                            <td><?php echo (isset($modPemeriksaanFisik->tekanandarah) ? $modPemeriksaanFisik->tekanandarah : " - ") . ' /MmHg'; ?></td>
                            <td>&nbsp;</td>
                            <td>GCS Eye</td>
                            <td><?php echo $modPemeriksaanFisik->gcs_eye; ?></td>
                        </tr>
                        <tr>
                            <td>
                                Mean Arteri Pressure
                            </td>
                            <td><?php echo $modPemeriksaanFisik->meanarteripressure; ?></td>
                            <td>&nbsp;</td>
                            <td>GCS Verbal</td>
                            <td><?php echo $modPemeriksaanFisik->gcs_verbal; ?></td>
                        </tr>
                        <tr>
                            <td>
                                Detak Nadi
                            </td>
                            <td><?php echo $modPemeriksaanFisik->detaknadi . '/Menit'; ?></td>
                            <td>&nbsp;</td>
                            <td>GCS Motorik</td>
                            <td><?php echo $modPemeriksaanFisik->gcs_motorik; ?></td>
                        </tr>
                        <tr>
                            <td>
                                Denyut Jantung
                            </td>
                            <td><?php echo $modPemeriksaanFisik->denyutjantung; ?></td>
                            <td>&nbsp;</td>
                            <td>Nilai CGS</td>
                            <td><?php echo $modPemeriksaanFisik->namaGCS; ?></td>
                        </tr>
                        <tr>
                            <td>Pernapasan</td>
                            <td><?php echo $modPemeriksaanFisik->pernapasan . '/Menit' ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>Suhu Tubuh</td>
                            <td><?php echo $modPemeriksaanFisik->suhutubuh ?>&#176 Celcius</td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>Tinggi Badan/<br>Berat Badan</td>
                            <td><?php echo $modPemeriksaanFisik->tinggibadan_cm . ' Cm /' ?><br><?php echo $modPemeriksaanFisik->beratbadan_kg . ' Kg'; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>Index Masa Tubuh</td>
                            <td><?php echo (isset($modPemeriksaanFisik->indexmassatubuh) ? $modPemeriksaanFisik->indexmassatubuh : " - "); ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>Kelainan Pada Bag. Tubuh</td>
                            <td><?php echo $modPemeriksaanFisik->kelainanpadabagtubuh; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>Reflek Cahaya</td>
                            <td><?php echo $modPemeriksaanFisik->tandavital_reflekcahaya; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>SPO2</td>
                            <td><?php echo $modPemeriksaanFisik->tandavital_spo2; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2"></td>
                        </tr>
                    </table>

                    <br><br>
                    <table width="100%" border="1">
                        <tr>
                            <th colspan="2" style="text-align:left;">
                                <h6>Pemeriksaan Thorax</h6>
                            </th>
                            <th>
                                &nbsp;
                            </th>
                            <th colspan="2" style="text-align:left;">
                                <h6>Cardio</h6>
                            </th>
                        </tr>
                        <tr>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->inspeksi; ?></td>
                            <td>&nbsp;</td>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->cardio_inspeksi; ?></td>
                        </tr>
                        <tr>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->palpasi; ?></td>
                            <td>&nbsp;</td>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->cardio_palpasi; ?></td>
                        </tr>
                        <tr>
                            <td>Perkusi</td>
                            <td><?php echo $modPemeriksaanFisik->perkusi; ?></td>
                            <td>&nbsp;</td>
                            <td>Perkusi</td>
                            <td><?php echo $modPemeriksaanFisik->cardio_perkusi; ?></td>
                        </tr>
                        <tr>
                            <td>Auskultasi</td>
                            <td><?php echo $modPemeriksaanFisik->auskultasi; ?></td>
                            <td>&nbsp;</td>
                            <td>Auskultasi</td>
                            <td><?php echo $modPemeriksaanFisik->cardio_auskultasi; ?></td>
                        </tr>
                    </table>
                    <br><br>
                    <table width="100%" border="1">
                        <tr>
                            <th colspan="2" style="text-align:left;">
                                <h6>Pulmo</h6>
                            </th>
                            <th>

                            </th>
                            <th colspan="2" style="text-align:left;">
                                <h6>Abdomen</h6>
                            </th>
                        </tr>
                        <tr>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->pulmo_inspeksi; ?></td>
                            <td>&nbsp;</td>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->abd_inspeksi; ?></td>
                        </tr>
                        <tr>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->pulmo_palpasi; ?></td>
                            <td>&nbsp;</td>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->abd_palpasi; ?></td>
                        </tr>
                        <tr>
                            <td>Perkusi</td>
                            <td><?php echo $modPemeriksaanFisik->pulmo_perkusi; ?></td>
                            <td>&nbsp;</td>
                            <td>Perkusi</td>
                            <td><?php echo $modPemeriksaanFisik->abd_perkusi; ?></td>
                        </tr>
                        <tr>
                            <td>Auskultasi</td>
                            <td><?php echo $modPemeriksaanFisik->pulmo_auskultasi; ?></td>
                            <td>&nbsp;</td>
                            <td>Auskultasi</td>
                            <td><?php echo $modPemeriksaanFisik->abd_auskultasi; ?></td>
                        </tr>
                    </table>
                    <br><br>
                    <table width="100%" border="1">
                        <tr>
                            <th colspan="2" style="text-align:left;">
                                <h6>Obstetri</h6>
                            </th>
                            <th>

                            </th>
                            <th colspan="2" style="text-align:left;">
                                <h6>Genitalia</h6>
                            </th>
                        </tr>
                        <tr>
                            <td>RFS</td>
                            <td><?php echo $modPemeriksaanFisik->tinggifundus_uteri . ' cm'; ?></td>
                            <td>&nbsp;</td>
                            <td>Inspeksi</td>
                            <td><?php echo $modPemeriksaanFisik->genitalia_inspeksi; ?></td>
                        </tr>
                        <tr>
                            <td>HLS</td>
                            <td><?php echo $modPemeriksaanFisik->obs_his; ?></td>
                            <td>&nbsp;</td>
                            <td>Palpasi</td>
                            <td><?php echo $modPemeriksaanFisik->genitalia_palpasi; ?></td>
                        </tr>
                        <tr>
                            <td>Posisi</td>
                            <td><?php echo $modPemeriksaanFisik->leher_posisijanin; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Denyut</td>
                            <td><?php echo $modPemeriksaanFisik->denyutjantung_janin . '/menit'; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Vagina Toucher</td>
                            <td><?php echo $modPemeriksaanFisik->obs_vaginatoucher; ?></td>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>	
                    <br><br>
                    <table width="100%" class="content" border="1">
                        <tr>
                            <th width="70%" colspan="1" style="text-align:left;">
                                <h6>Pemeriksaan Anggota Tubuh</h6>
                            </th>		
                            <th  width="30%"  colspan="1" style="text-align:left;">
                                <h6>Tabel Pemeriksaan</h6>
                            </th>
                        </tr>
                        <tr>
                            <td width="70%">
                                <div align="center" id="imgtag">
                                    <img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh() . $modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
                                    <div id="tagbox"></div>
                                </div>
                            </td>
                            <td width="30%" style="vertical-align:top;">

                                <table border="1" width="100%">
                                        <!--<tr>
                                                <td colspan="3"><p style="margin: 0; text-align: center;"><b>Anatomi Tubuh</b></p></td>
                                        </tr>-->
                                    <?php if (count((array)$modPemeriksaanGambar) > 0) { ?>
                                        <tr>
                                            <td><p style="margin: 0; text-align: center;"><b>No.</b></p></td>
                                <td><b>Bagian Tubuh</b></td>
                                <td><b>Keterangan</b></td>
                            </tr>
                            <?php foreach ($modPemeriksaanGambar as $i => $v) { ?>
                                <tr>
                                    <td><p style="margin: 0; text-align: center;"><?= $i + 1; ?></p></td>
                                <td><?= $v->bagiantubuh->namabagtubuh; ?></td>
                                <td><?= $v->keterangan_periksa_gbr; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
            </td>
        </tr>
</table>
<br><br>

<br><br>
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
<?php
if (!empty($modPemeriksaanGambar)) {
    foreach ($modPemeriksaanGambar as $i => $v) {
        ?>
                titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y . ',' . $i; ?>);
    <?php
    }
}
?>
    }
    $(document).ready(function () {
        loadTitikSesudahSimpan();
    });
</script>
