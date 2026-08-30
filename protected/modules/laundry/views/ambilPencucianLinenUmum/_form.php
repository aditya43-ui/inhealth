<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'ambilpencucianlinenumum_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Pengambilan <span class=\"required\">*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpengambilan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span4 required'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nopengambilan', array('readonly' => true, 'class' => 'span4', 'placeholder' =>  '-- Otomatis --'));?>
        <?php echo $form->textFieldRow($model, 'namapengambil', array('readonly' => false, 'class' => 'span4', 'placeholder' =>  'Pengambil'));?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'berat', array('readonly' => true, 'class' => 'span4', 'placeholder' =>  ''));?>
        <?php echo $form->textFieldRow($model, 'harga', array('readonly' => true, 'class' => 'span4', 'placeholder' =>  ''));?>
    </div>
</div>