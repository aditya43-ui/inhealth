<div class="row-fluid formprogres" >
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi<span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modProgress, 'konsekuensi_skor', array('class' => 'span3', 'value' => !empty($model->konsekuensi_skor) ? $model->konsekuensi_skor : 0)); ?>
                <?php echo $form->hiddenField($modProgress, 'progressmonevindentifikasirisiko_id', array('class' => '', 'readonly' => true)); ?>
                <?php echo $form->dropDownList($modProgress, 'konsekuensi_id', RiskregisterM::getDropDownKonsekuensi(), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onchange' => 'loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang<span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modProgress, 'peluang_skor', array('class' => 'span3', 'value' => !empty($model->peluang_skor) ? $model->peluang_skor : 0)); ?>

                <?php echo $form->dropDownList($modProgress, 'peluang_id', RiskregisterM::getDropDownPeluang(), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onchange' => 'loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Detectability<span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modProgress, 'detectability_skor', array('class' => 'span3', 'value' => !empty($model->detectability_skor) ? $model->detectability_skor : 0)); ?>

                <?php echo $form->dropDownList($modProgress, 'detectability_id', RiskregisterM::getDropDownDetectability(), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onchange' => 'loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('RPN Sisa<span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($modProgress, 'rpn_sisa', array('class' => 'span3 required', 'readonly' => true)); ?>
            </div>
        </div>


    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Laporan Singkat<span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($modProgress, 'laporansingkat', array('class' => 'span3 required')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status<span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modProgress, 'status_riskregister', LookupM::getItems("status_riskregister"), array('class' => 'span3 required', 'empty' => '-- Pilih --')); ?>
            </div>
        </div> 
    </div>
</div>