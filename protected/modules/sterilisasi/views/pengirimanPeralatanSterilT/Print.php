
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
                    if ($caraPrint != 'EXCEL') {
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
                    }
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <?php
                    if (!$modPengirimanDetail) {
                        echo "Data tidak ditemukan.";
                        exit;
                    }
                  
                    $format = new MyFormatter;
                    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
                    ?>
                    <body class="kertas">
                        <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>Tanggal Pengiriman</td>
                                <td>:</td>
                                <td><?php echo isset($modPengiriman->kirimperlinensteril_tgl) ? $format->formatDateTimeId($modPengiriman->kirimperlinensteril_tgl) : "-"; ?></td>
                            </tr>
                            <tr>
                                <td>No. Pengiriman</td>
                                <td>:</td>
                                <td><?php echo isset($modPengiriman->kirimperlinensteril_no) ? $modPengiriman->kirimperlinensteril_no : "-"; ?></td>
                            </tr>
                            <tr>
                                <td>Ruangan</td>
                                <td>:</td>
                                <td><?php echo isset($modPengiriman->ruangan->ruangan_nama) ? $modPengiriman->ruangan->ruangan_nama : "-"; ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?php echo isset($modPengiriman->penerimaansterilisasi_ket) ? $modPengiriman->penerimaansterilisasi_ket : "-"; ?></td>
                            </tr>
                        </table><br><br>
                        <table width="100%" style='margin-left:auto; margin-right:auto;'>
                            <thead class="border">
                            <th>Nama Peralatan dan Linen</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            </thead>
                            <tbody class="border">
                                <?php
                                $total = 0;
                                foreach ($modPengirimanDetail as $i => $modBarang) {

                                    $peralatan = PeralatansterilisasiM::model()->findByPk($modBarang->peralatansterilisasi_id);
                                    ?>
                                    <tr>
                                        <td><?php
                                            if (!empty($peralatan)) {
                                                echo $peralatan->peralatansterilisasi_nama;
                                            } else {
                                                echo $modBarang->barang->barang_nama;
                                            }
                                            ?></td>
                                        <td><?php echo $modBarang->kirimperlinensterildet_jml; ?></td>
                                        <td><?php echo $modBarang->kirimperlinensterildet_ket; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table width="100%" style="margin-top:20px;">
                            <tr>
                                <td width="100%" align="left" align="top">
                                    <table style="width: 100%; border: none;">
                                        <tr>
                                            <td width="35%" align="center">
                                                <div>Mengirim<br></div>
                                                <div style="margin-top:60px;"><?php echo $modPengiriman->pegawaiMengirim->nama_pegawai; ?></div>
                                            </td>
                                            <td width="35%" align="center">
                                            </td>
                                            <td width="35%" align="center">
                                                <div>Mengetahui</div>
                                                <div style="margin-top:60px;"><?php echo isset($modPengiriman->pegawaiMengetahui->nama_pegawai) ? $modPengiriman->pegawaiMengetahui->nama_pegawai : "-"; ?></div>
                                                <div></div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>
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
