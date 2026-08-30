<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 12pt !important;
    }

    body {
        width: 21.7cm;
    }

    .barcode {
        width: 100px;
        border: 0px solid;
        margin: 0px;
        padding: 0px;
        /*top:8px;*/
        overflow: hidden;
        position: absolute;
        filter: gray;
        z-index: 2;
    }

    .sep_id {
        width: 100px;
        margin-top: 10px;
        z-index: 1;
        text-align: center;
    }
</style>
<?php //echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); 
?>

<table width="100%">
    <tr>
        <td rowspan='2' style="vertical-align:top"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/bpjsNew.png'; ?>" width="100" height="35"></td>
        <td colspan='5' align='center' style="font-weight:bold"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; ?></td>
        <td rowspan='2' style="vertical-align:top"><img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit ?>" width="35" height="35"></td>
    </tr>
    <tr>
        <td colspan='5' align='center' style="font-weight:bold"></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td width="15%">No. SEP</td>
        <td width="2%">:</td>
        <td width="40%"><b style="font-size: 13pt !important;"><?php echo $modSep->nosep; ?></b></td>
        <td width="5%"></td>
        <td width="15%">Peserta</td>
        <td width="2%">:</td>
        <td width="35%"><?php echo isset($modJenisPeserta->jenispeserta_nama) ? $modJenisPeserta->jenispeserta_nama : '-'; ?></td>
    </tr>
    <tr>
        <td>Tgl. SEP</td>
        <td>:</td>
        <td><?php echo $modSep->tglsep; ?></td>
        <td></td>
        <td>COB</td>
        <td>:</td>
        <td><?php echo $modSep->no_asuransi_cob . "-" . $modSep->namaasuransi_cob; ?></td>
    </tr>
    <tr>
        <td>No. Kartu</td>
        <td>:</td>
        <td><?php echo $modSep->nokartuasuransi; ?> ( <b style="font-size: 13pt !important;">MR. <?php echo $modPasien->no_rekam_medik; ?></b> )</td>
        <td></td>
        <td>Jenis Rawat</td>
        <td>:</td>
        <td><?php echo ($modSep->jnspelayanan == 2) ? "Rawat Jalan" : "Rawat Inap"; ?></td>
    </tr>
    <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?php echo $modAsuransiPasienBpjs->namapemilikasuransi; ?></td>
        <td></td>
        <td>Kelas Rawat</td>
        <td>:</td>
        <!--<td><?php // echo $modAsuransiPasienBpjs->kelastanggunganasuransi_id; 
                ?></td>-->
        <td><?php echo $modAsuransiPasienBpjs->kelastanggunganasuransi->kelasbpjs_id ?></td>
        <td></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>:</td>
        <td><?php echo $modPasien->tanggal_lahir . " Kelamin :" . $modPasien->jeniskelamin . ""; ?></td>
        <td></td>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php $modSep->penjamin_lakalantas; ?></td>
    </tr>

    <tr>
        <td>Poli Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
        <td></td>
        <!--        <td colspan="3" rowspan="3"><div>
                <img src="index.php?r=barcode/myBarcodeSep&code=<?php echo $modSep->nosep; ?>&is_text=" style="transform:scale(1.0)">
            </div></td>-->
        <td colspan="3" style="font-size: 11pt !important;">Pasien/Keluarga Pasien</td>
        <!--        <td></td>
        <td></td>-->
    </tr>
    <tr>
        <td width="18%">Faskes Perujuk</td>
        <td width="2%">:</td>
        <td width="40%">
            <?php
            if (empty($modAsuransiPasienBpjs->nama_feskestk1) || $modAsuransiPasienBpjs->nama_feskestk1 == "") {
                $modPendaftaran = PendaftaranT::model()->findByAttributes(array('sep_id' => $modSep->sep_id));
                if (!empty($modPendaftaran->rujukan_id)) {
                    $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
                    echo $modRujukan->nama_perujuk;
                }
            } else {
                echo $modAsuransiPasienBpjs->nama_feskestk1;
            }
            ?>
        </td>
        <td></td>

        <!--        <td width="18%"></td>
        <td width="2%"></td>
        <td width="30%"></td>-->
    </tr>
    <tr>
        <td>Diagnosa Awal</td>
        <td>:</td>
        <td style="text-align:justify;font-size: 10pt !important;"><?php echo (empty($modSep->nama_diagnosaawal)) ? $modSep->diagnosaawal : $modSep->nama_diagnosaawal; ?></td>
        <td></td>
        <td colspan="3">___________________</td>
        <!--        <td></td>
        <td></td>
        <td></td>-->
    </tr>
    <tr>
        <td>Catatan</td>
        <td>:</td>
        <td><?php echo $modSep->catatansep; ?></td>
        <td></td>
        <!--<td colspan="3" style="font-size: 11pt !important;">Pasien/Keluarga Pasien</td>-->
        <td colspan="3"></td>
        <!--        <td></td>
        <td></td>-->
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 9pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
        <td></td>
        <td colspan="3">
            <img src="index.php?r=barcode/myBarcodeSep&code=<?php echo $modSep->nosep; ?>&is_text=" style="transform:scale(1.3)">
        </td>
    </tr>

</table>
<!-- <table width="100%">
    <tr>
        <td>
            <div>
                <img src="index.php?r=barcode/myBarcodeSep&code=<?php // echo $modSep->nosep; 
                                                                ?>&is_text=" style="transform:scale(1.0)">
            </div>
        </td>
        <td colspan="3"></td>
        <td colspan="3"></td>
    </tr>
</table> -->