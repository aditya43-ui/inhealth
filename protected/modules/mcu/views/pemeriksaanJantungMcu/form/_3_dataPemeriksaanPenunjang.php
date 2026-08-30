<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label" style="width:100%;"><h3><u>PEMERIKSAAN PENUNJANG</u></h3></label>
    </div>
</div>

<div class="col-sm-12">
    
    <div class="control-group">
        <?= $form->labelEx($model,'rothorax',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'rothorax', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'laboratorium',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'laboratorium', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'ekg',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'ekg', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'treadmill',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'treadmill', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'echo',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'echo', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
        
</div>