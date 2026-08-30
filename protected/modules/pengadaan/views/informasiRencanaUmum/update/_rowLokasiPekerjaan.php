<?php
$modLokasi->provinsi_id = ProfilrumahsakitM::model()->findByPk(1)->propinsi_id;
?>
<tr>
    <td class="row_num" style="text-align: right;">
        <?php echo 1; ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeHiddenField($modLokasi, '[0]pengadaanlokasi_id',array('readonly'=>true, 'class'=>'pengadaanlokasi_id'));
            echo CHtml::activeDropDownList($modLokasi, '[0]provinsi_id', CHtml::listData(PropinsiM::model()->findAll('propinsi_aktif IS TRUE ORDER BY propinsi_nama ASC'), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --', 'disabled' => false, 'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 160px", 'onchange' => 'setKabupaten(this)'));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modLokasi, '[0]kabupaten_id', !empty($modLokasi->provinsi_id) ? CHtml::listData(KabupatenM::model()->findAll('kabupaten_aktif IS TRUE AND propinsi_id = ' . $modLokasi->provinsi_id . ' ORDER BY kabupaten_nama ASC'), 'kabupaten_id', 'kabupaten_nama') : array(), array('disabled' => false, 'class' => 'span2 kabupaten_id required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 160px"));?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modLokasi, '[0]detil_lokasi', array('disabled' => false, 'class' => 'span2', 'style' => "width: 160px", 'placeholder' => "Detil")); ?>
    </td>
        <td style="width: 100px; text-align: center;">
        <?php echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', '#', array(
            'onclick'=>'tambahLokasiPekerjaan(this); return false;',
        )); ?>
        <?php 
        if (empty($sendiri) || !$sendiri) {
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', '#', array(
                'onclick'=>'hapusLokasiPekerjaan(this); return false;',
            ));
        } ?>
    </td>
</tr>