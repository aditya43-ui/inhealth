<tr class="backDefault">
    <td>
        <?php echo $form->checkBox($model,'[x]is_checked',array('checked'=>true, 'onclick'=>'checkRekening(this)', 'class'=>'ceklis')); ?>
    </td>
    <td>
		<span name="AKJurnalrekeningT[x][tglbuktijurnal]">2</span>/<br>
		<span name="AKJurnalrekeningT[x][nobuktijurnal]">2</span>
		<?php echo $form->hiddenField($model,'[x]jurnalrekening_id',array()); ?>
	</td>
    <td name="AKJurnalrekeningT[x][kodejurnal]">4</td>
	<td>
		<span name="AKJurnalrekeningT[x][tglreferensi]">2</span>/<br>
		<span name="AKJurnalrekeningT[x][noreferensi]">2</span>
	</td>
    <td name="AKJurnalrekeningT[x][kode_rekening]" class="kode5">5</td>
	<!--<td name="AKJurnalrekeningT[x][urianjurnal]">5</td>-->
    <td>
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => '[x]rekening_nama',
                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ){return false;}',
                    'select' => 'js:function( event, ui ) {
                        tambahDataRekening(ui.item.rincianobyek_id);
                        return false;
                    }'
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder'=>'Nama Jenis Pengeluaran',
                    'class'=>'span2 nama5',
                ),
                'tombolDialog' => array(
					'idDialog' =>'dialogRek',
					'jsFunction'=>'ubahRekening(this); return false;',
				),
            ));
        ?>
        <?php echo $form->hiddenField($model,'[x]jurnaldetail_id',array()); ?>
        <?php echo $form->hiddenField($model,'[x]rekening1_id',array('class'=>'rek1')); ?>
        <?php echo $form->hiddenField($model,'[x]rekening2_id',array('class'=>'rek2')); ?>
        <?php echo $form->hiddenField($model,'[x]rekening3_id',array('class'=>'rek3')); ?>
        <?php echo $form->hiddenField($model,'[x]rekening4_id',array('class'=>'rek4')); ?>
        <?php echo $form->hiddenField($model,'[x]rekening5_id',array('class'=>'rek5')); ?>
        <?php echo CHtml::hiddenField('[x]cekTd','', array('class'=>'cekTd')); ?>
    </td>
    <!--
    <td name="AKJurnalrekeningT[x][saldo_normal]">5</td>
    <td name="AKJurnalrekeningT[x][saldodebit]">5</td>
    <td name="AKJurnalrekeningT[x][saldokredit]">5</td>
-->
	 <td>
        <?php echo $form->textArea($model,'[x]urianjurnal',array('rows'=>3, 'class'=>'span2 uraian', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
    </td>
    <td><?php echo $form->textField($model,'[x]saldodebit',array('style'=>'width:100px;text-align:right;', 'class'=>'span2 integerFloat saldodebit','onblur'=>'cekTotalCeklis();')); ?></td>
    <td><?php echo $form->textField($model,'[x]saldokredit',array('style'=>'width:100px;text-align:right;', 'class'=>'span2 integerFloat saldokredit','onblur'=>'cekTotalCeklis();')); ?></td>

</tr>
