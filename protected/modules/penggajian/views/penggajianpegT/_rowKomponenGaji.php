<?php
$class_tunjangan = $v->tipekomponengaji == Params::TIPE_KOMPONEN_GAJI_TUNJANGAN_TETAP ? 'tunjangan_tetap' : '';
?>

<tr data-kode="<?php echo $v->komponengaji_kode; ?>" class="row_komponen">
	<td style="padding-left : 40px;">
        <?php echo $v->komponengaji_kode.' - '.$v->komponengaji_nama; ?>
        <?php echo CHtml::hiddenField('tipekomponen', $v->tipekomponengaji, array('class'=>'tipekomponengaji')); ?>
        <?php
        foreach ($mod_jasa as $item) {
            echo CHtml::hiddenField('data_jasa['.$v->komponengaji_id.'][]', $item->pembjasadetail_id);
        }
        
        foreach ($mod_askep as $item) {
            echo CHtml::hiddenField('data_askep['.$v->komponengaji_id.'][]', $item->pembjasaperawat_id);
        }
        ?>
    </td>
    <td nowrap>
        <?php 
        if($v->komponengaji_id == 103){
            echo CHtml::activeDropDownList($komponen,"[" . $v->komponengaji_id . "]qty", $komponen->setNilaiBonus() ,array(
                'class'=>'span1 qty', 
                'onkeypress'=>"return $(this).focusNextInputField(event);", 
                'onchange'=>'hitungGaji(); setFokusBonus();',
                'maxlength'=>50)); 
            }
        else{
            echo CHtml::activeTextField($komponen, "[" . $v->komponengaji_id . "]qty", array(
                'value'=>$qty,
                'class'=>'form-control qty span1',
                'style'=>'text-align: right',
                'onblur'=>'hitungGaji();',
            ));
        }
        ?>
        <?php 
        if($v->komponengaji_id == 102){
                $komponen->unit = "BULAN";
            }else{
                $komponen->unit = $v->unit;
            }
        
        echo CHtml::activeDropDownList($komponen,"[" . $v->komponengaji_id . "]unit", LookupM::getItems('satuanumum'),array(
            'empty'=>'-- Unit --',
            'class'=>'span2 unit', 
            'onkeypress'=>"return $(this).focusNextInputField(event);", 
            'onchange'=>'hitungHariKerjaUntukTunjanganTidakTetap();',
            'maxlength'=>50)); 
        ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($komponen, "[" . $v->komponengaji_id . "]subtotalketerlambatan", array(
            'class'=>'form-control subtotalketerlambatan integer2 span2',
        'value' => $penguranganterlambat,
        )); ?>
        <?php echo CHtml::activeTextField($komponen, "[" . $v->komponengaji_id . "]satuan", array(
            'class'=>'form-control satuan integer2 span2',
            'onblur'=>'hitungGaji();',
        'value' => $val,
        )); ?></td>
	<td><?php 
		if ($v->ispotongan == false)
			echo CHtml::activeTextField($komponen, "[" . $v->komponengaji_id . "]jumlah", array(
				'value' => 0, 
				'class' => 'span2 integer2 gaji pph subtotal '.$class_tunjangan, 
				// 'onblur' => 'setGaji(); hitungpph();',
				'style' => 'text-align: right;',
                'readonly'=>true,
			));
	?></td>
	<td><?php 
		if ($v->ispotongan == true)
			echo CHtml::activeTextField($komponen, "[" . $v->komponengaji_id . "]jumlah", array(
				'value' => 0,
				'class' => 'span2 integer2 potongan pph subtotal', 
				// 'onblur' => 'setPotongan();', 
				'style' => 'text-align: right;',
                'readonly'=>true,
			));
	?></td>
</tr>