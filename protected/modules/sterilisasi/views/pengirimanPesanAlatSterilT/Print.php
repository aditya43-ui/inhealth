<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
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
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($modPengirimanDetail as $i => $modBarang) {
                        ?>
                        <tr>
                            <td><?php echo $modBarang->barang->barang_nama; ?></td>
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

    <?php
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">

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
                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($modPengirimanDetail as $i => $modBarang) {
                                        ?>
                                        <tr>
                                            <td><?php echo $modBarang->barang->barang_nama; ?></td>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">

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
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($modPengirimanDetail as $i => $modBarang) {
                        ?>
                        <tr>
                            <td><?php echo $modBarang->barang->barang_nama; ?></td>
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

    <?php
}
?>