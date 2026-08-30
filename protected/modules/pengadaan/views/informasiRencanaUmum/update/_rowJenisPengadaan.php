<tr>
    <td class="row_num" style="text-align: right;">
        <?php $i = 1; echo $i++; ?>
    </td>
    <td>
        <?php 
                echo CHtml::activeHiddenField($modJenis, '[0]pengadaanjenis_id_awal',array('class' => 'pengadaanjenis_id_awal'));
                echo CHtml::activeHiddenField($modJenis, '[0]pengadaanjenis_id',array('class' => 'pengadaanjenis_id'));
                echo CHtml::activeDropDownList($modJenis, '[0]jenispengadaan_id', 
                CHtml::listData(JenispengadaanM::model()->findAll('jenispengadaan_aktif IS TRUE ORDER BY jenispengadaan_nama ASC'), 'jenispengadaan_id', 'jenispengadaan_nama'), 
                array('onchange' => 'setDokumen(this)', 'id' => 'jenis_pengadaan', 'readonly' => false,  'class' => 'span2 required jenispengadaan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 160px"));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modJenis, '[0]jumlahpagu', array('readonly' => false, 'class' => 'span2 integer-decimal required', 'style' => "width: 160px;text-align:right", 'onblur' => 'hitungTotalJenisPengadaan();')); ?>
    </td>
</tr>