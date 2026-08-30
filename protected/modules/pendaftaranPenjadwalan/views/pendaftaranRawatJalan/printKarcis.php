<style>
   /* .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
    }
    body{
        width:100%;
    }
    .borderers {
        border-bottom: 1px dashed black;
    }
    
    .tab-det td {
        vertical-align: top;
    } */
   TD, P SPAN{
    font-family: "Arial" !important;
    font-size: 8pt !important;
    vertical-align: top;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo'); ?>

<table style="width: 100%; border: none; margin-left:10pt; height: 100vh;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo strtoupper($judul_print) ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
             DATA PASIEN
        </td>
    </tr>
    <?php // if($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
    <tr>
        <td>No. Antrian Poliklinik</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
    </tr>
    <?php if (!empty($modPendaftaran->nursestation_id)): ?>
    <tr>
        <td>No. Antrian Nurse Station</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->nourut_antriannursestation; ?></b></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><b><?php echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); ?></b></td>
    </tr>
    <tr>
        <td>Perkiraan Pelayanan</td>
        <td>:</td>
        <td><b><?php echo isset($modPendaftaran->tglakandilayani) ? MyFormatter::formatDateTimeId($modPendaftaran->tglakandilayani) : ""; ?></b></td>
    </tr>
    <tr>
        <td>Status Pasien</td>
        <td>:</td>
        <td><?php 
            if($modPendaftaran->statuspasien == Params::STATUSPASIEN_BARU){
                echo "PASIEN BARU";
            }else{
                echo "PASIEN LAMA";
            }
        ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>:</td>
        <td><?php  echo $modPasien->tanggal_lahir; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pegawai->NamaLengkap; ?></td>
    </tr>
    cara bayar , penjamin, dan Status Pasien
    <tr>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
    </tr>
    <tr>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
    </tr>
    <tr>
        <td>Status Kunjungan Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->statuspasien??"-"; ?></td>
    </tr>
    <?php
        $nota = $modPendaftaran->no_pendaftaran . '001';
        $tindakan = TindakanpelayananT::model()->find(" pendaftaran_id = " . $modPendaftaran->pendaftaran_id);

        if(!empty($tindakan)) {
            if(!empty($tindakan->nopelayanan)) {
                $nota = $modPendaftaran->no_pendaftaran .  str_pad($tindakan->nopelayanan + 1, 3,"0",STR_PAD_LEFT);
            }
        }
    ?>
    <tr>
        <td>No. Nota</td>
        <td>:</td>
        <td><?php echo $nota; ?></td>
    </tr>
    <tr>
        <td colspan="3" class="borderers"></td>
    </tr>
<!--<tr>
        <td colspan="3" style="text-align: center;">KUNJUNGAN PASIEN</td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php // echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php // echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php // echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Karcis</td>
        <td>:</td>
        <td><?php // echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
    </tr>
    <tr>
        <td>Harga Karcis</td>
        <td>:</td>
        <td><?php // echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-")?></td>
    </tr>-->
    
</table>
<!--<table style="width: 100%; border: none;">
    <tr>
        <td width="50%"></td>
        <td style="text-align: center;"><?php 
//        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
//        echo $ruangan->ruangan_nama;
        ?></td>
    </tr>
    <tr height="60px" valign="bottom">
        <td></td>
        <td style="text-align: center;"><?php // echo !empty($modPegawai)?$modPegawai->nama_pegawai:"-"; ?></td>
    </tr>
</table>-->

    <?php // }else{ ?>
<!--<tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><b><?php // echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php // echo $modPendaftaran->no_urutantri; ?></b></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><b><?php // echo $modPendaftaran->no_pendaftaran; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php // echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><?php // echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php // echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
    </tr>-->
    <!--</table>-->
    <?php // } ?>
<!--<div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php // echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
    <div class="barcode-label"><?php // echo $modPendaftaran->pendaftaran_id; ?></div>
</div>-->