<style> 
    #headerlaporan {
        width: 109% !important; 
    }
    @page {
       size: 9.25in 7in;
       font-family: Arial, sans-serif;
       font-size: 8px !important;
       padding-top: 20px;
       margin-top: 0px;
       margin-bottom: 0px;
       margin-left: 2cm;
       margin-right: 2cm;
    }
    
    @media print {
        html, body {
            padding-top: 20px;
            font-family: Arial, sans-serif;
            padding-left: 10px;
            font-size: 8px !important;
            width: 297mm;
            height: 210mm;
            line-height: 1.6;
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
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
    

    .border {
        border: 0px;
        box-shadow:none !important;
        border-spacing:0px !important;
        padding:0px !important;
    }

</style>
<?php

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if ($caraPrint != 'EXCEL') {
    if ($caraPrint == 'PRINT' || $caraPrint == 'PDF') {
        ?>
        <span style="width: 100%">
        <?php
        echo $this->renderPartial($this->path_view.'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'TAHUN : ' . $periode, 'colspan' => 23));
        ?>
        </span>
        <div class="tab" style="font-size: 8px !important; border-collapse: collapse;">
            <table>
                <thead>
                    <tr>
                        <td>
                            <div class="">&nbsp;</div>  
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h4> A.1a. DONASI (Jumlah kantong darah yang didapatkan dari para donor darah) </h4>
                            <div class="content"><?php $this->renderPartial($this->path_view.'_tablePrint', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modShow'=>$variabel['modShow'],'b'=>$variabel['b']));  ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top">
                            <h4> A.1.b.  JUMLAH DONASI BERDASARKAN ALASAN DONOR DITOLAK </h4>
                            <div class="content"><?php $this->renderPartial($this->path_view.'_tabelDitolakPrint', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modShow'=>$variabel['modShow'],'b'=>$variabel['b']));  ?></div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="ttd" style="font-size: 8px !important; color: black">
            <b> Catatan: </b>
            <ol>
                <li> Donor Baru adalah : Seseorang yang baru partamakali dalam seumur hidup menyumbangkan darahnya. </li>
                <li> Donor Ulang adalah : Seseorang yang sudah pernah dalam seumur hidup menyumbangkan darahnya. </li>
                <li> Donor Bayaran adalah : Seseorang yang memberikan darahnya dengan mendapatkan pembayaran atau keuntungan lainnya, untuk memenuhi kebutuhan hidup yang mendasar atau sesuatu yang dapat dijual atau dapat ditukarkan kedalam uang tunak atau 
                    ditransfer ke orang lain </li>
                <li>
                    Jumlah total donasi adalah penjumlahan dari jumlah donasi dalam gedung ditambah dengan jumlah donasi dari ketiga mobile unit atau a = b + c
                </li>
                <li>
                    Jumlah total donasi = Jumlah donasi menurut jenis kelamin = jumlah donasi menurut golongan darah
                </li>
            </ol>
        </div>
        <div>
        <table style="font-size:8pt !important">
                <tr>
                    <td width="75%"></td>
                    <td>Surabaya, <?php echo date('Y'); ?> <br> <b> Kepala UTDRS Dr. Soetomo </b> </td>
                </tr>
                <tr>
                    <td width="75%"></td>
                    <td height="60px"> </td>
                </tr>
                <tr>
                    <td width="75%"></td>
                    <td >
                        <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u> <br>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        echo $this->renderPartial($this->path_view.'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'TAHUN : ' . $periode, 'colspan' => 23));
    }
} else {
    echo $this->renderPartial($this->path_view.'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'TAHUN : ' . $periode, 'colspan' => 23));
}
?>

<?php
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial($this->path_view.'_table', array('model'=>$model, 'caraPrint'=>$caraPrint, 'modShow'=>$variabel['modShow'],'b'=>$variabel['b'])); 
    echo "<div class='footer-space'>&nbsp;</div>";
}
?>