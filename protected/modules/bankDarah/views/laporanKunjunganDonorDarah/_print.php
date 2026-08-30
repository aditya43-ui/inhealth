<style> 
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
$profilRS = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != 'EXCEL' && $caraPrint != 'GRAFIK') {
    echo '  <table width="100%" id="headerlaporan" >
                <tr>
                    <td ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                        <img src="' . Params::pathImageErrorAdmin() . "Jawa_Timur.png" . '" style="float:left;max-width: 80px; width:80px;" class="image_report"/>
                    </td>
                    <td ALIGN=CENTER VALIGN=MIDDLE colspan="9" nowrap>
                        <B><FONT FACE="Liberation Serif" SIZE=5 color="black">' . "<div>PEMERINTAH PROVINSI JAWA TIMUR </div>" . $profilRS->nama_rumahsakit . '</FONT></B>
                    </td>
                    <td ROWSPAN="3" rowspan="3" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
                    </td>
                </tr>
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE colspan="9" nowrap>
                        <FONT FACE="Liberation Serif" color="black">' . $profilRS->alamatlokasi_rumahsakit . '</FONT>
                    </td>
                </tr>
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE colspan="9" nowrap>
                        <FONT FACE="Liberation Serif" color="black">Telp./Fax. ' . $profilRS->no_telp_profilrs . " / " . $profilRS->no_faksimili . " - " . $profilRS->website . "<div>Surabaya (60285)</div>" . '</FONT>
                    </td>
                </tr>

                <tr>
                    <td colspan="11" HEIGHT=2 style="border-bottom: 3px solid #000000" ></td>
                </tr>';

            if (isset($judulLaporan) || strlen($judulLaporan) > 0) {
                ?>
                <tr>
                    <td colspan="11" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3><?php echo $judulLaporan ?></h3></font></td>
                </tr>
                <?php
            }

            $periode = (isset($periode) ? $periode : null);
            if (isset($periode) || strlen($periode) > 0) {
                ?>
                <tr>
                    <td colspan="11" ALIGN=LEFT VALIGN=MIDDLE><font color="black"><?php echo "<br>Periode : " . $periode ?></font></td>
                </tr>  
                <?php
            }
    echo '</table>';
    $this->renderPartial('_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'modShow' => $variabel['modShow'], 'b' => $variabel['b']));
} else {
    echo '  <table width="100%" id="headerlaporan" >
                <tr>
                    <td ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                        <img src="' . Params::pathImageErrorAdmin() . "Jawa_Timur.png" . '" style="float:left;max-width: 80px; width:80px;" class="image_report"/>
                    </td>
                    <td ALIGN=CENTER VALIGN=MIDDLE colspan="9" nowrap>
                        <B><FONT FACE="Liberation Serif" SIZE=5 color="black">' . "<div>PEMERINTAH PROVINSI JAWA TIMUR </div>" . $profilRS->nama_rumahsakit . '</FONT></B>
                    </td>
                    <td ROWSPAN="3" rowspan="3" WIDTH="80" ALIGN="CENTER" VALIGN="MIDDLE">
                    </td>
                </tr>
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE colspan="9" nowrap>
                        <FONT FACE="Liberation Serif" color="black">' . $profilRS->alamatlokasi_rumahsakit . '</FONT>
                    </td>
                </tr>
                <tr>
                    <td ALIGN=CENTER VALIGN=MIDDLE colspan="9" nowrap>
                        <FONT FACE="Liberation Serif" color="black">Telp./Fax. ' . $profilRS->no_telp_profilrs . " / " . $profilRS->no_faksimili . " - " . $profilRS->website . "<div>Surabaya (60285)</div>" . '</FONT>
                    </td>
                </tr>

                <tr>
                    <td colspan="11" HEIGHT=2 style="border-bottom: 3px solid #000000" ></td>
                </tr>';

            if (isset($judulLaporan) || strlen($judulLaporan) > 0) {
                ?>
                <tr>
                    <td colspan="11" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3><?php echo $judulLaporan ?></h3></font></td>
                </tr>
                <?php
            }

            $periode = (isset($periode) ? $periode : null);
            if (isset($periode) || strlen($periode) > 0) {
                ?>
                <tr>
                    <td colspan="11" ALIGN=LEFT VALIGN=MIDDLE><font color="black"><?php echo "<br>Periode : " . $periode ?></font></td>
                </tr>  
                <?php
            }
    echo '</table>';
}
?>

<?php
if ($caraPrint == 'EXCEL') {
    echo "<div class='header-space'>&nbsp;</div>";
    $this->renderPartial('_table_print', array('model' => $model, 'caraPrint' => $caraPrint, 'modShow' => $variabel['modShow'], 'b' => $variabel['b']));
    echo "<div class='footer-space'>&nbsp;</div>";
}

if ($caraPrint == 'GRAFIK')
    echo $this->renderPartial('_grafik', array('model' => $model, 'data' => $data, 'caraPrint' => $caraPrint), true);
?>
