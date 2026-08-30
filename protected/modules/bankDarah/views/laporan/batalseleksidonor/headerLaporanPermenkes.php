<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%" id="headerlaporan">
    <?php
    if (isset($judulLaporan) || strlen($judulLaporan) > 0) {
        ?>
        <tr>
            <td colspan="18" ALIGN=CENTER VALIGN=MIDDLE >
                <font color="black">
                <p style=" font-size:10pt !important; font-weight: bold; color: #333333"> LEMBAR PERHITUNGAN DONOR BATAL DI SELEKSI DONOR <br>

                    <?php
                }
                ?>
                <?php
                $periode = (isset($periode) ? $periode : null);
                if (isset($periode) || strlen($periode) > 0) {
                    ?>
                    <?php echo $periode ?> 
                    <?php
                }
                ?>
            </p>
            </font>
        </td>
    </tr>
</table>
