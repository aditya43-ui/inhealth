<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Kontrak Pegawai
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo $form->labelEx($modKontrak, 'nosuratkontrak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKontrak, 'nosuratkontrak', array('placeholder' => 'No. Surat Kontrak', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modKontrak, 'tglkontrak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modKontrak->tglkontrak = (!empty($modKontrak->tglkontrak) ? date("d/m/Y", strtotime($modKontrak->tglkontrak)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKontrak,
                    'attribute' => 'tglkontrak',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modKontrak, 'tglmulaikontrak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modKontrak->tglmulaikontrak = (!empty($modKontrak->tglmulaikontrak) ? date("d/m/Y", strtotime($modKontrak->tglmulaikontrak)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKontrak,
                    'attribute' => 'tglmulaikontrak',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                        'onkeypress' => "js:function(){lamaKontrak(this);}",
                        'onSelect' => 'js:function(){lamaKontrak(this);}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Sampai</label>
            <div class="controls">
                <?php
                $modKontrak->tglakhirkontrak = (!empty($modKontrak->tglakhirkontrak) ? date("d/m/Y", strtotime($modKontrak->tglakhirkontrak)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modKontrak,
                    'attribute' => 'tglakhirkontrak',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'minDate' => 'd',
                        'yearRange' => "-150:+0",
                        'onkeypress' => "js:function(){lamaKontrak(this);}",
                        'onSelect' => 'js:function(){lamaKontrak(this);}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modKontrak, 'lamakontrak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modKontrak, 'lamakontrak', array('placeholder' => 'Lama Kontrak', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modKontrak, 'keterangankontrak', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modKontrak, 'keterangankontrak', array('placeholder' => 'Keterangan Kontrak', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>