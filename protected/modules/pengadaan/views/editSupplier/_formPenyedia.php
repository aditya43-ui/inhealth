<div class="row-fluid">
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model,'supplier_nama',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_namalain',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->dropDownListRow($model,'supplier_jenis', LookupM::getItems('jenissupplier'),
                    array('class' => 'span4 required', 'onclick' => 'cekPBF(this);', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        <div class="pbf">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pbf_id', array('class'=>'control-label', 
                    'label'=>'Perusahaan Besar Farmasi')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'pbf_id',
                        CHtml::listData(PbfM::model()->findAll("pbf_aktif = TRUE ORDER BY pbf_nama ASC"), 'pbf_id', 'pbf_nama'),
                        array('readonly'=>false, 'style' => 'width: 240px', 'class'=>'span4 pbf_nama', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --',)); ?>
                </div>
            </div>   
        </div>  
        <?php echo $form->textAreaRow($model,'supplier_alamat',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->dropDownListRow($model,'supplier_propinsi', CHtml::listData($model->PropinsiItems, 'propinsi_nama', 'propinsi_nama'),array('empty'=>'-- Pilih --','class' => 'span4' ,'onkeypress'=>"return $(this).focusNextInputField(event)",'ajax'=>array('type'=>'POST','url'=>$this->createUrl('GetKabupatendrNamaPropinsi',array('encode'=>false,'namaModel'=>'SupplierM','attr'=>'supplier_propinsi')),'update'=>'#SupplierM_supplier_kabupaten'))); ?>
        <?php echo $form->dropDownListRow($model,'supplier_kabupaten',CHtml::listData($model->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'),array('class'=>'inputRequire', 'class' => 'span4' ,'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>  
        <?php echo $form->textFieldRow($model,'supplier_kodepos',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_npwp',array('readonly' => true, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>

    </div>
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model,'supplier_telp',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_fax',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_website',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_email',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_norekening',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'direktursupplier',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_cp',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_cp_jabatan',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
        <?php echo $form->textFieldRow($model,'supplier_cp_hp',array('readonly' => false, 'class'=>'span4 ', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
    
    </div>
</div>