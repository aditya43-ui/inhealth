<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('<b><u>Diagnosik Fisik</u></b>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('N', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'nadi', array('class' => 'span3 numbers-only')); ?>
                      </label>/menit</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('T', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'tekanandarah'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('UVP', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'uvp', array('class' => 'span3 numbers-only')); ?>
                      </label>cm</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('<b><u>Thorax</u></b>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jantung-Inspeksi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'thorax_jantung_inspeksi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Palpasi-Apex', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'thorax_palpasi_apex'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pulsasi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'thorax_pulsasi', array()); ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Lift', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'thorax_lift', array('class' => 'span3')); ?>
                      </label>sternal</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Thrill', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'thorax_thrill', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Perkusi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'thorax_purkusi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Auskultasi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'thorax_auskultasi'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Paru', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'thorax_paru'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label(' ', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kesan Umum', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'kesan_umum'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('<b><u>Leher</u></b>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kelenjar Gondok', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'leher_kelenjar_gondok'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pulsasi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'leher_pulsasi', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Vera Melebar', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modPemeriksaanjantung, 'leher_vera_melebar'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Carotid Shudder', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'leher_carotid_shudder', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('<b><u>Abdomen</u></b>', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Hati', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'abdomen_hati', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Limpa', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'abdomen_limpa', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ascites', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'abdomen_ascites', array()); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Extrmitas', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanjantung, 'extremitas', array()); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>