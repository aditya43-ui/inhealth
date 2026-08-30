<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'assep-t-search',
    'type' => 'horizontal',
)); ?>

<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal SEP', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglsep',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'nosep', array('class' => 'span3', 'maxlength' => 100)); ?>

        <?php echo $form->textFieldRow($model, 'nokartuasuransi', array('class' => 'span3', 'maxlength' => 50)); ?>

        <div class="control-group">
            <?php echo CHtml::label('Tanggal Rujukan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglrujukan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'norujukan', array('class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'ppkrujukan', array('class' => 'span3', 'maxlength' => 50)); ?>

        <?php echo $form->textFieldRow($model, 'ppkpelayanan', array('class' => 'span3', 'maxlength' => 50)); ?>

        <?php echo $form->textFieldRow($model, 'jnspelayanan', array('class' => 'span3 numbers-only')); ?>

        <?php echo $form->textFieldRow($model, 'politujuan', array('class' => 'span3', 'maxlength' => 100)); ?>

        <?php echo $form->textFieldRow($model, 'klsrawat', array('class' => 'span3 numbers-only')); ?>
    </div>
    <div class="span4">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Pulang', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpulang',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>

        <?php echo $form->textAreaRow($model, 'catatansep', array('rows' => 2, 'cols' => 50, 'class' => 'span3')); ?>

        <?php echo $form->textAreaRow($model, 'diagnosaawal', array('rows' => 2, 'cols' => 50, 'class' => 'span3')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
</div>

<?php $this->endWidget(); ?>