<tr>
    <td>
        <?php echo $form->checkBox($model,'[x]is_checked',array('checked'=>true, 'onclick'=>'checkRekening(this)', 'class'=>'ceklis')); ?>
    </td>
    <td name="AKJurnalrekeningT[x][tglbuktijurnal]">2</td>
    <td>
        <span name="AKJurnalrekeningT[x][nobuktijurnal]">2</span>
        <?php echo $form->hiddenField($model,'[x]jurnalrekening_id',array()); ?>
    </td>
    <td name="AKJurnalrekeningT[x][kodejurnal]">4</td>
    <td name="AKJurnalrekeningT[x][urianjurnal]">5</td>
    <td name="AKJurnalrekeningT[x][kode_rekening]" class="kode5">5</td>
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
    </td>
    <!--
    <td name="AKJurnalrekeningT[x][saldo_normal]">5</td>
    <td name="AKJurnalrekeningT[x][saldodebit]">5</td>
    <td name="AKJurnalrekeningT[x][saldokredit]">5</td>
-->
    <td><?php echo $form->textField($model,'[x]saldodebit',array('style'=>'width:100px', 'class'=>'span2 integer2 saldodebit')); ?></td>
    <td><?php echo $form->textField($model,'[x]saldokredit',array('style'=>'width:100px', 'class'=>'span2 integer2 saldokredit')); ?></td>
    <td>
        <?php echo $form->textArea($model,'[x]urianjurnal',array('rows'=>3, 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
    </td>
</tr>
