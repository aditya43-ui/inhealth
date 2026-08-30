
<style>
   
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
              
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judul_print));
             ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
   <?php
$format = new MyFormatter;

$diagnosa_nama = '';
$keterangan = '';
if (count((array)$query) > 0) {
    $ket = [];
    foreach ($query as $key => $value) {
        if ($value->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA && empty($diagnosa_nama)) {
            $diagnosa_nama = $value->diagnosa_nama;
        }else{                                            
            $title = '- ' . $value->diagnosa_nama;
            array_push($ket, $title);
            $keterangan = implode("<br>",$ket);
        }
    }
    
    if (empty($diagnosa_nama)){
        $diagnosa_nama = $query[0]->diagnosa_nama;
        $keterangan = '';
    }
}else{
    $diagnosa_nama = '-';
    $keterangan = '';
}

// var_dump($diagnosa_nama);die;
?>
    <table class="status">
     
         <tr>
             <td align="center" valig="middle" colspan="3" style="text-decoration: underline;">
                 <br>
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
            <td>No. Rekam Medik</td>
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
            <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>/<?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?>/<?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <br>
                <u><?php echo isset($modPasienMasukPenunjang->ruangan->ruangan_nama) ? $modPasienMasukPenunjang->ruangan->ruangan_nama : "-"; ?></u>
            </td>
        </tr>
        <tr>
            <td>No. Masuk Penunjang</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->no_masukpenunjang) ? $modPasienMasukPenunjang->no_masukpenunjang : "-"; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->kelaspelayanan->kelaspelayanan_nama) ? $modPasienMasukPenunjang->kelaspelayanan->kelaspelayanan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan Asal</td>
            <td>:</td>
            <td><?php 
        //    $ruangan = RuanganM::model()->findByPk($modPasienMasukPenunjang->ruanganasal_id);
         //   echo isset($ruangan) ?$ruangan->ruangan_nama : "-"; ?>
            <?php echo isset($modPasienMasukPenunjang->ruanganasal->ruangan_nama) ? $modPasienMasukPenunjang->ruanganasal->ruangan_nama : "-"; ?>
        </td>
        </tr>
        <tr>
            <td>Dokter Pemeriksa</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->pegawai->NamaLengkap) ? $modPasienMasukPenunjang->pegawai->NamaLengkap : "-"; ?></td>
        </tr>
        <tr>
            <td>Jenis Tarif</td>
            <td>:</td>
            <td>
                <?php 
                    echo (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain) && $modPasienMasukPenunjang->pasienkirimkeunitlain->is_cyto == 1) ? "Cyto" : "Biasa"; 
                ?>
            </td>
        </tr>
        <tr>
            <td>Tgl. Pemeriksaan</td>
            <td>:</td>
            <td><?php echo isset($modPasienMasukPenunjang->tglmasukpenunjang) ? MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tglmasukpenunjang) : ""; ?></td>
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
        <?php /*
        <tr>
            <td>Karcis</td>
            <td>:</td>
            <td>
                <?php echo (isset($modTindakans->karcis->karcis_nama) ? $modTindakans->karcis->karcis_nama : "-"); ?>
            </td>
        </tr>
        <tr>
            <td>Tarif Karcis</td>
            <td>:</td>
            <td>
                <?php 
                echo (isset($modTindakans->tarif_satuan) ? $format->formatUang($modTindakans->tarif_satuan * $modTindakans->qty_tindakan) : "0");
                echo " ".(!empty($modTindakans->tindakansudahbayar_id) ? "(Lunas)" : "(Belum Lunas)");
                ?>
            </td>
        </tr>
         * 
         */ ?>
<!--<tr>
            <td>Status Pembayaran Karcis</td>
            <td>:</td>
            <td>Belum Dibayar  Default dulu</td>
        </tr>-->
        <tr>
            <td colspan="3" align="center">
                            <br>
                            <div align="center" valign="middle"><b><u>Daftar Pemeriksaan</u></b></div>
                            <table border="1" style="margin-top: 10px;text-align:center;width:360px;">
                                <thead>
                                <td><b>No.</b></td>
                                <td><b>Pemeriksaan</b></td>
                                <td><b>Tarif</b></td>
                                </thead>
                                <?php 
                                $total_tarif = 0;
                                foreach ($daftartindakan as $i=>$daftartindakans){ 
                                ?>
                                <tr>
                                    <td><?php echo ($i+1)."."; ?></td>
                                    <td><?php echo $daftartindakans->daftartindakan->daftartindakan_nama; ?></td>
                                    <td><?php 
                                    // $total_tarif += $tarif_tindakan;
                                    // echo $format->formatUang($tarif_tindakan);

                                    if($daftartindakans->cyto_tindakan==true){
                                        $tarif_tindakan = ($daftartindakans->tarifcyto_tindakan * $daftartindakans->qty_tindakan);
                                    }else{
                                        $tarif_tindakan = ($daftartindakans->tarif_satuan * $daftartindakans->qty_tindakan);
                                    }
                                    // $tarif_tindakan = ($daftartindakans->tarif_satuan * $daftartindakans->qty_tindakan);
                                    $total_tarif += $tarif_tindakan;
                                    echo $format->formatUang($tarif_tindakan);
                                    ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" align="center"><b>Total</b></td>
                                    <td><?php echo $format->formatUang($total_tarif); ?></td>
                                </tr>
                            </table>
                        </td>
        </tr>
        
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
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
   
</div>   
