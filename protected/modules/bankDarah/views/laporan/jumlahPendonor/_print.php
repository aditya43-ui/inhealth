<style> 
    #headerlaporan {
        width: 122% !important; 
    }
    @page {
        size: 7in 9.25in;
        font-family: Arial, sans-serif;
        font-size: 8pt !important;
        padding-top: 30px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 2cm;
        margin-right: 2cm;

    }
    @media print {
        html, body {
            padding-top: 30px;
            padding-left: 10px;
            width: 210mm;
            height: 297mm;
            line-height: 1.6;
            font-size: 8pt !important;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }

        .headernya{
            font-size: 10pt !important;
        }
    }
    .headernya{
        font-size: 10pt !important;
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }
    @media all {
        .page-break { display: none; }
    }

    @media print {
        .page-break { display: block; page-break-before: always; }
    }
</style>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT') {
        ?>
        <span style="width: 100%">
            <?php
            echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 7));
            ?>
        </span>
        <table style="font-size: 8pt !important">
            <tbody>
                <tr>
                    <td colspan="2">
                        <h4 style="font-size:8pt !important"> B.1. DONOR DARAH (Jumlah orang yang mendonorkan darahnya) </h4>
                        <div class="content" style="font-size:8pt !important"><?php $this->renderPartial($this->path_view . '_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b'])); ?></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ttd" style="font-size: 8pt !important">
            <div style="color: black">
                <p style="font-size:8pt !important; font-weight: bolder"> Catatan : </p>
                <ol>
                    <li style="font-size:8pt !important"> Laporan dilaporkan dalam periode tahunan. </li>
                    <li style="font-size:8pt !important"> Bila dalam satu tahun menyumbangkan darah lebih dari satu kali, dan salah satunya sebagai Donor Sukarela bukan Donor Bayaran, maka status akhir pendonor adalah donor Sukarela.</li>
                    <li style="font-size:8pt !important"> Bila penyumbangan darah dalam setahun dan sebagai Donor Pengganti, maka status akhir adalah Donor Pengganti.</li>
                    <li style="font-size:8pt !important"> Bila dalam satu tahun pernah menjadi Donor Bayaran maka status akhir pendonor adalah sebagai Donor Bayaran.</li>
                    <li style="font-size:8pt !important"> Cekal Permanen adalah : Pendonor yang tidak diperkenankan, untuk menyumbangkan darah lagi seumur hidupnya 
                        (misalnya : oleh karena Uji Konfirmasi Diagnostik IMLTD adalah Positif, pendonor terdiagnosa menderita penyakit yang tidak memungkinkan untuk melakukan Donor Darah).
                    </li>
                    <li style="font-size:8pt !important"> Cekal Sementara adalah :  Pendonor yang tidak diperkenankan, untuk menyumbangkan darah lagi sementara waktu
                        (misalnya : oleh karena Alasan Medis atau tidak terpenuhi persyaratan donor).</li>
                    <li style="font-size:8pt !important"> Perhitungan donor diambil dari status penyumbangan darah terakhir dalam tahun laporan. </li>
                    <li style="font-size:8pt !important"> Jumlah total donor = jumlah donor berdasarkan jenis kelamin = jumlah donor berdasarkan jenis donor. </li>
                </ol>
            </div>
        </div>
        <div>
            <div>
                <table style="font-size:8pt !important">
                    <tr>
                        <td width="75%"></td>
                        <td style="font-size:8pt !important">Surabaya, <?php echo date('Y'); ?> <br> <b> Kepala UTDRS Dr. Soetomo </b> </td>
                    </tr>
                    <tr>
                        <td width="75%"></td>
                        <td height="60px"> </td>
                    </tr>
                    <tr>
                        <td width="75%"></td>
                        <td style="font-size:8pt !important">
                            <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u> <br>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    } else {
        echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 7));
    }
} else {
    echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 7));
}
?>

