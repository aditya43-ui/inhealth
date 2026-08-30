<?php foreach ($detail as $closingkasir_id => $item): ?>
<?php /*
<tr>
	<td colspan="3" style="font-weight: bold;"><?php echo $head['no']; ?></td>
</tr>
 * 
 */ ?>

	<?php // foreach ($head['det'] as $kelompok_id => $item): ?>

<tr>
    <td>
        <?php
        $item->nilaiclosingtrans -= $item->jumlahnontunai;
        echo CHtml::hiddenField('detail['.$closingkasir_id.'][jmlsetoranbdhara]', $item->nilaiclosingtrans);
		echo CHtml::hiddenField('detail['.$closingkasir_id.'][rekening5_id]', null, array(
			'class' => 'rekening5_id',
		));
        echo CHtml::textField('detail['.$closingkasir_id.'][nmrekaning5]', null, array(
			'class' => 'rekening5_nama',
            'readonly' => true,
		));
        /*
        $this->widget('MyJuiAutoComplete', array(
                    'name'=>'detail['.$closingkasir_id.'][nmrekaning5]',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiSetoran') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
						'class' => 'rekening5_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
						'readonly' => true,
                    ),
                    'tombolDialog' => array(
						'idDialog' => 'dialogRekening',
						'jsFunction' => ''
						. '$("#dialogRekening").dialog("open"); '
						. 'objdetid = $(this).parents("td").find(".rekening5_id");'
						. 'objdetnama = $(this).parents("td").find(".rekening5_nama");'),
					
                ));
         * 
         */
		?>
        
    </td>
    <td><?php 
    $link = "<u>".CHtml::link($item->closingkasir_no, Yii::app()->createUrl('/billingKasir/closingKasir/Rincian', array(
        'idClosing'=>$item->closingkasir_id,
    )), array(
        "target"=>"iframeRincianClosing",
        "onclick"=>"$(\"#dialogRincianClosing\").dialog(\"open\");",
    ))."</u>";
    
    echo "Closing Kasir ".$link." - ".MyFormatter::formatDateTimeForUser($item->tglclosingkasir); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->nilaiclosingtrans); ?></td>
    <?php /*
	<td>
		<?php
		echo CHtml::hiddenField('detail['.$setoran_id.']['.$kelompok_id.'][jmlsetoranbdhara]', $item['total']);
		echo CHtml::hiddenField('detail['.$setoran_id.']['.$kelompok_id.'][rekening5_id]', null, array(
			'class' => 'rekening5_id',
		));
		$this->widget('MyJuiAutoComplete', array(
                    'name'=>'detail['.$setoran_id.']['.$kelompok_id.'][nmrekaning5]',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiSetoran') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
						'class' => 'rekening5_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
						'readonly' => true,
                    ),
                    'tombolDialog' => array(
						'idDialog' => 'dialogRekening',
						'jsFunction' => ''
						. '$("#dialogRekening").dialog("open"); '
						. 'objdetid = $(this).parents("td").find(".rekening5_id");'
						. 'objdetnama = $(this).parents("td").find(".rekening5_nama");'),
					
                ));
		?>
	</td>
	<td><?php echo $item['nama']; ?></td>
	<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item['total']); ?></td>
     * 
     */ ?>
</tr>

	<?php // endforeach; ?>

<?php endforeach; ?>
