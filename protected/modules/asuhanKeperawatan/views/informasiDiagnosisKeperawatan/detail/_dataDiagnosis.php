<div class="">
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'no_diagnosisaskep', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_diagnosisaskep', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'diagnosisaskep_tgl', array('class' => 'control-label inline', 'label' => 'Tanggal Diagnosis')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'diagnosisaskep_tgl', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('required' => true, 'readonly' => true, 'class' => 'span3')); ?>
                    <?php echo $form->textField($model, 'nama_pegawai', array('required' => true, 'readonly' => true, 'class' => 'span3')); ?>
                </div>
            </div>
        </div>
    </div>
</div>