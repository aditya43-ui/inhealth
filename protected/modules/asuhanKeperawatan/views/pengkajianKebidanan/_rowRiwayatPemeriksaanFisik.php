<tr>
<!--	<td>
	<?php // CHtml::activeCheckBox($modRiwayatPeriksaFisik, '[ii]is_piliperiksa',array('onkeyup'=>"return $(this).focusNextInputField(event);"));
//    CHtml::activeHiddenField($modRiwayatPeriksaFisik, '[ii]pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1'))  ;
    ?>
	</td>-->
	<td>
		<span name="riwayatPeriksaFisik[ii][isperiksafisik]"><?php echo CHtml::activeCheckBox($modRiwayatPeriksaFisik, '[ii]isperiksafisik',array('uncheckValue'=>NULL,'onclick'=>'cekListPeriksa(this);','onkeyup'=>"return $(this).focusNextInputField(event);")) .  CHtml::activeHiddenField($modRiwayatPeriksaFisik, '[ii]pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1'))  ;?></span>
	</td>
    <td>
		<span name="riwayatPeriksaFisik[ii][tglperiksafisik]"><?php echo (!empty($modRiwayatPeriksaFisik->tglperiksafisik) ? MyFormatter::formatDateTimeForUser($modRiwayatPeriksaFisik->tglperiksafisik) : "") ?></span>
    </td>
    <td>
        <span name="riwayatPeriksaFisik[ii][keadaanumum]"><?php echo (!empty($modRiwayatPeriksaFisik->keadaanumum) ? $modRiwayatPeriksaFisik->keadaanumum : "") ?></span>
    </td>
    <td>
        <span name="riwayatPeriksaFisik[ii][beratbadan_kg]"><?php echo (!empty($modRiwayatPeriksaFisik->beratbadan_kg) ? $modRiwayatPeriksaFisik->beratbadan_kg : "") ?></span>
    </td>
	<td>
        <span name="riwayatPeriksaFisik[ii][tinggibadan_cm]"><?php echo (!empty($modRiwayatPeriksaFisik->tinggibadan_cm) ? $modRiwayatPeriksaFisik->tinggibadan_cm : "") ?></span>
    </td>
    <td>
        <span name="riwayatPeriksaFisik[ii][tekanandarah]"><?php echo (!empty($modRiwayatPeriksaFisik->tekanandarah) ? $modRiwayatPeriksaFisik->tekanandarah : "") ?></span>
    </td>
	<td>
        <span name="riwayatPeriksaFisik[ii][detaknadi]"><?php echo (!empty($modRiwayatPeriksaFisik->detaknadi) ? $modRiwayatPeriksaFisik->detaknadi : "") ?></span>
    </td>
	<td>
        <span name="riwayatPeriksaFisik[ii][suhutubuh]"><?php echo (!empty($modRiwayatPeriksaFisik->suhutubuh) ? $modRiwayatPeriksaFisik->suhutubuh : "") ?></span>
    </td>
    <td>
        <span name="riwayatPeriksaFisik[ii][pernapasan]"><?php echo (!empty($modRiwayatPeriksaFisik->pernapasan) ? $modRiwayatPeriksaFisik->pernapasan : "") ?></span>
    </td>
	<td>
        <span name="riwayatPeriksaFisik[ii][gcs]"><?php echo (!empty($modRiwayatPeriksaFisik->gcs_eye) ? $modRiwayatPeriksaFisik->gcs_eye : "-").' / '.(!empty($modRiwayatPeriksaFisik->gcs_verbal) ? $modRiwayatPeriksaFisik->gcs_verbal : "-").' / '.(!empty($modRiwayatPeriksaFisik->gcs_motorik) ? $modRiwayatPeriksaFisik->gcs_motorik : "-") ?></span>
    </td>
    <td>
        <span name="riwayatPeriksaFisik[ii][kelainanpadabagtubuh]"><?php echo (!empty($modRiwayatPeriksaFisik->kelainanpadabagtubuh) ? $modRiwayatPeriksaFisik->kelainanpadabagtubuh : "") ?></span>
    </td>
	<td style="text-align: center;">
		<?php echo CHtml::link("<i class='icon-form-detail'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/PengkajianKebidanan/detailPeriksaFisik",array("pemeriksaanfisik_id"=>$modRiwayatPeriksaFisik->pemeriksaanfisik_id)),array("target"=>"frameDetailFisik","rel"=>"tooltip","title"=>"Klik untuk Detail Pemeriksaan Fisik", "onclick"=>"window.parent.$('#dialogDetailFisik').dialog('open')")); ?>
	</td>
</tr>