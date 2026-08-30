<?php 

$obatalkes = ObatalkesM::model()->findByPk($modPenerimaanBarangDetail->obatalkes_id);

if (!empty($modPenerimaanBarang->penerimaanbarang_id)){
	
	$modPenerimaanBarangDetail->hargasatuanper = MyFormatter::formatNumberForPrint($modPenerimaanBarangDetail->hargasatuanper, 2);
    // $modPenerimaanBarangDetail->harganettoubah = MyFormatter::formatNumberForPrint($modPenerimaanBarangDetail->harganettoubah, 2);
}


//if (!empty($modPenerimaanBarangDetail->persendiscount))
//    $modPenerimaanBarangDetail->persendiscount = MyFormatter::formatNumberForPrint($modPenerimaanBarangDetail->persendiscount, 2);
// $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForUser($modPenerimaanBarangDetail->tglkadaluarsa); ?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>        
        <?php //echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php // echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td hidden>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modPenerimaanBarangDetail->sumberdana_id) ? $modPenerimaanBarangDetail->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPenerimaanBarangDetail->obatalkes_id) ? $modPenerimaanBarangDetail->obatalkes->obatalkes_kode : "") ?></span>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]nobatch',array('readonly'=>false,'class'=>'span2 required','style'=>'width:90px;',	'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
    <td>
        <?php // echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span2')); ?>
        <?php  
            $modPenerimaanBarangDetail->tglkadaluarsa = (!empty($modPenerimaanBarangDetail->tglkadaluarsa) ? date("d/m/Y H:i:s",strtotime($modPenerimaanBarangDetail->tglkadaluarsa)) : null);
            $this->widget('MyDateTimePicker',array(
                //'id'=>'[ii]tglkadaluarsa',
                'model'=>$modPenerimaanBarangDetail,
                'attribute'=>'['.(isset($i)?$i:'ii').']tglkadaluarsa',
                'mode'=>'datetime',
                'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'minDate' => 'd',
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'placeholder'=>'00/00/0000 00:00:00',
					'class'=>'dtPicker2 datetimemask required',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:130px;'
                ),
        ));
            $modPenerimaanBarangDetail->tglkadaluarsa = $format->formatDateTimeForDb($modPenerimaanBarangDetail->tglkadaluarsa); ?>
    </td>
	<td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modPenerimaanBarangDetail->obatalkes_id) ? $modPenerimaanBarangDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span1','onkeyup'=>"return $(this).focusNextInputField(event);", 'style' => 'text-align:right;'))." ".(!empty($obatalkes->satuankecil)? $obatalkes->satuankecil->satuankecil_nama : ""); ?>
	</td>

	<td hidden>
		<?php echo CHtml::hiddenField('harganetto', MyFormatter::formatNumberForPrint($obatalkes->harganetto,2), array('class'=>'harganetto integer-decimal')); ?>
		<?php echo CHtml::hiddenField('obatalkes_nama', $obatalkes->obatalkes_nama, array('class'=>'obatalkes_nama')); ?>
        <?php echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]hppcheck',array()); ?>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmlpermintaan',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
    <td>    
        <?php 
        $besar = SatuanbesarM::model()->findByPk($modPenerimaanBarangDetail->satuanbesar_id);
        $kecil = SatuankecilM::model()->findByPk($modPenerimaanBarangDetail->satuankecil_id);
            echo CHtml::activeHiddenField($modPenerimaanBarangDetail, '[ii]satuanobat', array('readonly'=>true));
            $satuanobatnama = "";
            if(!empty($modPenerimaanBarangDetail->satuanbesar_id)){
                $satuanobatnama = (isset($besar)?$besar->satuanbesar_nama:"");
                echo CHtml::activeHiddenField($modPenerimaanBarangDetail, '[ii]satuanbesar_id', array('style'=>'width:80px;'));
                echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2 kemasanbesar','style'=>'width:80px;'));
            }else{
                $satuanobatnama = (isset($kecil)?$kecil->satuankecil_nama:"");
                echo CHtml::activeHiddenField($modPenerimaanBarangDetail, '[ii]satuankecil_id', array('style'=>'width:80px;'));
            }
        ?>
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmlterima',array('readonly'=>false,'class'=>'span1 integer-decimal qty','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.$satuanobatnama; ?>
    </td>
    <td>
        <?php 			
		echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integer-decimal netto','onblur'=>'setNettoUbah(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modPenerimaanBarangDetail,'[ii]harganettoper',array('readonly'=>true,'class'=>'span2 integer-decimal netto','onblur'=>'setNettoUbah(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); 
		echo CHtml::activeHiddenField($modPenerimaanBarangDetail,'[ii]harganettoubah',array('readonly'=>false,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);"));
		?>
    </td>
    
    <td>
        <?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]persendiscount',array('readonly'=>true,'class'=>'span1 integer-decimal persendiscount_terima','onblur'=>'setJmlDiskon(this);hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<?php // echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmldiscount',array('readonly'=>false,'class'=>'span2 integerfloat jmldiscount_terima','onblur'=>'setPersenDiskon(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo CHtml::hiddenField('jmldiscount_raw',0,array('readonly'=>false,'class'=>'span2 integer-decimal jmldiscount_raw')); ?>
    </td>  
    <td>
		<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmldiscount',array('readonly'=>true,'class'=>'span2 integer-decimal jmldiscount_terima','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")) : CHtml::activePasswordField($modPenerimaanBarangDetail,'[ii]jmldiscount',array('readonly'=>true,'class'=>'span2 integer-decimal jmldiscount_terima','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span1 integer2 ppn_terima','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmlppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")) : CHtml::activePasswordField($modPenerimaanBarangDetail,'[ii]jmlppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span1 integer-decimal pph_terima','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
    </td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]jmlpph',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")) : CHtml::activePasswordField($modPenerimaanBarangDetail,'[ii]jmlpph',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
		<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?  CHtml::activeTextField($modPenerimaanBarangDetail, '[ii]hargasatuanper',array('readonly'=>true,'class' => 'span2 integer-decimal','onblur'=>'setHPP(this);hitungTotal();')):CHtml::activePasswordField($modPenerimaanBarangDetail, '[ii]hargasatuanper',array('readonly'=>true,'class' => 'span2 integer-decimal','onblur'=>'setHPP(this);hitungTotal();','style'=>'width:90px;')); ?>
	</td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modPenerimaanBarangDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modPenerimaanBarangDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td hidden>
        <a onclick="batalObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-remove"></i></a>
    </td>
</tr>