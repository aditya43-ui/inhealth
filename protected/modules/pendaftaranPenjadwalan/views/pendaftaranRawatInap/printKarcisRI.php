
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
                   
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
                    
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table style="width: 100%; border: none;">
                       
                        <tr>
                            <td align="center" valig="middle" colspan="3">
                                Data Pasien
                            </td>
                        </tr>
                        <?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) { ?>
                            <tr>
                                <td>No. Antrian</td>
                                <td>:</td>
                                <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
                            </tr>
                            <tr>
                                <td>No. Pendaftaran</td>
                                <td>:</td>
                                <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
                            </tr>
                            <tr>
                                <td>Nama Pasien</td>
                                <td>:</td>
                                <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . (!empty($modPasien->nama_bin) ? " (" . $modPasien->nama_bin . ")" : ""); ?></td>
                            </tr>
                            <tr>
                                <td>No. Rekam Medis</td>
                                <td>:</td>
                                <td><?php echo $modPasien->no_rekam_medik; ?></td>
                            </tr>
                            <tr>
                                <td>Poliklinik Tujuan</td>
                                <td>:</td>
                                <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>No. Pendaftaran</td>
                                <td>:</td>
                                <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
                            </tr>
                            <tr>
                                <td>Nama Pasien</td>
                                <td>:</td>
                                <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . (!empty($modPasien->nama_bin) ? " (" . $modPasien->nama_bin . ")" : ""); ?></td>
                            </tr>
                            <tr>
                                <td>No. Rekam Medis</td>
                                <td>:</td>
                                <td><?php echo $modPasien->no_rekam_medik; ?></td>
                            </tr>
                            <tr>
                                <td>Karcis</td>
                                <td>:</td>
                                <td><?php echo (isset($modTindakan->karcis->karcis_nama) ? $modTindakan->karcis->karcis_nama : "-"); ?></td>
                            </tr>
                            <tr>
                                <td>Harga Karcis</td>
                                <td>:</td>
                                <td><?php echo (isset($modTindakan->tarif_satuan) ? $format->formatUang($modTindakan->tarif_satuan * $modTindakan->qty_tindakan) : "-") ?></td>
                            </tr>

                        </table><br>
                        <table style="width: 100%; border: none;">
                            <tr>
                                <td width="50%"></td>
                                <td>Kasir</td>
                            </tr>
                            <tr height="60px" valign="bottom">
                                <td></td>
                                <td><?php echo $modPegawai->nama_pegawai; ?></td>
                            </tr>
                        </table>

                    <?php } else { ?>
                        <tr>
                            <td>No. Antrian</td>
                            <td>:</td>
                            <td><b><?php echo $modPendaftaran->ruangan->ruangan_singkatan; ?>-<?php echo $modPendaftaran->no_urutantri; ?></b></td>
                        </tr>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td><b><?php echo $modPendaftaran->no_pendaftaran; ?></b></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo $modPasien->namadepan . $modPasien->nama_pasien . (!empty($modPasien->nama_bin) ? " (" . $modPasien->nama_bin . ")" : ""); ?></td>
                        </tr>
                        <tr>
                            <td>No. Rekam Medis</td>
                            <td>:</td>
                            <td><?php echo $modPasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Poliklinik Tujuan</td>
                            <td>:</td>
                            <td><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</td>
                        </tr>
    </table>
<?php } ?>
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
