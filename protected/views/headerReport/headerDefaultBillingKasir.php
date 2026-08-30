<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path = Params::pathProfilRSDirectory() . $data->logo_rumahsakit;
$path2 = Params::pathProfilRSDirectory() . $data->logo_rumahsakit_2;

$res = "";
$ext = "png";

if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);

    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }

    $res = "data:image/" . $ext . ";base64," . base64_encode($content);
}

$res2 = "";
$ext = "png";

if (file_exists($path2)) {
    $content = file_get_contents($path2);
    $ext_data = pathinfo($path2);

    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }

    $res2 = "data:image/" . $ext . ";base64," . base64_encode($content);
}

?>
<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" style="border: none" nowrap>

    <!--<TD width="15%" height="50%">-->
    <TR>
        <TD WIDTH="5%" ALIGN="CENTER" VALIGN="MIDDLE" nowrap>
            <div align="center">
                <img src="<?= $res ?>" style="max-width: 15mm; width:15mm;" />
            </div>
        </TD>
        <TD WIDTH="60%" align="LEFT" style="text-align:LEFT; " nowrap>
            <div>
                <h3 style="text-transform: uppercase;"> <b><?php echo $data->nama_rumahsakit; ?></b> </h3>
            </div>
            <div>
                <?php echo $data->alamatlokasi_rumahsakit; ?>
            </div>
            <div>
                Telp. <?php echo $data->no_telp_profilrs; ?> / Fax. <?php echo $data->no_faksimili; ?>
            </div>
        </TD>
        <TD WIDTH="20%" ALIGN="CENTER" VALIGN="MIDDLE">
        </TD>
    </TR>

</table>