<div class="row-fluid lookdisable">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi <span class="required">*</span>', 'konsekuensi_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'konsekuensi_skor',array('class'=>'span3','value'=>!empty($model->konsekuensi_skor)? $model->konsekuensi_skor : 0)); ?>
                <?php echo $form->dropDownList($model,'konsekuensi_id', RiskregisterM::getDropDownKonsekuensi(), array('class'=>'span3 required','empty'=>'-- Pilih --','onchange'=>'loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang <span class="required">*</span>', 'peluang_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'peluang_skor',array('class'=>'span3','value'=>!empty($model->peluang_skor)? $model->peluang_skor : 0)); ?>
                <?php echo $form->dropDownList($model,'peluang_id', RiskregisterM::getDropDownPeluang(), array('class'=>'span3 required','empty'=>'-- Pilih --','onchange'=>'loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Skor <span class="required">*</span>', 'skor_cl', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'skor_cl',array('readonly'=>true,'class'=>'span3 required'
                    //,'value'=>!empty($model->peluang_skor)? $model->peluang_skor : 0
                ));?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Detectability / Controlability <span class="required">*</span>', 'detectability_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'detectability_skor',array('class'=>'span3','value'=>!empty($model->detectability_skor)? $model->detectability_skor : 0)); ?>
                <?php echo $form->dropDownList($model,'detectability_id', RiskregisterM::getDropDownDetectability(), array('class'=>'span3 required','empty'=>'-- Pilih --','onchange'=>'loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('RPN (Risk Priority Number) <span class="required">*</span>', 'rpn_score', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'rpn_score',array('class'=>'span3 required','readonly'=>true)); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Target RPN (Risk Priority Number)', 'target_rpn', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'target_rpn',array('class'=>'span3 numbers-only')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Resiko <span class="required">*</span>', 'tingkatrisiko_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'tingkatrisiko_id',array('class'=>'span3')); ?>
                <?php echo $form->textField($model,'tingkatrisiko_nama',array('readonly'=>true, 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>