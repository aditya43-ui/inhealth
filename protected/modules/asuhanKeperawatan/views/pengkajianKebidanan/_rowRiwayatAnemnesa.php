<tr>
	<td>
		<span name="riwayatAnemnesa[ii][isanamesa]"><?php echo CHtml::activeCheckBox($modRiwayatAnemnesa, '[ii]isanamesa',array('uncheckValue'=>NULL,'onclick'=>'cekListAnamesa(this);','onkeyup'=>"return $(this).focusNextInputField(event);")) .  CHtml::activeHiddenField($modRiwayatAnemnesa, '[ii]anamesa_id',array('readonly'=>true, 'class'=>'span1'))  ;?></span>
	</td>
    <td>
		<span name="riwayatAnemnesa[ii][tglanamnesis]"><?php echo (!empty($modRiwayatAnemnesa->tglanamnesis) ? MyFormatter::formatDateTimeForUser($modRiwayatAnemnesa->tglanamnesis) : "") ?></span>
    </td>
    <td>
        <span name="riwayatAnemnesa[ii][keluhanutama]"><?php echo (!empty($modRiwayatAnemnesa->keluhanutama) ? $modRiwayatAnemnesa->keluhanutama : "") ?></span>
    </td>
    <td>
        <span name="riwayatAnemnesa[ii][keluhantambahan]"><?php echo (!empty($modRiwayatAnemnesa->keluhantambahan) ? $modRiwayatAnemnesa->keluhantambahan : "") ?></span>
    </td>
	<td>
        <span name="riwayatAnemnesa[ii][riwayatpenyakitterdahulu]"><?php echo (!empty($modRiwayatAnemnesa->riwayatpenyakitterdahulu) ? $modRiwayatAnemnesa->riwayatpenyakitterdahulu : "") ?></span>
    </td>
    <td>
        <span name="riwayatAnemnesa[ii][riwayatpenyakitkeluarga]"><?php echo (!empty($modRiwayatAnemnesa->riwayatpenyakitkeluarga) ? $modRiwayatAnemnesa->riwayatpenyakitkeluarga : "") ?></span>
    </td>
	<td>
        <span name="riwayatAnemnesa[ii][riwayatimunisasi]"><?php echo (!empty($modRiwayatAnemnesa->riwayatimunisasi) ? $modRiwayatAnemnesa->riwayatimunisasi : "") ?></span>
    </td>
	<td>
        <span name="riwayatAnemnesa[ii][riwayatalergiobat]"><?php echo (!empty($modRiwayatAnemnesa->riwayatalergiobat) ? $modRiwayatAnemnesa->riwayatalergiobat : "") ?></span>
    </td>
    <td>
        <span name="riwayatAnemnesa[ii][riwayatmakanan]"><?php echo (!empty($modRiwayatAnemnesa->riwayatmakanan) ? $modRiwayatAnemnesa->riwayatmakanan : "") ?></span>
    </td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i class='icon-form-detail'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/PengkajianKebidanan/detailAnamnesis",array("anamesa_id"=>$modRiwayatAnemnesa->anamesa_id)),array("target"=>"frameDetailAnamnesis","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesis", "onclick"=>"window.parent.$('#dialogDetailAnamnesis').dialog('open')")); ?>
	</td>
</tr>