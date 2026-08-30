<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label" style="width:100%;"><h3><u>DATA OBJEKTIF (PEMERIKSAAN FISIK)</u></h3></label>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="control-group">
        <?= $form->labelEx($model,'tensi',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->textField($model,'tensi', ['class'=>'span2']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'nadi',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->textField($model,'nadi', ['class'=>'span2 numbers-only']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'tinggibadan',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->textField($model,'tinggibadan', ['class'=>'span2 numbers-only']) ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?= $form->labelEx($model,'suhu',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->textField($model,'suhu', ['class'=>'span2 angkacoma-only']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'beratbadan',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->textField($model,'beratbadan', ['class'=>'span2 numbers-only']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'pernafasan',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->textField($model,'pernafasan', ['class'=>'span2 numbers-only']) ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    
    <div class="control-group">
        <?= $form->labelEx($model,'bentukdada',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'bentukdada', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'batasjantung',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'batasjantung', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'bunyijantung',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'bunyijantung', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
        
</div>