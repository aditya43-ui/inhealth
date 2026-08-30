<style>
    .border_c{
        border:1px solid;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .spasi{
        height:10px;
    }

    .table_isi, tr, td{
        padding:5px;
    }
    .borderclass {
        border: 1px solid black;
    }
    .pad {
        padding:20px;
    }
</style>
<?php 
    $this->widget('bootstrap.widgets.BootAlert');

    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
    $konfig = KonfigsystemK::model()->find();

    $titleDetail = "RM. 009.5";
    $header = "KRITERIA PASIEN KELUAR NICU";
?>
<div class="pad">
    <?php echo $this->renderPartial($this->path_view.'_header', array('pendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'header' => $header, 'titleDetail' => $titleDetail)); ?>
    <br>
    <table border="1px" width="100%">
        <tr>
            <td colspan="2">DPJP : <?php echo empty($modKriteria->dpjp) ? '-' : $modKriteria->dpjp->namaLengkap; ?></td>
        </tr>
        <tr>
            <td colspan="2">Dokter Penanggung Jawab ICU : <?php echo empty($modKriteria->pegawai) ? '-' : $modKriteria->pegawai->namaLengkap; ?></td>
        </tr>
        <tr>
            <td colspan="2">Ruangan : <?php echo empty($modKriteria->ruangan) ? '-' : $modKriteria->ruangan->ruangan_nama; ?></td>
        </tr>

        <tr>
            <td style="text-align: center;" colspan="2">KETERANGAN</td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>A</b></h3>
                <?php if($modKriteria->is_a){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Bayi klinik baik, tangis spontan keras, bayi bugar
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>B</b></h3>
                <?php if($modKriteria->is_b){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Bayi menunjukan TTV stabil tanpa alat bantu pernapasan dan oksigen
                </p>
                <div class="row-fluid">
                    <div style="display: flex">
                        <div class="control-group">
                            Nadi :
                            <?php echo empty($modKriteria->nadi) ? '-' : $modKriteria->nadi; ?>
                        </div>
                        <div class="control-group">
                            Spo2 :
                            <?php echo empty($modKriteria->spo2) ? '-' : $modKriteria->spo2; ?>
                        </div>
                    </div>
                    <div style="display: flex">
                        <div class="control-group">
                            Pernafasan :
                            <?php echo empty($modKriteria->pernafasan) ? '-' : $modKriteria->pernafasan; ?>
                        </div>
                        <div class="control-group">
                            Suhu :
                            <?php echo empty($modKriteria->suhu) ? '-' : $modKriteria->suhu; ?>
                        </div>
                    </div>
                    <?php if($modKriteria->is_skordown){ ?>
                        <p>[&#10003;]Skor Down : < 3</p>
                    <?php } else { ?>
                        <p>[&emsp;]Skor Down : < 3</p>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>C</b></h3>
                <?php if($modKriteria->is_c){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Bayi mampu minum sesuai kebutuhan
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>D</b></h3>
                <?php if($modKriteria->is_d){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Sudah tidak ada kebutuhan terapi dan nutrisi parenteral
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>E</b></h3>
                <?php if($modKriteria->is_e){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Penambahan berat badan dengan asupan per oral telah terlihat
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>F</b></h3>
                <?php if($modKriteria->is_f){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Nilai laboratorium (gula darah, bilirubin, analisa gas darah) telah masuk kisaran normal
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; width: 120px;">
                <h3><b>G</b></h3>
                <?php if($modKriteria->is_g){ ?>
                    <p>[&#10003;]</p>
                <?php } else { ?>
                    <p>[&emsp;]</p>
                <?php } ?>
            </td>
            <td>
                <p>
                    Orang tua mampu merawat, sehingga pasien sudah tidak memerlukan perawatan intensive atau manfaatnya kecil
                </p>
            </td>
        </tr>
    </table>
    <br>
    <p>
        Berdasarkan kondisi diatas maka pasien tersebut memenuhi kriteria untuk keluar dari <b>Ruang NICU</b>
    </p>
    <br>
    <table width="100%">
        <tr>
            <td width="25%" style="text-align:center;">Sidoarjo, <?php echo MyFormatter::formatdatetimeforuser(date('Y-m-d')); ?> / Jam : <?php echo date('H:i:s'); ?> </td>
            <td width="25%" style="text-align:center;"></td>                      
            <td width="25%" style="text-align:center;"></td>                      
        </tr>
        <tr>
            <td width="25%" style="text-align:center;">DPJP</td>
            <td width="25%" style="text-align:center;">Dokter Penanggung Jawab NICU</td>
            <td width="25%" style="text-align:center;">Perawat NICU</td>
        </tr>
        <tr>
            <td colspan="3">
                <div style="min-height:50px;">
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;">( <?php echo empty($modKriteria->dpjp) ? '-' : $modKriteria->dpjp->namaLengkap; ?> )</td>
            <td style="text-align:center;">( <?php echo empty($modKriteria->pegawai) ? '-' : $modKriteria->pegawai->namaLengkap; ?> )</td>
            <td style="text-align:center;">( <?php echo empty($modKriteria->perawat) ? '-' : $modKriteria->perawat->namaLengkap; ?> )</td>
        </tr>
    </table>
</div>