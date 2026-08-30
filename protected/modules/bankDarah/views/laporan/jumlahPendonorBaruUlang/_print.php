<style> 
    #headerlaporan {
        width: 122% !important; 
    }
    @page {
        size: 7in 9.25in;
        font-family: Arial, sans-serif;
        font-size: 12pt !important;
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
        echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 11));
        ?>
        </span>
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
                        <h4 style="font-size:8pt !important"> B.2. DONOR DARAH (Jumlah orang yang mendonorkan darahnya) </h4>
                        <div class="content"><?php $this->renderPartial($this->path_view . '_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b'])); ?></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <div>
                <br>
                <table>
                    <tr>
                        <td width="75%"></td>
                        <td style="font-size:8pt !important">Surabaya, <?php echo date('Y'); ?> <br> <b> Kepala UTDRS Dr. Soetomo </b> </td>
                    </tr>
                    <tr>
                        <td width="75%"></td>
                        <td height="75px"> </td>
                    </tr>
                    <tr>
                        <td width="75%"></td>
                        <td style="font-size:8pt !important">
                            <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u>  <br>
                                NIP. 1948 0531 197412 1 001
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    } else {
//        echo $this->renderPartial($this->path_view . 'headerLaporanPermenkespdf', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 11));
    }
} else {
    echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => 'Periode : ' . $periode, 'colspan' => 11));
}
?>

<?php
if ($caraPrint == 'PDF') {
    $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
    echo '<table width="100%" id="headerlaporan">';
        
        if (isset($judulLaporan) || strlen($judulLaporan) > 0) {
            
            echo '<tr>
                <td colspan="18" ALIGN=CENTER VALIGN=MIDDLE >
                    <font color="black">
                    <h4 style="font-size:13pt; font-weight: bold; color: #000"> LAPORAN JUMLAH PENDONOR BARU/ULANG (ORANG)<br> UTD RS. Dr. SOETOMO SURABAYA <br>';

                    }
                    
                    $periode = (isset($periode) ? $periode : null);
                    if (isset($periode) || strlen($periode) > 0) {
                        ?>
                        <?php echo $periode ?> 
                        <?php
                    }
                    
                echo '</h4>
                </font>
            </td>
        </tr>
    </table>';
    echo "<h4 style='font-size:11pt'> B.2. DONOR DARAH (Jumlah orang yang mendonorkan darahnya) </h4>";
    $this->renderPartial($this->path_view . '_table_printpdf', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b']));
    echo "<div class='footer-space'>
        <br>
            <table>
                <tr>
                    <td width='76%'></td>
                    <td>Surabaya, ".date('Y')." <br> <b> Kepala UTDRS Dr. Soetomo </b> </td>
                </tr>
                <tr>
                    <td width='76%'></td>
                    <td height='60px'> </td>
                </tr>
                <tr>
                    <td width='76%'></td>
                    <td>
                        <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u> <br>
                                NIP. 1948 0531 197412 1 001
                    </td>
                </tr>
            </table>
    </div>";
}
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>"
    . "<h4> B.2. DONOR DARAH (Jumlah orang yang mendonorkan darahnya) </h4>";
    $this->renderPartial($this->path_view . '_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b']));
    echo "<div class='footer-space'>
            <div>
                <div>
                    <br>
                    <table>
                        <tr>
                            <td colspan='15' rowspan='6'></td>
                            <td colspan='3'>Surabaya, ".date('Y')." </td>
                        </tr>
                        <tr>
                            <td colspan='3'><b> Kepala UTDRS Dr. Soetomo </b> </td>
                        </tr>
                        <tr>
                            <td rowspan='3' colspan='3'> </td>
                        </tr>
                        <tr>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                        </tr>
                        <tr>
                            <td colspan='3'>
                                <u>Prof, Dr.Eddy Rahardjo.dr,SpAn. KIC</u> <br>
                                NIP. 1948 0531 197412 1 001
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    </div>";
}
?>
