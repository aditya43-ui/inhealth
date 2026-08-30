<?php if(!empty($modDetail->satuankecil_id)){
    $modDetail->satuanobat = Params::SATUANOBAT_KECIL;
}else if(!empty($modDetail->satuanbesar_id)){
    $modDetail->satuanobat = Params::SATUANOBAT_BESAR;
} 
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]ppn_persen',array('readonly'=>true,'class'=>'integer-decimal')); ?>
    </td>
    <td>
        <?php echo (isset($modObatAlkes->jenisobatalkes)? $modObatAlkes->jenisobatalkes->jenisobatalkes_nama : ""); ?>
    </td>
    <td>
        <?php echo $modObatAlkes->obatalkes_nama; ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modDetail, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil">
            <?php echo CHtml::activeDropDownList($modDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif = true'),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        </div>
        <div class="satuanbesar" style="display:none;">
            <?php echo CHtml::activeDropDownList($modDetail, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll('satuanbesar_aktif = true'),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;')); ?>
            <?php echo CHtml::activeTextField($modDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;')); ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]harganettolama',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]diskonlama',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]ppnlama',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]hpplama',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]marginlama',array('readonly'=>true,'class'=>'span2 integer2','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]hargajuallama',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]harganettobaru',array('onblur'=>"hitungTotal();",'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]diskonbaru',array('onblur'=>"hitungTotal();",'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]ppnbaru',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]hppbaru',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
     <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]marginbaru',array('onblur'=>"hitungTotal();",'class'=>'span2 integer2','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:45px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]hargajualbaru',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'text-align:right;width:90px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDetail,'[ii]alasanperubahan',array('class'=>'span2 required','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>