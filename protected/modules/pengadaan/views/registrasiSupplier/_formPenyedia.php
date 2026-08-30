<div class="row-fluid">
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model,'supplier_nama',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_namalain',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_jenis',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <div class="pbf">
            <?php echo $form->textFieldRow($model,'pbf_nama',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?> 
        </div>
        <?php echo $form->textAreaRow($model,'supplier_alamat',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_propinsi',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_kabupaten',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_kodepos',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>

    </div>
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model,'supplier_telp',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_fax',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_website',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_email',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_norekening',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'direktursupplier',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_cp',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_cp_jabatan',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_cp_hp',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
    
    </div>
</div>