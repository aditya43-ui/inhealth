<?php $modFakturDetail->tglkadaluarsa = MyFormatter::formatDateTimeForUser($modFakturDetail->tglkadaluarsa); 

$modFakturDetail->persendiscount = number_format($modFakturDetail->persendiscount, 2,",",".");
$modFakturDetail->persenpphfaktur = number_format($modFakturDetail->persenpphfaktur, 2,",",".");
$modFakturDetail->harganettopermaster = $modFakturDetail->obatalkes->harganetto;
$modFakturDetail->namaobatmaster = $modFakturDetail->obatalkes->obatalkes_nama;

?>

<tr>
    <td>
        <?php echo CHtml::textField('no_urut',$no++,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>        
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>        
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']tglkadaluarsa',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']penerimaandetail_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']fakturdetail_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php // echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']kemasanbesar',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php // echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']satuanbesar_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php // echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']satuankecil_id',array('readonly'=>true,'class'=>'span2')); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']harganettopermaster',array()); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']hppcheck',array()); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']namaobatmaster',array()); ?>
    </td>
    <td>
        <?php echo $modFakturDetail->obatalkes->obatalkes_kode; ?>
    </td>
    <td>
        <?php echo $modFakturDetail->obatalkes->obatalkes_nama; ?>
    </td>
    <td>
        <?php 
        $besar = SatuanbesarM::model()->findByPk($modFakturDetail->satuanbesar_id);
        $kecil = SatuankecilM::model()->findByPk($modFakturDetail->satuankecil_id);
            $satuanobatnama = "";
            if(!empty($modFakturDetail->satuanbesar_id)){
                $satuanobatnama = (isset($besar)?$besar->satuanbesar_nama:"");
                echo CHtml::activeHiddenField($modFakturDetail, '['.$key.']satuanbesar_id', array('style'=>'width:80px;'));
                echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2 kemasanbesar','style'=>'width:80px;'));
            }else{
                $satuanobatnama = (isset($kecil)?$kecil->satuankecil_nama:"");
                echo CHtml::activeHiddenField($modFakturDetail, '['.$key.']satuankecil_id', array('style'=>'width:80px;'));
            }
        ?>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']jmlterima',array('readonly'=>true,'class'=>'span1 integer-decimal qty','style'=>'width:40px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")).' '.$satuanobatnama; ?>
    </td>
	<td>
        <?php 
            echo CHtml::activeTextField($modFakturDetail,'['.$key.']harganettofaktur',array('readonly'=>true,'class'=>'text-right span2 integer-decimal netto','onblur'=>'setNettoUbah(this);hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); 
            echo CHtml::activeHiddenField($modFakturDetail,'['.$key.']harganettoubah',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);"));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']persendiscount',array('readonly'=>true,'class'=>'span2 integer-decimal persendisc','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']jmldiscount',array('readonly'=>true,'class'=>'text-right span2 integer-decimal jmldisc','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']persenppnfaktur',array('readonly'=>true,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']jmlppn',array('readonly'=>true,'class'=>'text-right span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']persenpphfaktur',array('readonly'=>true,'class'=>'span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>  
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']jmlpph',array('readonly'=>true,'class'=>'text-right span2 integer-decimal','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
            <?php echo CHtml::activeTextField($modFakturDetail, '['.$key.']hargasatuanper',array('readonly'=>true,'class' => 'text-right span2 integer-decimal','onblur'=>'setHPP(this);hitungTotalByHPP();')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'['.$key.']subtotal',array('readonly'=>true,'class'=>'text-right span2 integer-decimal','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
</tr>