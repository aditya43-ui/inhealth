<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo Chtml::label('Tanggal','', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modIntraAnastesi,
                    'attribute' => 'tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3	',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Jam Masuk OK','', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modIntraAnastesi,
                    'attribute' => 'jam_masuk_ok',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3	',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Jam AB Profilaksis','', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modIntraAnastesi,
                    'attribute' => 'jam_ab_profilakasis',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 	',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo Chtml::label('Jam Insisi','', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modIntraAnastesi,
                    'attribute' => 'jam_insisi',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3	',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
    </div>
</div>