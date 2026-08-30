<?php 

	$ii = 1;
    $i = 'ii';
		$detail->harganettoubah = $detail->harganettofaktur;
		$detail->persendiscount = number_format($detail->persendiscount,2,",","");
		$detail->harganettofaktur = number_format($detail->harganettofaktur,2,",",".");
		$detail->harganettoubah = number_format($detail->harganettoubah,2,",",".");
		$detail->jmldiscount = number_format($detail->jmldiscount,2,",",".");
		$detail->hargasatuan = number_format($detail->hargasatuan,2,",",".");
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
		<?php //echo MyFormatter::formatNumberForPrint($detail->jmlterima).' '.$detail->obatalkes->satuankecil->satuankecil_nama; ?>
		<?php echo CHtml::activeTextField($detail, '['.$i.']jmlterima',array('onblur'=>'hitungTotal();','class'=>'span1 integer2 qty', 'style'=>'text-align:right;')).' '.$detail->obatalkes->satuankecil->satuankecil_nama; ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']fakturdetail_id',array('class'=>'span2 fakturdetail_id', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']kemasanbesar',array('class'=>'span2', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']satuankecil_id',array('class'=>'span2', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']satuanbesar_id',array('class'=>'span2', 'style'=>'text-align:right;')); ?>		
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']sumberdana_id',array('class'=>'span2', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']obatalkes_id',array('class'=>'span2 obat_id', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']tglkadaluarsa',array('class'=>'span2', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']penerimaandetail_id',array('class'=>'span2 penerimaandetail_id', 'style'=>'text-align:right;')); ?>
	</td>
	<td style="text-align: right;">
		<?php echo CHtml::activeTextField($detail, '['.$i.']harganettofaktur',array('onblur'=>'setNettoUbah(this);hitungTotal();', 'class'=>'span2 integer-decimal netto', 'style'=>'text-align:right;')); ?>
		<?php echo CHtml::activeHiddenField($detail, '['.$i.']harganettoubah',array('onblur'=>'hitungTotal();', 'class'=>'span2 integer-decimal', 'style'=>'text-align:right;')); ?>
	</td>
	<td style="text-align: right;">
		<?php echo CHtml::activeTextField($detail, '['.$i.']persendiscount',array('onblur'=>'setJmlDiskon(this);;hitungTotal();','class'=>'float2 persendiscount_terima', 'style'=>'text-align:right;width:45px;')); ?>
	</td>
	<td style="text-align: right;">
		<?php echo CHtml::activeTextField($detail, '['.$i.']jmldiscount',array('onblur'=>'setPersenDiskon(this, true);hitungTotal();','class'=>'span2 integer-decimal jmldiscount_terima', 'style'=>'text-align:right;')); ?>
        <?php echo CHtml::hiddenField('jmldiscount_raw',0,array('readonly'=>false,'class'=>'span2 integerfloat jmldiscount_raw')); ?>
    </td>
	<td style="text-align: right;">
		<?php echo CHtml::activeTextField($detail, '['.$i.']persenppnfaktur',array('onblur'=>'setPersenPPN(this);hitungTotal();','class'=>'integer2 ppn_terima', 'style'=>'text-align:right;width:45px;')); ?>
	</td>
	<td style="text-align: right;" hidden>
		<?php echo MyFormatter::formatNumberForPrint($detail->persendiscount); ?>
	</td>
	<td style="text-align: right;">
		<?php echo CHtml::activeTextField($detail, '['.$i.']hargasatuan',array('class'=>'span2 integer-decimal', 'style'=>'text-align:right;','onblur'=>'setHPP(this);hitungTotalByHPP();')); ?>
	</td>
	<td style="text-align: right;">
		<?php 

			echo CHtml::activeTextField($detail, '['.$i.']subtotal',array('readonly'=>true,'class'=>'span2  integer-decimal', 'style'=>'text-align:right;')); 
		?>
	</td>
	 <td>
		 <a onclick="batalObat(this);return false;" data-placement="left" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat & alkes"><i class="<?php echo MyIcon::getIcons('batal'); ?>"></i></a>
	</td>
</tr>

