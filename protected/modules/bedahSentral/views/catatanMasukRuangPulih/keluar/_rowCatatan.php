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
        <?php
        echo CHtml::activeHiddenField($mod, "[detail][$idx]catatankhusus_jam", array('class'=>'row_catatankhusus_jam'));
        echo CHtml::activeHiddenField($mod, "[detail][$idx]catatankhusus_isi", array('class'=>'row_catatankhusus_isi'));
        echo CHtml::activeHiddenField($mod, "[detail][$idx]pembericatatan_id", array('class'=>'row_pembericatatan_id'));
        
        ?>
        <span class="txt_catatankhusus_jam"><?php echo $mod->catatankhusus_jam ?></span>
    </td>
    <td class="txt_catatankhusus_isi"><?php echo $mod->catatankhusus_isi ?></td>
    <td class="txt_pembericatatan_nama"><?php echo (empty($pegawai) ? "-" : ($pegawai->namaLengkap." / ".(empty($pegawai->jabatan) ? "-" : $pegawai->jabatan->jabatan_nama))) ?></td>
    <td>
        <?php
        echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'hapusCatatan(this); return false;'
        ));
        ?>
    </td>
</tr>