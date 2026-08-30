<?php
/**
 * digunakan untuk format laporan pada mcu kunjungan pasien 
 * RSST-3210
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */

?>

<style>
    table tr td{
        font-size: 10px;
    }
</style>
<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="100%" id="headerlaporan" >
        
        <?php
            if(isset($judulLaporan) || strlen($judulLaporan) > 0){
        ?>
            <TR>
                <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3> LAPORAN DONASI DARAH LENGKAP (WHOLE BLOOD / WB) <br> UTD RS. Dr. SOETOMO SURABAYA </h3></font></TD>
            </TR>
        <?php
            }
        ?>
        <?php
            $periode = (isset($periode) ? $periode : null);
            if(isset($periode) || strlen($periode) > 0){
        ?>
            <TR>
                <TD colspan=" <?php echo ((!empty($colspan)) ? ($colspan) : 6) + 3; ?>" ALIGN=CENTER VALIGN=MIDDLE><font color="black"> <h3> <?php echo $periode?> </h3> </TD>
            </TR>  
        <?php
            }
        ?>
          
</table>
