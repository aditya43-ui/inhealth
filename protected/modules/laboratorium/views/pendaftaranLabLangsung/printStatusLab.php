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
 //echo $this->renderPartial('application.views.headerReport.headerRincianV2');
?>
 
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
			<div class="judulcontent"><?php echo $judul_print ?>  </div>
                        <table class="status">
       
         <tr>
            <td align="center" valig="middle" colspan="3">
                Data Pasien
            </td>
        </tr>
        <tr>
            <td width="130">No. Pendaftaran</td>
            <td>:</td>
            <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
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
            <td>Cara Bayar / Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?>/<?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        </tr>
        <?php 
            if(count((array)$modPasienMasukPenunjangs) > 0){
                foreach($modPasienMasukPenunjangs AS $i => $penunjang){
                ?>
                    <tr>
                        <td align="center" valign="middle" colspan="3">
                    <u><b><?php echo $penunjang->ruangan->ruangan_nama; ?></b></u>
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
                        <td>Ruangan Asal</td>
                        <td>:</td>
                        <td><?php 
                        $ruangan = RuanganM::model()->findByPk($penunjang->ruanganasal_id);
                        echo $ruangan->ruangan_nama; 
                        
                        ?></td>
                    </tr>
                    <tr>
                        <td>Dokter Pemeriksa</td>
                        <td>:</td>
                        <td><?php echo empty($penunjang->pegawai) ? "-" : $penunjang->pegawai->NamaLengkap; ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Tarif</td>
                        <td>:</td>
                        <td>
                            <?php 
                                echo (!empty($penunjang->pasienkirimkeunitlain) && $penunjang->pasienkirimkeunitlain->is_cyto == 1) ? "Cyto" : "Biasa"; 
                            ?>
                        </td>
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
                    <tr>
                    <td>Tgl. Pemeriksaan</td>
                        <td>:</td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($penunjang->tglmasukpenunjang); ?></td>
                    </tr>
                    <tr>
                        <td>Dokter Pengririm</td>
                        <td>:</td>
                        <td><?php echo isset($modPendaftaran->pegawai->NamaLengkap) ? $modPendaftaran->pegawai->NamaLengkap : "-"; ?></td>
                    </tr>
                    <tr>
                        <td>Diagnosa</td>
                        <td>:</td>
                        <td><?php echo !empty($diagnosa_nama) ? $diagnosa_nama : "-"; ?></td>
                    </tr>
<!--<tr>
                        <td>Status Pembayaran Karcis</td>
                        <td>:</td>
                        <td>Belum Dibayar  Default dulu</td>
                    </tr>-->
                    <tr>
                        
                        <td colspan="3" align="center">
                            <div align="center" valign="middle"><b><u>Daftar Pemeriksaan</u></b></div>
                            <table border="1" style="margin-top: 10px;text-align:center;width:360px;">
                                <thead>
                                <td><b>No.</b></td>
                                <td><b>Pemeriksaan</b></td>
                                <!-- <td><b>Tarif</b></td> -->
                                </thead>
                                <?php 
                                $total_tarif = 0;
                                foreach ($daftartindakan[$i] as $i=>$daftartindakans){ 
                                ?>
                                <tr>
                                    <td><?php echo ($i+1)."."; ?></td>
                                    <td><?php echo $daftartindakans->daftartindakan->daftartindakan_nama; ?></td>
                                    <td hidden><?php 
                                    if($daftartindakans->cyto_tindakan==true){
                                        $tarif_tindakan = ($daftartindakans->tarifcyto_tindakan * $daftartindakans->qty_tindakan);
                                    }else{
                                        $tarif_tindakan = ($daftartindakans->tarif_satuan * $daftartindakans->qty_tindakan);
                                    }
                                    $total_tarif += $tarif_tindakan;
                                    echo $format->formatUang($tarif_tindakan); ?></td>
                                </tr>
                                <?php } ?>
                                <tr hidden>
                                    <td colspan="2" align="center"><b>Total</b></td>
                                    <td><?php echo $format->formatUang($total_tarif); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
        
                <?php    
                }
        } ?>
        
        
        
    </table>
    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>
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
    <?php  // if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php // }  ?>
</div>
    