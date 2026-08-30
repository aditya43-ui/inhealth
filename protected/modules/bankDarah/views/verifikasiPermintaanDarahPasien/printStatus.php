
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
        
        <tr>
            <td align="center" valig="middle" colspan="3">
                <u><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></u>
            </td>
        </tr>
        <tr>
            <td>No. Masuk Penunjang</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->pasienmasukpenunjang->no_masukpenunjang; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
        </tr>
        <tr>
            <td>Dokter Pemeriksa</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->pegawai->NamaLengkap; ?></td>
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
<!--<tr>
            <td>Status Pembayaran Karcis</td>
            <td>:</td>
            <td>Belum Dibayar  Default dulu</td>
        </tr>-->
        <tr>
            <td colspan="3" align="center">
                            <div align="center" valign="middle"><b><u>Daftar Pemeriksaan</u></b></div>
                            <table border="table table-border" style="margin-top: 10px;text-align:center;width:100%">
                                <thead>
                                <td><b>No.</b></td>
                                <td><b>Pemeriksaan</b></td>
                                <td><b>Tarif</b></td>
                                </thead>
                                <?php 
                                $total_tarif = 0;
                                foreach ($daftartindakan as $i=>$val){ 
                                ?>
                                <tr>
                                    <td><?php echo ($i+1)."."; ?></td>
                                    <td><?php echo $val->daftartindakan->daftartindakan_nama; ?></td>
                                    <td><?php 
                                    $tarif_tindakan = ($val->tarif_satuan * $val->qty_tindakan);
                                    $total_tarif += $tarif_tindakan;
                                    echo $format->formatUang($tarif_tindakan); ?></td>
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
