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
        <TD WIDTH="20%" ALIGN="CENTER" VALIGN="MIDDLE">
            <div align="center" >
            <!-- <img src="<?php echo $res ?> " class='image_report' style="float:left; max-width: 100px; width:100px;" class='image_report' height="100">  -->
            </div>
        </TD>
        <TD WIDTH="60%" align="center" style="text-align:center;">
            <div align="center" class="nama_profil" style="color: black !important; ">
                <p style="text-align:center;"><?php echo $konfig->kopsurat_gizi; ?></p>
            </div>
        </TD>
        <?php if (file_exists($path2)): ?>
        <TD WIDTH="20%" ALIGN="CENTER" VALIGN="MIDDLE">
            <!-- <img src="<?php echo $res2 ?> "  class='image_report' style="float:left;" class='image_report' height="100"> -->
        </TD>
        <?php endif; ?>
    </TR>
    <tr>
        <td colspan="3" ></td>
    </tr>
     <TR>
        <TD  ALIGN=CENTER VALIGN=MIDDLE class="" colspan="3">
            <div align="center" >

                <?php

                    $shift_p = 'Shift: ';

                    if(Yii::app()->controller->id == 'laporanPerPetugas') {
                        $login = Yii::app()->user->getState('pegawai_id');
                        $pegawai = PegawaiM::model()->findByPk($login);

                        if(!empty($pegawai->shift_id)) {
                            $shift = ShiftM::model()->findByPk($pegawai->shift_id);
                            $shift_p = "Shift: $shift->shift_nama";
                        }

                    }
                
                ?>
                <h4 style="font-weight: 200;"><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h4>
            </div>
        </TD>
    </TR>
</table>
<br>

