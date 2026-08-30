<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Anamnesis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'anamnesis'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Palpitasi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'palpitasi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Dyopneu', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'dyapneu'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Himoptysis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'hemoptysis'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pusing', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'pusing'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kelainan Pencernaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'kelainan_pencernaan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Rheumatic Fever', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'rheumatic_fever'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Syphilis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'syphilis'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Diphtheria', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'diphtheria'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Keluhan Utama', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'keluhan_utama'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nyeri', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'nyeri'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Batuk', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'batuk'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Edoma', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'edoma'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pingsan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'pingsan'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tonsilitis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'tonsilitas'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nephritis', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'nephritis'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Influenza', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'influenza'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Lain-lain', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'lain_lain'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>