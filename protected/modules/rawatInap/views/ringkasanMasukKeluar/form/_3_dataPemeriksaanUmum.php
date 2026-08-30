<div class="col-sm-12">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pemeriksaan_fisik', array('class' => 'control-label')) ?><br>
        <div class="controls" style="width: 100%;">
            <?php echo $form->textArea($model, 'pemeriksaan_fisik', array('rows' => 4, 'id' => 'pemeriksaanfisik')) ?>
        </div>
    </div>
</div>
<br>
<div class="col-sm-6">
    <?= $form->textAreaRow($model, 'keadaanumum', ['rows' => 4]) ?>
    <?= $form->textAreaRow($model, 'tandavital', ['rows' => 4]) ?>

    <div class="control-group">
        <label class="control-label">Tekanan darah</label>
        <div class="controls">
            <?= $form->textField($model, 'td_systolic', ['class' => 'numbers-only span2']) ?> /
        </div>
        <div class="controls">
            <?= $form->textField($model, 'td_diastolic', ['class' => 'numbers-only span2']) ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <?= $form->textFieldRow($model, 'suhu', ['class' => 'angkacoma-only']) ?>
    <?= $form->textFieldRow($model, 'nadi', ['class' => 'numbers-only']) ?>
    <?= $form->textFieldRow($model, 'frekuensipernapasan', ['class' => 'numbers-only']) ?>
</div>

<div class="clear"></div>