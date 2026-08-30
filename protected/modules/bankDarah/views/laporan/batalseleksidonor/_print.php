<style> 
    @page {
        size: 7in 9.25in;
        font-family: Arial, sans-serif;
        font-size: 12pt !important;
        padding-top: 20px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 1cm;
        margin-right: 1cm;

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
        echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => '' . $periode, 'colspan' => 15));
        ?>
        </span>
        <table width="100%">
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
                        <div class="content"><?php $this->renderPartial($this->path_view . '_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b'])); ?></div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    } else {
//        echo $this->renderPartial($this->path_view . 'headerLaporanPermenkespdf', array('judulLaporan' => $judulLaporan, 'periode' => '' . $periode, 'colspan' => 15));
    }
} else {
    echo $this->renderPartial($this->path_view . 'headerLaporanPermenkes', array('judulLaporan' => $judulLaporan, 'periode' => '' . $periode, 'colspan' => 15));
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
                    <h4 style="font-size:13pt; font-weight: bold; color: #000"> LEMBAR PERHITUNGAN DONOR BATAL DI SELEKSI DONOR <br>';

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
    $this->renderPartial($this->path_view . '_table_printpdf', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b']));
    
}
if ($caraPrint == 'EXCEL') {
    $this->renderPartial($this->path_view . '_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'b' => $variabel['b']));
   
}
?>
