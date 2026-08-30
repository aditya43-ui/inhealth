<tr>
    <td class="row_num" style="text-align: right;">
        <?php echo $i++; ?>
    </td>
    <td>
        <?php echo $form->dropDownList($modSumberDana, '[0]sumberanggaran_id', CHtml::listData(SumberanggaranM::model()->findAll('sumberanggaran_aktif IS TRUE ORDER BY sumberanggarannama ASC'), 'sumberanggaran_id', 'sumberanggarannama'), array('disabled' => true, 'class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => "width: 120px"));?>
    </td>
    <td>
        <?php echo $form->textField($modSumberDana, '[0]asal_dana', array('disabled' => true, 'class' => 'span2', 'style' => "width: 120px", 'placeholder' => 'Asal Dana')); ?>
    </td>
    <td>
        <?php //echo $form->dropDownList($modSumberDana, '[0]rekening5_id', ADRencanaumumpengadaanT::getRekeningMAK(), array('disabled' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)"));
          $modMapping = MappingrekeninganggaranM::model()->findByAttributes(array('mappingrekeninganggaran_id' => $modSumberDana['mappingrekeninganggaran_id']));     
          $kode_rekening = $modMapping['kodeanggaran']." - ".$modMapping['nama_rekeninganggaran5']; 
            echo CHtml::textArea('koderekening', $kode_rekening, array('class' => 'span3', 'disabled' => true)); 
        ?>
    </td>
    <td>
        <?php echo $form->textField($modSumberDana, '[0]komponen_kegiatan', array('disabled' => true, 'class' => 'span2', 'style' => "width: 120px", 'placeholder' => 'Komponen Kegiatan')); ?>
    </td>
    <td>
        <?php 
        $disable = true;
        if (!empty($_GET['revisi'])) {
            $disable = false;
        }
        
        echo $form->hiddenField($modSumberDana, '[0]pengadaansumberdana_id', array('readonly' => true, 'class' => 'span2 required', 'style' => "width: 110px;text-align:right")); 
        echo $form->textField($modSumberDana, '[0]pagus', array('disabled' => $disable, 'class' => 'pagu span2 integer-decimal required', 'style' => "width: 110px;text-align:right", 'onblur' => 'hitungTotalSumberDana();', 'placeholder' => '10.000')); ?>
    </td>
</tr>