<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;
    }
</style>
<?php //echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>

<table style="width: 100%; border: none;">
    <tr>
        <td rowspan='2'><img src="<?php echo Yii::app()->getBaseUrl('webroot').'/images/BPJS.jpg'; ?>" width="200"></td>
        <td colspan='5' align='center' style="font-weight:bold"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; ?></td>
        <td rowspan='2'><img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?>" width="120"></td>
    </tr>
    <tr>
        <td colspan='5' align='center' style="font-weight:bold"></td>
    </tr>
    <tr>
        <td width="18%">No. SEP</td>
        <td width="2%">:</td>
        <td width="25%"><?php echo $modSep->nosep; ?></td>
        <td width="5%"></td>
        <td width="18%"></td>
        <td width="2%"></td>
        <td width="30%"></td>
    </tr>
    <tr>
        <td>Tgl. SEP</td>
        <td>:</td>
        <td><?php echo $modSep->tglsep; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No. Kartu</td>
        <td>:</td>
        <td><?php echo $modSep->nokartuasuransi; ?></td>
        <td></td>
        <td>Peserta</td>
        <td>:</td>
        <td><?php echo isset($modJenisPeserta->jenispeserta_nama)?$modJenisPeserta->jenispeserta_nama:'-';?></td>
    </tr>
    <tr>
        <td>Nama Peserta</td>
        <td>:</td>
        <td><?php echo $modAsuransiPasienBpjs->namapemilikasuransi;?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>:</td>
        <td><?php echo $modPasien->tanggal_lahir; ?></td>
        <td></td>
        <td>COB</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $modPasien->jeniskelamin; ?></td>
        <td></td>
        <td>Jenis Rawat</td>
        <td>:</td>
        <td><?php echo LookupM::model()->findByAttributes(array('lookup_type'=>'jenispelayanan','lookup_value'=>$modSep->jnspelayanan))->lookup_name; ?></td>
    </tr>
    <tr>
        <td>Poli Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
        <td></td>
        <td>Kelas Rawat</td>
        <td>:</td>
        <td><?php echo $modAsuransiPasienBpjs->kelastanggunganasuransi_id; ?></td>
    </tr>
    <tr>
        <td>Asal Faskes Tk. I<td>
        <td>:</td>
        <td><?php echo ' - '; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Diagnosa Awal</td>
        <td>:</td>
        <td><?php echo $modSep->diagnosaawal; ?></td>
        <td></td>
        <td>Pasien/<br>Keluarga Pasien</td>
        <td></td>
        <td>Petugas<br>Bpjs Kesehatan</td>
    </tr>
    <tr>
        <td>Catatan</td>
        <td>:</td>
        <td><?php echo $modSep->catatansep; ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 8pt !important;">*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan<br>*SEP bukan sebagai bukti penjaminan peserta</td>
        <td></td>
        <td colspan="3">______________________________________</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td ><img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?>" width="120"></td>
    </tr>

</table>
