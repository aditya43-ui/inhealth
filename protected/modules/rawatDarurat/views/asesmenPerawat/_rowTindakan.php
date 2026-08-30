<tr data-row="<?php echo $idx; ?>">
    <td>
        <?php   
        
        $nama_terima = "";
        if (!empty($modTindakan->tindakan_oleh)) {
            $peg = PegawaiM::model()->findByPk($modTindakan->tindakan_oleh);
            $nama_terima = $peg->namaLengkap;
        }
        
        if (empty($modTindakan->asesmenigdtindak_tgl)) {
            $modTindakan->asesmenigdtindak_tgl = date('Y-m-d H:i:s');
        }
        
        $this->widget('MyDateTimePicker',array(
            'name'=>'det['.$idx.'][asesmenigdtindak_tgl]',
            'value'=>MyFormatter::formatDateTimeForUser($modTindakan->asesmenigdtindak_tgl),
            'mode'=>'datetime',
            'options'=> array(
                'dateFormat'=>Params::DATE_FORMAT,
				'maxDate' => 'd',
            ),
            'htmlOptions'=>array('style'=>'float: left;','readonly'=>true,'class'=>'dtPicker3 asesmenigdtindak_tgl span3','onclick'=>"return $(this).focusNextInputField(event)"),
        )); ?> 
    </td>
    <td>
        <?php echo CHtml::hiddenField('det['.$idx.'][daftartindakan_id]', $modTindakan->daftartindakan_id, array('class'=>'daftartindakan_id')); ?>
        <div class="input-append">
            <?php echo CHtml::textField('det['.$idx.'][tindakan_nama]', $modTindakan->tindakan_nama, array('class'=>'ui-autocomplete-input span3 tindakan_nama', 'readonly'=>false, 'style'=>'float: left;')); ?>
            <span class="dialog_link add-on">
                <a onclick="setDialogTindakan(this); return false;" href="javascript:void(0)">
                    <i class="icon-list"></i>
                    <i class="entypo-search"></i>
                </a>
            </span>
        </div>
    </td>
    <td>
        <div class="input-append">
            <?php echo CHtml::hiddenField('det['.$idx.'][tindakan_oleh]', $modTindakan->tindakan_oleh, array('class'=>'tindakan_oleh')); ?>
            <?php echo CHtml::textField('det['.$idx.'][tindakan_oleh_nama]', $nama_terima, array('class'=>'ui-autocomplete-input span3 tindakan_oleh_nama', 'readonly'=>false, 'style'=>'float: left;')); ?>
            <span class="dialog_link add-on">
                <a onclick="setDialogPegawaiTindakan(this); return false;" href="javascript:void(0)">
                    <i class="icon-list"></i>
                    <i class="entypo-search"></i>
                </a>
            </span>
        </div>
    </td>
    <td style="text-align: center;">
        <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
            'onclick'=>'removeRowTindakan(this); return false;'
        )); ?>
    </td>
</tr>