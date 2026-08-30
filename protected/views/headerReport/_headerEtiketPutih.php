<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$konfig = KonfigsystemK::model()->find();


$url = Params::urlProfilRSDirectory().$data->logo_rumahsakit;
$url2 = Params::urlProfilRSDirectory().$data->logo_rumahsakit_2;

$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
$path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

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
<style>
    .headers tr td {
        font-size: 5pt;
    }

    .header tr {
        border-bottom: 1px solid black;
    }
</style>

<table width="<?php echo ((isset($width)) ? $width : "100%") ?>" class="headers" cellspacing=0 cellpadding=0>
    <TR style="border-bottom: 1px solid black;">
        <TD>
            <img src="<?= $url ?>" style="width: 0.5cm">

        </TD>
        <TD align="center">
            <div align="center" class="nama_profil">
                    <b><?= $data->nama_rumahsakit ?> <br></b>
                    <?= $data->alamatlokasi_rumahsakit ?> <br>
                    <?= str_replace("(031)", "", $data->no_telp_profilrs) . " - " . str_replace("(031)", "", $data->no_faksimili) ?>
            </div>

        </TD>
        <TD>
            <img src="<?= $url2 ?>" style="width: 0.5cm">

        </TD>
    </TR>
</table>