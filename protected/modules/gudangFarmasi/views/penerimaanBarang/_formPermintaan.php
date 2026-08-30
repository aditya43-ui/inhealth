<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Permintaan Pembelian</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class = "col-sm-6">
                <?php echo $form->textFieldRow($modPermintaanPembelian,'nopermintaan', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
                <?php echo $form->textFieldRow($modPermintaanPembelian,'tglpermintaanpembelian', array('class'=>'span3 ','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Jenis PPh','', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPermintaanPembelian,'pajak_nama', array('readonly'=>true, 'class'=>'span3 ')); ?>
                    </div>
                </div>	
            </div>
            <div class = "col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($modPermintaanPembelian,'sumberdana_id', array('class'=>'control-label','label'=>'Sumber Dana')) ?>
                    <div class="controls">
                    <?php echo $form->hiddenField($modPenerimaanBarang, 'sumberdana_id',array('readonly'=>true)); ?>
                        <?php echo $form->textField($modPermintaanPembelian,'sumberdana_nama', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPenerimaanBarang,'supplier_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modPenerimaanBarang, 'supplier_id',array('readonly'=>true)); ?>
                        <?php echo $form->textField($modPenerimaanBarang,'supplier_nama', array('readonly'=>true)); ?>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div> 