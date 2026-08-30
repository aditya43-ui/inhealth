<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    body{
        width: 10cm;
        height: 11cm;
    }
    th, td, div{
        font-family:Times New Roman;
        font-size: 9.7pt;
        line-height: 12px;
    }
    
</style>
<?php
$format = new MyFormatter;
 echo $this->renderPartial('application.views.headerReport.headerRincianV2');
?>
    
    <table class="status" >
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
            <td width="130">No. Pendaftaran</td>
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
        <?php 
            if(count($modPasienMasukPenunjangs) > 0){
                foreach($modPasienMasukPenunjangs AS $i => $penunjang){
                ?>
                    <tr>
                        <td align="center" valign="middle" colspan="3">
                    <u><strong><?php echo $penunjang->ruangan->ruangan_nama; ?></strong></u>
                        </td>
                    </tr>
                    <tr>
                        <td>No. Urut Periksa</td>
                        <td>:</td>
                        <td><?php echo $penunjang->no_urutperiksa; ?></td>
                    </tr>
                    <tr>
                        <td>No. Masuk Penunjang</td>
                        <td>:</td>
                        <td><?php echo $penunjang->no_masukpenunjang; ?></td>
                    </tr>
                    <tr>
                        <td>Kelas Pelayanan</td>
                        <td>:</td>
                        <td><?php echo $penunjang->kelaspelayanan->kelaspelayanan_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Dokter Pemeriksa</td>
                        <td>:</td>
                        <td><?php echo $penunjang->pegawai->NamaLengkap; ?></td>
                    </tr>
                    <tr>
                        <td>Karcis</td>
                        <td>:</td>
                        <td>
                            <?php echo (isset($modTindakans[$i]->karcis->karcis_nama) ? $modTindakans[$i]->karcis->karcis_nama : "-"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tarif Karcis</td>
                        <td>:</td>
                        <td>
                            <?php 
                            echo (isset($modTindakans[$i]->tarif_satuan) ? $format->formatUang($modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan) : "0");
                            echo " ".(!empty($modTindakans[$i]->tindakansudahbayar_id) ? "(Lunas)" : "(Belum Lunas)");
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
                            <table border="1" style="margin-top: 10px;text-align:center;width:360px;">
                                <thead>
                                <td><strong>No.</strong></td>
                                <td><strong>Pemeriksaan</strong></td>
                                <td><strong>Tarif</strong></td>
                                </thead>
                                <?php 
                                $total_tarif = 0;
                                foreach ($daftartindakan[$i] as $i=>$daftartindakans){ 
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
                    
        
                <?php    
                }
        } ?>
        
        
        
    </table>
    <div style="border: 0px solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=" >  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>