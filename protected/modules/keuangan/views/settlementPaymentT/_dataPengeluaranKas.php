<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group ">
            <?php $modTandaBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
            <?php echo $form->labelEx($modTandaBuktiKeluar,'tglkaskeluar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',
                        array(
                                'model'=>$modTandaBuktiKeluar,
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
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'nokaskeluar',array('readonly'=>true)) ?>
        <?php echo $form->textAreaRow($model,'catatanpembayaran') ?>
        <?php echo $form->textFieldRow($model,'jmlpembayaran',array('class'=>'integer-decimal','onblur'=>'calculate()')) ?>
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'biayaadministrasi',array('class'=>'integer-decimal','onblur'=>'calculate()')) ?>
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'jmlkaskeluar',array('readonly'=>true,'class'=>'integer-decimal')) ?>
    </div>
    <div class="col-md-6">
        <?php echo $form->dropDownListRow($modTandaBuktiKeluar,'carabayarkeluar',LookupM::getItems('carabayarkeluar'),array('empty' => 'Pilih', 'onchange'=>'setCaraBayar(this)')) ?>
        <div id="transfer">
            <!-- only non tunai -->
            <div class="control-group">
                <?php echo Chtml::label("Nama Bank Pengirim <span class='required'>*</span>", 'bank_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modTandaBuktiKeluar,'bank_id',CHtml::listData(BankM::model()->findAllByAttributes(array('ispengeluaran' => true)),'bank_id','namabank'),array('empty' => 'Pilih','onchange'=>'setNoRek(this)')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("No. Rekening Pengirim <span class='required'>*</span>", 'denganrekening', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTandaBuktiKeluar,'denganrekening',array('readonly'=>true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("Nama Bank Penerima <span class='required'>*</span>", 'bank_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($modTandaBuktiKeluar,'melalubank',LookupM::getItems('bank'),array('empty' => 'Pilih')) ?>
                </div>
            </div>
           
            <div class="control-group">
                    <?php
                    ?>
                <?php echo Chtml::label("No.Rekening Penerima", 'norekpenerima', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTandaBuktiKeluar,'norekpenerima',array()) ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modTandaBuktiKeluar,'nobukti_transfer') ?>
            <?php //echo $form->textFieldRow($modTandaBuktiKeluar,'denganrekening') ?>
          
        </div>
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'namapenerima') ?>
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'untukpembayaran') ?>
    </div>
</div>



<script type="text/javascript">
function setNoRek(obj){
    var data = $("#KUTandabuktikeluarT_bank_id :selected").data('norek');
    $("#KUTandabuktikeluarT_denganrekening").val(data);
}


</script>