<?php
if ($caraPrint == 'PDF') {
    echo "<h4> B.1. DONOR DARAH (Jumlah orang yang mendonorkan darahnya) </h4>";
    $this->renderPartial($this->path_view . '_table_printpdf', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b']));
    echo "
            <div class='ttd'>
                <div style='color: black'>
                    <p> <b> Catatan : </b></p>
                    <ol>
                        <li> Laporan dilaporkan dalam periode tahunan. </li>
                        <li> Bila dalam satu tahun menyumbangkan darah lebih dari satu kali, dan salah satunya sebagai Donor Sukarela bukan Donor Bayaran, maka status akhir pendonor adalah donor Sukarela.</li>
                        <li> Bila penyumbangan darah dalam setahun dan sebagai Donor Pengganti, maka status akhir adalah Donor Pengganti.</li>
                        <li> Bila dalam satu tahun pernah menjadi Donor Bayaran maka status akhir pendonor adalah sebagai Donor Bayaran.</li>
                        <li> Cekal Permanen adalah : Pendonor yang tidak diperkenankan, untuk menyumbangkan darah lagi seumur hidupnya 
                            (misalnya : oleh karena Uji Konfirmasi Diagnostik IMLTD adalah Positif, pendonor terdiagnosa menderita penyakit yang tidak memungkinkan untuk melakukan Donor Darah).
                        </li>
                        <li> Cekal Sementara adalah :  Pendonor yang tidak diperkenankan, untuk menyumbangkan darah lagi sementara waktu
                            (misalnya : oleh karena Alasan Medis atau tidak terpenuhi persyaratan donor).</li>
                        <li> Perhitungan donor diambil dari status penyumbangan darah terakhir dalam tahun laporan. </li>
                        <li> Jumlah total donor = jumlah donor berdasarkan jenis kelamin = jumlah donor berdasarkan jenis donor. </li>
                    </ol>
                </div>
            </div>
            <div>
                <div>
                    <table>
                        <tr>
                            <td width='82%'></td>
                            <td>Surabaya, " . date('Y') . " <br> <b> Kepala UTDRS Dr. Soetomo </b> </td>
                        </tr>
                        <tr>
                            <td width='82%'></td>
                            <td height='60px'> </td>
                        </tr>
                        <tr>
                            <td width='82%'></td>
                            <td>
                                <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u> <br>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    ";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>"
    . "<h4> B.1. DONOR DARAH (Jumlah orang yang mendonorkan darahnya) </h4>";
    $this->renderPartial($this->path_view . '_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b']));
    echo "<div class='footer-space'>
            <div class='ttd'>
                <div style='color: black'>
                    <br>
                    <p> <b> Catatan : </b></p>
                    <ol>
                        <li> Laporan dilaporkan dalam periode tahunan. </li>
                        <li> Bila dalam satu tahun menyumbangkan darah lebih dari satu kali, dan salah satunya sebagai Donor Sukarela bukan Donor Bayaran, maka status akhir pendonor adalah donor Sukarela.</li>
                        <li> Bila penyumbangan darah dalam setahun dan sebagai Donor Pengganti, maka status akhir adalah Donor Pengganti.</li>
                        <li> Bila dalam satu tahun pernah menjadi Donor Bayaran maka status akhir pendonor adalah sebagai Donor Bayaran.</li>
                        <li> Cekal Permanen adalah : Pendonor yang tidak diperkenankan, untuk menyumbangkan darah lagi seumur hidupnya 
                            (misalnya : oleh karena Uji Konfirmasi Diagnostik IMLTD adalah Positif, pendonor terdiagnosa menderita penyakit yang tidak memungkinkan untuk melakukan Donor Darah).
                        </li>
                        <li> Cekal Sementara adalah :  Pendonor yang tidak diperkenankan, untuk menyumbangkan darah lagi sementara waktu
                            (misalnya : oleh karena Alasan Medis atau tidak terpenuhi persyaratan donor).</li>
                        <li> Perhitungan donor diambil dari status penyumbangan darah terakhir dalam tahun laporan. </li>
                        <li> Jumlah total donor = jumlah donor berdasarkan jenis kelamin = jumlah donor berdasarkan jenis donor. </li>
                    </ol>
                </div>
            </div>
            <div>
                <div>
                    <table>
                        <tr>
                            <td width='82%'></td>
                            <td>Surabaya, " . date('Y') . " <br> <b> Kepala UTDRS Dr. Soetomo </b> </td>
                        </tr>
                        <tr>
                            <td width='82%'></td>
                            <td height='60px'> </td>
                        </tr>
                        <tr>
                            <td width='82%'></td>
                            <td>
                                <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u> <br>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    </div>";
}
?>
