<tr data-row="<?php echo $idx; ?>">
    <td>
        <?php   
        $periksa = "";
        if (!empty($terapi->terapi_diperiksa)) {
            $peg = PegawaiM::model()->findByPk($terapi->terapi_diperiksa);
            $periksa = $peg->namaLengkap;
        }
        
        $pemberi = "";
        if (!empty($terapi->terapi_diberikan)) {
            $peg = PegawaiM::model()->findByPk($terapi->terapi_diberikan);
            $pemberi = $peg->namaLengkap;
        }
        
        if (empty($terapi->asesmenigdterapi_tgl)) {
            $terapi->asesmenigdterapi_tgl = date('Y-m-d H:i:s');
        }
        
        
        $this->widget('MyDateTimePicker',array(
            'name'=>'terapi['.$idx.'][asesmenigdterapi_tgl]',
            'value'=>MyFormatter::formatDateTimeForUser($terapi->asesmenigdterapi_tgl),
            'mode'=>'datetime',
            'options'=> array(
                'dateFormat'=>Params::DATE_FORMAT,
				'maxDate' => 'd',
            ),
            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 asesmenigdterapi_tgl span3','onclick'=>"return $(this).focusNextInputField(event)"),
        )); ?> 
    </td>
    <td>
        <?php echo CHtml::hiddenField('terapi['.$idx.'][obatalkes_id]', $terapi->obatalkes_id, array('class'=>'obatalkes_id')); ?>
        <div class="input-append">
            <?php echo CHtml::textField('terapi['.$idx.'][obatalkes_nama]',  $terapi->obatalkes_nama, array('class'=>'ui-autocomplete-input span3 obatalkes_nama', 'readonly'=>false, 'style'=>'float: left;')); ?>
            <span class="dialog_link add-on">
                <a onclick="setDialogTerapi(this); return false;" href="javascript:void(0)">
                    <i class="icon-list"></i>
                    <i class="entypo-search"></i>
                </a>
            </span>
        </div>
    </td>
    <td>
        <?php echo CHtml::textField('terapi['.$idx.'][terapi_dosis]', $terapi->terapi_dosis, array('class'=>'terapi_dosis span2')); ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('terapi['.$idx.'][terapi_rute]', $terapi->terapi_rute, LookupM::getItems('terapi_rute'), array('empty'=>'-- Pilih --', 'class'=>'terapi_rute span1')); ?>
    </td>
    <td>
        <div class="input-append">
            <?php echo CHtml::hiddenField('terapi['.$idx.'][terapi_diperiksa]', $terapi->terapi_diperiksa, array('class'=>'terapi_diperiksa')); ?>
            <?php echo CHtml::textField('terapi['.$idx.'][terapi_diperiksa_nama]', $periksa, array('class'=>'ui-autocomplete-input span3 terapi_diperiksa_nama', 'readonly'=>false, 'style'=>'float: left;')); ?>
            <span class="dialog_link add-on">
                <a onclick="setDialogPeriksaTerapi(this); return false;" href="javascript:void(0)">
                    <i class="icon-list"></i>
                    <i class="entypo-search"></i>
                </a>
            </span>
        </div>
    </td>
    <td>
        <div class="input-append">
            <?php echo CHtml::hiddenField('terapi['.$idx.'][terapi_diberikan]', $terapi->terapi_diberikan,  array('class'=>'terapi_diberikan')); ?>
            <?php echo CHtml::textField('terapi['.$idx.'][terapi_diberikan_nama]', $pemberi, array('class'=>'ui-autocomplete-input span3 terapi_diberikan_nama', 'readonly'=>false, 'style'=>'float: left;')); ?>
            <span class="dialog_link add-on">
                <a onclick="setDialogPemberiTerapi(this); return false;" href="javascript:void(0)">
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

