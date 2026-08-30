<?php // $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForUser($modPenerimaanBarangDetail->tglkadaluarsa); ?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>        
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modPenerimaanBarangDetail->sumberdana_id) ? $modPenerimaanBarangDetail->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPenerimaanBarangDetail->obatalkes_id) ? $modPenerimaanBarangDetail->obatalkes->obatalkes_kategori ."<br/>".$modPenerimaanBarangDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]nobatch',array('readonly'=>false,'class'=>'span2','style'=>'width:90px;',	'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
    <td>
        <?php // echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span2')); ?>
        <?php  
            $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($modPenerimaanBarangDetail->tglkadaluarsa) ? date("d/m/Y H:i:s",strtotime($modPenerimaanBarangDetail->tglkadaluarsa)) : null);
            $this->widget('MyDateTimePicker',array(
                'id'=>'[ii]tglkadaluarsa',
                'model'=>$modPenerimaanBarangDetail,
                'attribute'=>'[ii]tglkadaluarsa',
                'mode'=>'datetime',
                'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'minDate' => 'd',
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                ),
        ));
            $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForDb($modPenerimaanBarangDetail->tglkadaluarsa); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modPenerimaanBarangDetail, '[ii]satuanobat', LookupM::getItems('satuanobat'),array('onChange'=>'pilihSatuan(this);','style'=>'width:100px;')); ?><br>
        <div class="satuankecil" <?php echo (empty($modPenerimaanBarangDetail->satuankecil_id) ?  'style="display:none;"' : "");?>>
            <?php echo CHtml::activeDropDownList($modPenerimaanBarangDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
        </div>
        <div class="satuanbesar" <?php echo (empty($modPenerimaanBarangDetail->satuanbesar_id) ?  'style="display:none;"' : "");?>>
            <?php echo CHtml::activeDropDownList($modPenerimaanBarangDetail, '[ii]satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(),'satuanbesar_id','satuanbesar_nama'),array('style'=>'width:80px;')); ?>
            <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 float','style'=>'width:90px;')); ?>
        </div>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmlpermintaan',array('readonly'=>true,'class'=>'span2 float','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
    <td>        
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmlterima',array('readonly'=>false,'class'=>'span2 float','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 float','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]hargasatuanper',array('readonly'=>false,'class'=>'span2 float','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]persendiscount',array('readonly'=>false,'class'=>'span2 float','onblur'=>'setJmlDiskon(this);hitungTotalDiskon(this);hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmldiscount',array('readonly'=>false,'class'=>'span2 float','onblur'=>'setPersenDiskon(this);hitungTotalDiskon(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 float','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-remove"></i></a>
    </td>
</tr>