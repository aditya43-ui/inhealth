<div class="control-group">
<?php echo CHtml::label("Anamnesa dari", ' ', array('class'=>'control-label')); ?>
    <div class="controls inlinebar-3" id="anamnesadari">
        <?php echo CHtml::activeRadioButtonList($model, 'anamnesadari_pasien', array('Pasien' => 'Pasien', 'Keluarga' => 'Keluarga', 'Lainnya' => 'Lainnya'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setAnamnesa();')); ?>       
        <?php echo $form->textField($model, 'anamnesadari_lainnya_keterangan', array('class' => 'span3', 'placeholder' => 'Lainnya', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Riwayat Anestesi", ' ', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::activeRadioButtonList($model, 'riwayatanestesi_ada', array('Tidak Ada' => 'Tidak Ada', 'Ada' => 'Ada'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setRiwayat();')); ?>       
        <?php echo $form->textField($model, 'riwayatanestesi_keterangan', array('class' => 'span3', 'placeholder' => 'Sebutkan Jika Ada', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Komplikasi", ' ', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::activeRadioButtonList($model, 'komplikasi_ada', array('Tidak Ada' => 'Tidak Ada', 'Ada' => 'Ada'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setKomplikasi();')); ?>       
        <?php echo $form->textField($model, 'komplikasi_keterangan', array('class' => 'span3', 'placeholder' => 'Sebutkan Jika Ada', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Obat-obatan yang Dikonsumsi", 'obatyangdikonsumsi', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->textField($model, 'obatyangdikonsumsi', array('class' => 'span3', 'placeholder' => 'Sebutkan Jika Ada', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Riwayat Alergi", ' ', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::activeRadioButtonList($model, 'riwayatalergi_ada', array('Tidak Ada' => 'Tidak Ada', 'Ada' => 'Ada'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setAlergi();')); ?>       
        <?php echo $form->textField($model, 'riwayatalergi_keterangan', array('class' => 'span3', 'placeholder' => 'Sebutkan Jika Ada', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
