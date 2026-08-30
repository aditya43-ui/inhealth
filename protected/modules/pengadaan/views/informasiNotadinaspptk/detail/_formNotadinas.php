<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Nomor Transaksi", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'notadinaspptk_nomor', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nomor Nota Dinas", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nomor_notadinas', array('class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Nota Dinas <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'notadinaspptk_tanggal', array('class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Keperluan", 'ispph22', array('class' => 'control-label', 'style' => 'padding-top:3px !important')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'keperluan', array('class' => 'span3', 'row' => 3));?>
        </div>				
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Pejabat Pelaksana Teknis Kegiatan <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegpptk_id', array('class' => 'span3 pegpptk_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            echo $form->textField($model, 'pegpptk_nama', array('class' => 'span3 pegpptk_nama', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Pejabat Pembuat Komitmen <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pegppk_id', array('class' => 'span3 required', 'readonly' => true)); ?>
            <?php echo $form->textField($model, 'pegppk_nama', array('class' => 'span3 required', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penanggung Jawab Kegiatan <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegpjk_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            echo $form->textField($model, 'pegpjk_nama', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            ?>
        </div>
    </div>
    <div class="control-group" id="jabatan" style="display:none">
        <?php echo CHtml::label("Jabatan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pegpjk_jabatan', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group" id="unitkerja" style="display:none">
        <?php echo CHtml::label("Unit Kerja", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pegpjk_unitkerja', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
</div>