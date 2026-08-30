<tr>
    <td class="row_num" style="text-align: right;">
        <?php echo $i++; ?>
    </td>
    <td>
        <?php echo $form->dropDownList($modJenis, '[0]jenispengadaan_id', CHtml::listData(JenispengadaanM::model()->findAll('jenispengadaan_aktif IS TRUE ORDER BY jenispengadaan_nama ASC'), 'jenispengadaan_id', 'jenispengadaan_nama'), array('readonly' => true,  'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 160px"));
        ?>
    </td>
    <td>
        <?php echo $form->textField($modJenis, '[0]jumlahpagus', array('readonly' => true, 'class' => 'span2 integer2 required', 'style' => "width: 160px;text-align:right", 'onblur' => 'hitungTotalJenisPengadaan();')); ?>
    </td>
</tr>