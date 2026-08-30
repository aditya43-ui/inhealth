<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Pemeriksaan Sinar X', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'pemeriksaan_sinarx'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Elektrokardiogram', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'elektrokardiogram'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosis Sementara', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'diagnosis_sementara'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Definitif', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'definitif'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Treadmil', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'treadmill'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Hasil Laboratorium', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'hasil_laboratorium'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Terapi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'terapi'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>