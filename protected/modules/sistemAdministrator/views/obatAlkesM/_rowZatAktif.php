<?php
if (empty($nama)) $nama = "";
?>
<tr>
    <td><?php echo CHtml::textField('zatAktif[]', $nama); ?></td>
    <td style="text-align: center;"><?php echo CHtml::link('<i class="icon-remove"></i>', '#', array('onclick'=>'removeRowZatAktif(this); return false;')); ?></td>
</tr>
