<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Nomor Kuitansi <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nomor_kuitansi', array('class' => 'span3 span3 denganpph22')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Pembayaran <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tanggal_pembayaran',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('class' => 'dtPicker3 span3 denganpph22', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Telah diterima dari <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'telahditerima_dari', array('class' => 'span3 span3 denganpph22', 'rows'=>3)); ?>
        </div>
    </div>
</div>
