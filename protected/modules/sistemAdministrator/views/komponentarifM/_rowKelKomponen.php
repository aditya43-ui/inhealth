<tr>
    <td><?php echo CHtml::dropDownList('kelompok[id][]', $kel, CHtml::listData(
      SAKelompokkomponentarifM::model()->findAll('kelompokkomponentarif_aktif = true order by kelompokkomponentarif_nama'),
            'kelompokkomponentarif_id', 'kelompokkomponentarif_nama'), array(
                'empty'=>'-- Pilih --',
            )); ?></td>
    <td>
        <?php echo CHtml::textField('kelompok[persentase][]', $persen, array(
            'class'=>'integer', 'maxlength'=>3,
        )); ?>
    </td>
    <td style="text-align: center">
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'$(this).parents("tr").remove(); return false;',
        )); ?>
    </td>
</tr>