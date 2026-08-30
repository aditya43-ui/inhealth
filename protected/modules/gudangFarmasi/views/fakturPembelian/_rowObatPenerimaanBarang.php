<?php $modFakturDetail->tglkadaluarsa = MyFormatter::formatDateTimeForUser($modFakturDetail->tglkadaluarsa); 

$modFakturDetail->persendiscount = MyFormatter::formatNumberForPrint($modFakturDetail->persendiscount, 2);
$modFakturDetail->harganettopermaster = MyFormatter::formatNumberForPrint($modFakturDetail->obatalkes->harganetto,2);
$modFakturDetail->jmlterima = MyFormatter::formatNumberForPrint($modFakturDetail->jmlterima,2);
$modFakturDetail->jmlpph = MyFormatter::formatNumberForPrint($modFakturDetail->jmlpph,2);
$modFakturDetail->harganettoper = MyFormatter::formatNumberForPrint($modFakturDetail->harganettoper,2);

$modFakturDetail->namaobatmaster = $modFakturDetail->obatalkes->obatalkes_nama;

?>

<tr>
    <td hidden>
        <?php //echo CHtml::activeCheckBox($modFakturDetail,'[ii]checklist',array('class'=>'inputFormTabel lebar2')); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>        
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>        
        <?php //echo CHtml::activeHiddenField($modFakturDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php //echo CHtml::activeHiddenField($modFakturDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]penerimaandetail_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php // echo CHtml::activeHiddenField($modFakturDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php // echo CHtml::activeHiddenField($modFakturDetail,'[ii]satuanbesar_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php // echo CHtml::activeHiddenField($modFakturDetail,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span2')); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]harganettopermaster',array('class'=>'span2 integer-decimal')); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]hppcheck',array()); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]namaobatmaster',array()); ?>
    </td>
    <td>
        <?php echo $modFakturDetail->obatalkes->obatalkes_kode; ?>
    </td>
    <td>
        <?php echo $modFakturDetail->obatalkes->obatalkes_nama; ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmlpermintaan',array('readonly'=>false,'class'=>'span2 integer-decimal','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
        $besar = SatuanbesarM::model()->findByPk($modFakturDetail->satuanbesar_id);
        $kecil = SatuankecilM::model()->findByPk($modFakturDetail->satuankecil_id);
            $satuanobatnama = "";
            if(!empty($modFakturDetail->satuanbesar_id)){
                $satuanobatnama = (isset($besar)?$besar->satuanbesar_nama:"");
                echo CHtml::activeHiddenField($modFakturDetail, '[ii]satuanbesar_id', array('style'=>'width:80px;'));
                echo CHtml::activeHiddenField($modFakturDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2 kemasanbesar','style'=>'width:80px;'));
            }else{
                $satuanobatnama = (isset($kecil)?$kecil->satuankecil_nama:"");
                echo CHtml::activeHiddenField($modFakturDetail, '[ii]satuankecil_id', array('style'=>'width:80px;'));
            }
        ?>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmlterima',array('readonly'=>true,'class'=>'span1 integer-decimal qty','style'=>'width:40px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.$satuanobatnama; ?>
    </td>
	<td>
        <?php //echo CHtml::activeTextField($modFakturDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integerfloat netto','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); 
				echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modFakturDetail,'[ii]harganettoper',array('readonly'=>true,'class'=>'span2 integer-decimal netto','onblur'=>'setNettoUbah(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modFakturDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integerfloat netto','onblur'=>'setNettoUbah(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); 
				echo CHtml::activeHiddenField($modFakturDetail,'[ii]harganettoubah',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);"));
		?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]persendiscount',array('readonly'=>true,'class'=>'span1 integer-decimal persendisc','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmldiscount',array('readonly'=>true,'class'=>'span2 integer-decimal jmldisc','onblur'=>'setPersenDiskon(this); hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span1 integer2','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<?php // echo CHtml::activeHiddenField($modFakturDetail,'[ii]jmlppn',array('readonly'=>false,'class'=>'span2 integerfloat','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmlppn',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span1 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<?php // echo CHtml::activeHiddenField($modFakturDetail,'[ii]jmlpph',array('readonly'=>false,'class'=>'span2 integerfloat','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>  
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmlpph',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
		<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?CHtml::activeTextField($modFakturDetail, '[ii]hargasatuanper',array('readonly'=>true,'class' => 'span2 integer-decimal','onblur'=>'setHPP(this);hitungTotalByHPP();')):CHtml::activePasswordField($modFakturDetail, '[ii]hargasatuanper',array('readonly'=>true,'class' => 'span2 integerfloat','onblur'=>'setHPP(this);hitungTotalByHPP();')) ?>
	</td>
    <td>
        <?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? CHtml::activeTextField($modFakturDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer-decimal','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")):CHtml::activePasswordField($modFakturDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integerfloat','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
</tr>