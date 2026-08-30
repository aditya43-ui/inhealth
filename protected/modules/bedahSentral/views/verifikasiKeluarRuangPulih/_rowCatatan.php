<?php

$pegawai = null;
if (empty($mod)) {
    $mod = new CatatankhususRuangpulihT();
} else {
    $pegawai = PegawaiM::model()->findByPk($mod->pembericatatan_id);
}

if (empty($idx)) {
    $idx = "ii";
}

?>
<tr>
    <td>
        <span class="txt_catatankhusus_jam"><?php echo $mod->catatankhusus_jam ?></span>
    </td>
    <td class="txt_catatankhusus_isi"><?php echo $mod->catatankhusus_isi ?></td>
    <td class="txt_pembericatatan_nama"><?php echo (empty($pegawai) ? "-" : ($pegawai->namaLengkap." / ".(empty($pegawai->jabatan) ? "-" : $pegawai->jabatan->jabatan_nama))) ?></td>
</tr>