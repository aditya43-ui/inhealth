<?php
$modLokasi->provinsi_id = ProfilrumahsakitM::model()->findByPk(1)->propinsi_id;
?>
<tr>
    <td class="row_num" style="text-align: right;">
        <?php echo $i++; ?>
    </td>
    <td>
        <?php echo $form->dropDownList($modLokasi, '[0]provinsi_id', CHtml::listData(PropinsiM::model()->findAll('propinsi_aktif IS TRUE ORDER BY propinsi_nama ASC'), 'propinsi_id', 'propinsi_nama'), array('disabled' => true, 'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 160px", 'onchange' => 'setKabupaten(this)'));?>
    </td>
    <td>
        <?php echo $form->dropDownList($modLokasi, '[0]kabupaten_id', !empty($modLokasi->provinsi_id) ? CHtml::listData(KabupatenM::model()->findAll('kabupaten_aktif IS TRUE AND propinsi_id = ' . $modLokasi->provinsi_id . ' ORDER BY kabupaten_nama ASC'), 'kabupaten_id', 'kabupaten_nama') : array(), array('disabled' => true, 'class' => 'span2 kabupaten_id required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 160px"));?>
    </td>
    <td>
        <?php echo $form->textField($modLokasi, '[0]detil_lokasi', array('disabled' => true, 'class' => 'span2', 'style' => "width: 160px", 'placeholder' => "Detil")); ?>
    </td>
</tr>