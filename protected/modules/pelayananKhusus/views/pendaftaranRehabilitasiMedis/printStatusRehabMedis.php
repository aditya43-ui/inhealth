<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>
<?php echo $this->renderPartial('rehabMedis.views.pendaftaranRehabilitasiMedis._headerPrint'); ?>
    <table class="status" width="100%">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
         <tr>
            <td align="center" valig="middle" colspan="3">
                 Data Pasien
            </td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><strong><?php echo $modPendaftaran->no_pendaftaran; ?></strong></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medis</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo date("d-m-Y", strtotime($modPasien->tanggal_lahir)); ?>/<?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?>/<?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        </tr>
        
        <tr>
            <td align="center" valig="middle" colspan="3">
                <u><?php echo $modPasienMasukPenunjang->ruangan->ruangan_nama; ?></u>
            </td>
        </tr>
        <tr>
            <td>No. Masuk Penunjang</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->no_masukpenunjang; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->kelaspelayanan->kelaspelayanan_nama; ?></td>
        </tr>
        <tr>
            <td>Dokter Pemeriksa</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->pegawai->NamaLengkap; ?></td>
        </tr>
        <tr>
            <td>Karcis</td>
            <td>:</td>
            <td>
                <?php echo (isset($modTindakans->karcis->karcis_nama) ? $modTindakans->karcis->karcis_nama : "-"); ?>
            </td>
        </tr>
        <tr>
            <td>Harga Karcis</td>
            <td>:</td>
            <td>
                <?php 
                echo (isset($modTindakans->tarif_satuan) ? $format->formatUang($modTindakans->tarif_satuan * $modTindakans->qty_tindakan) : "0");
                echo " ".(!empty($modTindakans->tindakansudahbayar_id) ? "(Lunas)" : "(Belum Lunas)");
                ?>
            </td>
        </tr>
<!--                    <tr>
            <td>Status Pembayaran Karcis</td>
            <td>:</td>
            <td>Belum Dibayar  Default dulu</td>
        </tr>-->
        <tr>
            <td colspan="3" align="center">
                            <div align="center" valign="middle"><strong><u>Daftar Pemeriksaan</u></strong></div>
                            <table border="1" style="margin-top: 10px;text-align:center;width:400px;">
                                <thead>
                                <td><strong>No.</strong></td>
                                <td><strong>Pemeriksaan</strong></td>
                                <td><strong>Tarif</strong></td>
                                </thead>
                                <?php 
                                $total_tarif = 0;
                                foreach ($daftartindakan as $i=>$daftartindakans){ 
                                ?>
                                <tr>
                                    <td><?php echo ($i+1)."."; ?></td>
                                    <td><?php echo $daftartindakans->daftartindakan->daftartindakan_nama; ?></td>
                                    <td><?php 
                                    $tarif_tindakan = ($daftartindakans->tarif_satuan * $daftartindakans->qty_tindakan);
                                    $total_tarif += $tarif_tindakan;
                                    echo $format->formatUang($tarif_tindakan); ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" align="center"><strong>Total</strong></td>
                                    <td><?php echo $format->formatUang($total_tarif); ?></td>
                                </tr>
                            </table>
                        </td>
        </tr>
        
    </table>
    <div style="border: 0px solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=" >  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>