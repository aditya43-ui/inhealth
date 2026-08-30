<div class="row" style="margin-top: 20px;">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo $form->labelEx($modTerdugaTb, 'tglterdugatb', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modTerdugaTb,
                    'attribute' => 'tglterdugatb',
                    'value' => null,
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4',
                    ),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modTerdugaTb, 'lokasianatomipenyakit',  LookupM::getItems('lokasianatomipenyakittb'), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
        <?php echo $form->textFieldRow($modTerdugaTb, 'totalskorintbanak', array('class' => 'span4 numbers-only', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modTerdugaTb, 'hasilfototorax', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->radioButtonList($modTerdugaTb, 'hasilfototorax', array('Positif' => 'Positif', 'Negatif' => 'Negatif', 'Tidak Diketahui' => 'Tidak Diketahui')); ?>
                    </div>
                </div>
                <?php echo $form->error($modTerdugaTb, 'hasilfototorax'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo $form->labelEx($modTerdugaTb, 'statushiv', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->radioButtonList($modTerdugaTb, 'statushiv', array('Positif' => 'Positif', 'Negatif' => 'Negatif', 'Tidak Diketahui' => 'Tidak Diketahui')); ?>
                    </div>
                </div>
                <?php echo $form->error($modTerdugaTb, 'statushiv'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modTerdugaTb, 'riwayatpenyaktterdahulu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modTerdugaTb, 'riwayatpenyaktterdahulu', array('class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modTerdugaTb, 'jenis_pemeriksaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="radio inline">
                    <div class="form-inline">
                        <?php echo $form->radioButtonList($modTerdugaTb,'jenis_pemeriksaan',LookupM::getItems('pemeriksaantb'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
                    </div>    
                </div>
                <?php echo $form->error($modTerdugaTb, 'jenis_pemeriksaan'); ?>
            </div>
        </div>
    </div>
</div>