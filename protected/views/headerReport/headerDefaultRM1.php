<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path = Params::pathProfilRSDirectory() . $data->logo_rumahsakit;
// var_dump($path);die();
$path2 = Params::pathProfilRSDirectory() . $data->logo_rumahsakit_2;

$res = '';
$ext = 'png';

if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);

    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }

    $res = 'data:image/' . $ext . ';base64,' . base64_encode($content);
}
// var_dump($res);die();
$res2 = '';
$ext = 'png';

if (file_exists($path2)) {
    $content = file_get_contents($path2);
    $ext_data = pathinfo($path2);

    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }

    $res2 = 'data:image/' . $ext . ';base64,' . base64_encode($content);
}

$judulLaporan = 'LEMBARAN MASUK <br/>RM1a';
?>
<table width="100%">
          <tr>
            <td width="33.33%">
                <table>
                <td width="50%" ALIGN=CENTER VALIGN=MIDDLE>

                </td>
                <td width="50%">
                </td>
            </table>
            </td>
            <td ALIGN=CENTER VALIGN=MIDDLE width="33.33%">
                <h3>
                    <?php echo $judulLaporan; ?>
                </h3>
            </td>
            <td ALIGN=CENTER VALIGN=MIDDLE width="33.33%">
            </td>
        </tr>
        <br/>

</table>

