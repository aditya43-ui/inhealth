<div class="control-group ">
    <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
    <?php echo $form->labelEx($modBuktiKeluar,'tglkaskeluar', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
            $this->widget('MyDateTimePicker',
                array(
                        'model'=>$modBuktiKeluar,
                        'attribute'=>'tglkaskeluar',
                        'mode'=>'datetime',
                        'options'=>array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'dtPicker2-5 realtime',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'onchange' => '$(this).removeClass("realtime")'
                        ),
                )
            ); 
        ?>

    </div>
</div>
<?php echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',array('readonly' => true));?>
<div class="control-group">
    <label class="control-label">Cara Pembayaran</label>
    <div class="controls">
            <?php echo  $form->dropDownList($modBuktiKeluar,'carabayarkeluar',LookupM::getItems('carabayarkeluar'),array('empty' => 'Pilih', 'onchange'=>'setCaraBayarKeluar(this)'))?>
    </div>
</div>  

<div id="transferkeluar">
                <!-- only non tunai -->
    <div class="control-group">
        <?php echo Chtml::label("Nama Bank Pengirim <span class='required'>*</span>", 'bank_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modBuktiKeluar,'bank_id',CHtml::listData(BankM::model()->findAllByAttributes(array('ispengeluaran' => true)),'bank_id','namabank'),array('empty' => 'Pilih','onchange'=>'setNoRekKeluar(this)')) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Chtml::label("No. Rekening Pengirim <span class='required'>*</span>", 'denganrekening', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modBuktiKeluar,'denganrekening',array('readonly'=>true)) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Chtml::label("Nama Bank Penerima <span class='required'>*</span>", 'bank_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($modBuktiKeluar,'melalubank',LookupM::getItems('bank'),array('empty' => 'Pilih')) ?>
        </div>
    </div>

    <div class="control-group">
            <?php
            ?>
        <?php echo Chtml::label("No.Rekening Penerima", 'norekpenerima', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modBuktiKeluar,'norekpenerima',array()) ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modBuktiKeluar,'nobukti_transfer') ?>

</div>   