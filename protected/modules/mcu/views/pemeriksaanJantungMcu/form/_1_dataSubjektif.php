<?= $form->hiddenField($model,'checkup_jantung_id') ?>
<div class="col-sm-12">
    <div class="control-group" >
        <label class="control-label" style="width:100%;"><h3><u>DATA SUBJEKTIF (ANAMNESA)</u></h3></label>
    </div>
</div>

<div class="col-sm-12">
    <div class="control-group">
        <?= $form->labelEx($model,'perokokaktif',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->radioButtonList($model,'perokokaktif', LookupM::getItemsUrutan('perokokatkif')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'diabetes',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->radioButtonList($model,'diabetes', LookupM::getItemsUrutan('diabetes')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'lvh',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->radioButtonList($model,'lvh', LookupM::getItemsUrutan('lvh')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'riwayatkeluarga',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->radioButtonList($model,'riwayatkeluarga', [
                'Darah Tinggi' => 'Darah Tinggi',
                'Hipertensi' => 'Hipertensi',
                'Stroke' => 'Stroke',
                'Cancer' => 'Cancer',
                'Asma' => 'Asma',
                'Asam Urat' => 'Asam Urat',
            ]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'riwayatobat',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'riwayatobat', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'riwayatalergi',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'riwayatalergi', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'riwayatolahraga',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->radioButtonList($model,'riwayatolahraga', LookupM::getItemsUrutan('riwayatolahraga')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'riwayatdietgaram',['class'=>'control-label']) ?>
        <div class="controls">
            <?= $form->radioButtonList($model,'riwayatdietgaram', LookupM::getItemsUrutan('riwayatdietgaram')) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?= $form->labelEx($model,'keluhanjantung',['class'=>'control-label']) ?>
        <div class="controls" style="width:80%;">
            <?= $form->textArea($model,'keluhanjantung', ['rows'=>6,'style'=>'width:100%;']) ?>
        </div>
    </div>
</div>