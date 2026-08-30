<tr>
    <td>
        <?php echo $form->checkBox($model,'[x]is_checked',array('checked'=>true, 'onclick'=>'checkRekening(this)')); ?>
    </td>
    <td name="AKJurnalrekeningT[x][tglbuktijurnal]">2</td>
    <td>
        <span name="AKJurnalrekeningT[x][nobuktijurnal]">2</span>
        <?php echo $form->hiddenField($model,'[x]jurnalrekening_id',array()); ?>
    </td>
    <td name="AKJurnalrekeningT[x][kodejurnal]">4</td>
    <td name="AKJurnalrekeningT[x][urianjurnal]">5</td>
    <td name="AKJurnalrekeningT[x][kode_rekening]">5</td>
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
                    'class'=>'span2',
                ),
                'tombolDialog' => false,
            ));
        ?>
        <?php echo $form->hiddenField($model,'[x]jurnaldetail_id',array()); ?>
        <?php echo $form->hiddenField($model,'[x]rekening1_id',array()); ?>
        <?php echo $form->hiddenField($model,'[x]rekening2_id',array()); ?>
        <?php echo $form->hiddenField($model,'[x]rekening3_id',array()); ?>
        <?php echo $form->hiddenField($model,'[x]rekening4_id',array()); ?>
        <?php echo $form->hiddenField($model,'[x]rekening5_id',array()); ?>
    </td>
    <!--
    <td name="AKJurnalrekeningT[x][saldo_normal]">5</td>
    <td name="AKJurnalrekeningT[x][saldodebit]">5</td>
    <td name="AKJurnalrekeningT[x][saldokredit]">5</td>
-->
    <td><?php echo $form->textField($model,'[x]saldodebit',array('style'=>'width:65px', 'class'=>'span2')); ?></td>
    <td><?php echo $form->textField($model,'[x]saldokredit',array('style'=>'width:65px', 'class'=>'span2')); ?></td>
    <td>
        <?php echo $form->textArea($model,'[x]urianjurnal',array('rows'=>1, 'style'=>'height:17px','class'=>'span2', 'onkeypress'=>"return nextFocus(this,event,'','')", 'maxlength'=>32,'readonly'=>false)); ?>
    </td>
</tr>