<?php //if (empty($is_pdf) || $is_pdf != 1): ?>
<!-- <style>
    
    .nama_profil h4 {
        color: black !important;
    }
    
    .nama_profil blockquote {
        display: none;
    }
    
</style> -->
<?php //endif; ?>


<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
// var_dump($path);die();
$path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

$res = "";
$ext = "png";

$identitaspasien = !empty($identitaspasien)?$identitaspasien:false;
$nodokrm = !empty($nodokrm)?$nodokrm:'';

if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res = "data:image/".$ext.";base64,". base64_encode($content);
}
// var_dump($res);die();
$res2 = "";
$ext = "png";

if (file_exists($path2)) {
    $content = file_get_contents($path2);
    $ext_data = pathinfo($path2);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res2 = "data:image/".$ext.";base64,". base64_encode($content);
}

?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers table-header">
    
    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD WIDTH="<?= ($identitaspasien)?'':'15%' ?>" ALIGN="CENTER" VALIGN="MIDDLE" >
            <div align="center" >
            <img src="<?php echo $res ?> " class='image_report' style="float:left; max-width: 60px; width:60px;" class='image_report'> 
            </div>
        </TD>
        <TD WIDTH="<?= ($identitaspasien)?'60%':'95%' ?>" align="center" style="text-align:center;">
            <div align="center" class="nama_profil" style="color: black !important; font-size:5pt ">
                <?php echo $konfig->alamatheadersurat; ?>
            </div>
        </TD>
        <?php
            if ($identitaspasien && !empty($modPasien->nama_pasien)){
        ?>
        <TD  ALIGN="" VALIGN="MIDDLE" >
            <?php if (!empty($nodokrm)){ ?>
                <table width='100%'>
                    <tr>
                        <td align="right"><b><?= $nodokrm ?></b></td>
                    </tr>
                </table>
            <?php } ?>
            <table width='100%'>
                <tr>
                    <td style="text-align: right;"><?= $nodokrm ?></td>                    
                </tr>
            </table>
            <table width='100%' style="border:1px solid #333;">                
                <tr>
                    <td>Nama</td>
                    <td width='10'>:</td>
                    <td><?= $modPasien->nama_pasien ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td width='10'>:</td>
                    <td><?= !empty($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir):'' ?></td>
                </tr>
                <tr>
                    <td>Nomor RM</td>
                    <td width='10'>:</td>
                    <td><?= $modPasien->no_rekam_medik ?></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td width='10'>:</td>
                    <td><?= $modPasien->no_identitas_pasien ?></td>
                </tr>
            </table>
        </TD>
        <?php
            }else{
                 if (!empty($nodokrm)){
                     echo '<TD  ALIGN="" VALIGN="MIDDLE" style="vertical-align:top;">';                 
                        echo "<table width='100%'>";
                            echo '<tr>';
                                echo '<td align="right"><b>'.$nodokrm.'</b></td>';
                            echo '</tr>';
                        echo '</table>';
                    echo '</TD>';
                }
            }
        ?>
    </TR>
    <tr>
        <td colspan="3" style="border-top: 1px solid black;"></td>
    </tr>
     <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >
                <h3><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h3>
            </div>
        </TD>
    </TR>
    <TR>
       <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >
              <font color="black"><?php echo (isset($periode) ? $periode : '') ?></font>
            </div>
        </TD>
    </TR>

</table>

