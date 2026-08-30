<?php 
if (count((array)$modDetailBeli)>0){
	$ii = 1;
    foreach ($modDetailBeli as $i => $detail) {  
        
        $kemasan = 1;
        $satuanobatnama = "";
             if (!empty($detail->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($detail->satuanbesar_id);
                     $satuanobatnama = $besar->satuanbesar_nama;
                     $kemasan = $detail->kemasanbesar;
                } else if (!empty($detail->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($detail->satuankecil_id);
                    $satuanobatnama = $kecil->satuankecil_nama;
                }
            $jmlterima = ($detail->jmlterima * $kemasan);
                $totalHpp = ($jmlterima * $detail->hargasatuan);
                $totalHpp = number_format($totalHpp,2,",",".");
		$detail->harganettoubah = $detail->harganettofaktur;
		$detail->persendiscount = number_format($detail->persendiscount,2,",","");
		$detail->harganettofaktur = number_format($detail->harganettofaktur,2,",",".");
		$detail->harganettoubah = number_format($detail->harganettoubah,2,",",".");
		$detail->jmldiscount = number_format($detail->jmldiscount,2,",",".");
		$detail->hargasatuan = number_format($detail->hargasatuan,2,",",".");
                $detail->jmlterima = number_format($detail->jmlterima,2,",",".");
                
                
                
        ?>
        <tr>
			<td>
				<span id="no_urut"><?php echo $ii; ?></span>
			</td>
            <td>
				<span class="nama_obat">
                <?php echo $detail->obatalkes->obatalkes_nama; ?>
				</span>
            </td>
            <td style="text-align: right;">
                <?php 
            if(!empty($detail->satuanbesar_id)){
                echo CHtml::activeHiddenField($detail,'['.$i.']kemasanbesar',array('readonly'=>true,'class'=>'span2 integer2 kemasanbesar','style'=>'width:80px;'));
            }
        ?>
                
                <?php //echo MyFormatter::formatNumberForPrint($detail->jmlterima).' '.$detail->obatalkes->satuankecil->satuankecil_nama; ?>
                <?php echo CHtml::activeTextField($detail, '['.$i.']jmlterima',array('onblur'=>'hitungTotal();','class'=>'span1 integer-decimal qty', 'style'=>'text-align:right;','readonly'=>true)).' '.$satuanobatnama; ?>
                <?php echo CHtml::activeHiddenField($detail, '['.$i.']fakturdetail_id',array('class'=>'span2 fakturdetail_id', 'style'=>'text-align:right;')); ?>
                <?php echo CHtml::activeHiddenField($detail, '['.$i.']penerimaandetail_id',array('class'=>'span2 penerimaandetail_id', 'style'=>'text-align:right;')); ?>
                <?php echo CHtml::activeHiddenField($detail, '['.$i.']obatalkes_id',array('class'=>'span2 obat_id', 'style'=>'text-align:right;')); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']harganettofaktur',array('onblur'=>'setNettoUbah(this);hitungTotal();', 'class'=>'span2 integer-decimal netto', 'style'=>'text-align:right;','readonly'=>true)); ?>
				<?php echo CHtml::activeHiddenField($detail, '['.$i.']harganettoubah',array('onblur'=>'hitungTotal();', 'class'=>'span2 integer-decimal', 'style'=>'text-align:right;')); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']persendiscount',array('onblur'=>'setJmlDiskon(this);hitungTotal();','class'=>'float2 persendiscount_terima', 'style'=>'text-align:right;width:45px;','readonly'=>true)); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']jmldiscount',array('onblur'=>'setPersenDiskon(this);hitungTotal();','class'=>'span2 integer-decimal jmldiscount_terima', 'style'=>'text-align:right;','readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('jmldiscount_raw',0,array('readonly'=>false,'class'=>'span2 integerfloat jmldiscount_raw')); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']persenppnfaktur',array('onblur'=>'setPersenPPN(this);hitungTotal();','class'=>'integer2 ppn_terima', 'style'=>'text-align:right;width:45px;','readonly'=>true)); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']jmlppn',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true)); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']persenpphfaktur',array('readonly'=>false,'onblur'=>'hitungTotal();','class'=>'integer2', 'style'=>'text-align:right;width:45px;','readonly'=>true)); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']jmlpph',array('class'=>'integer-decimal span2', 'style'=>'text-align:right;','readonly'=>true)); ?>
            </td>
            <td style="text-align: right;">
                <?php echo CHtml::activeTextField($detail, '['.$i.']hargasatuan',array('class'=>'span2 integer-decimal', 'style'=>'text-align:right;','onblur'=>'setHPP(this);hitungTotal();','readonly'=>true)); ?>
            </td>
            <td style="text-align: right;">
                <?php 
				
					echo CHtml::activeTextField($detail, '['.$i.']subtotal',array('readonly'=>true,'class'=>'span2  integer-decimal', 'style'=>'text-align:right;')); 
				?>
            </td>
             <td style="text-align: right;" hidden>
                <?php 
				
					echo CHtml::textField('['.$i.']subtotalHpp',$totalHpp,array('readonly'=>true,'class'=>'span2  integer-decimal', 'style'=>'text-align:right;')); 
				?>
            </td>
        </tr>
    <?php 
	$ii++;
    }
}
?>

