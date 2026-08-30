<div class="control-group">
    <label class="controls"><b>Diagnosis</b></label>
</div>

<div class="col-sm-12">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diagnosisprimer', array('class' => 'control-label')) ?><br>
            <div class="controls">
                <?php echo $form->textArea($model, 'diagnosisprimer', array('rows' => 4, 'id' => 'diagnosisprimer')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diagnosissekunder', array('class' => 'control-label')) ?><br>
            <div class="controls">
                <?php echo $form->textArea($model, 'diagnosissekunder', array('rows' => 4, 'id' => 'diagnosissekunder')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'icd10', array('class' => 'control-label')) ?><br>
            <div class="controls">
                <?php echo $form->textArea($model, 'icd10', array('rows' => 4, 'id' => 'icd10')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'icd9', array('class' => 'control-label')) ?><br>
            <div class="controls">
                <?php echo $form->textArea($model, 'icd9', array('rows' => 4, 'id' => 'icd9')) ?>
            </div>
        </div>
    </div>
    <div class="control-group">
       <b> <?php echo $form->labelEx($model, 'tindakanyangdipilih', array('class' => 'control-label')) ?></b><br>
        <div class="controls" style="width:100%">
            <?php echo $form->textArea($model, 'tindakanyangdipilih', array('rows' => 4, 'id' => 'tindakanyangdipilih')) ?>
        </div>
    </div>
</div>