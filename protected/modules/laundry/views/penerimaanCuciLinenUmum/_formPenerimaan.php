<div class="row">
    <?php if (!empty($_GET['sukses'])) {?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tanggal Penerimaan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tglpenerimaan', array('class' => 'span4', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No Penerimaan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopenerimaan', array('class' => 'span4', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Pengiriman <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'namapengirim', array('class' => 'span4', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Berat <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'berat', array('class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Harga <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'harga', array('class' => 'span2', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keterangan', array('readonly' => true, 'disable' => true, 'rows' => 6, 'cols' => 100, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    <?php
    } else {
    ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tanggal Penerimaan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        $model->tglpenerimaan = !empty($model->tglpenerimaan) ? $format->formatDateTimeForUser($model->tglpenerimaan) : date('d M Y');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpenerimaan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3 required', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                    ?>
                    <?php echo $form->error($model, 'tglpenerimaan'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No Penerimaan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopenerimaan', array('class' => 'span4 required', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Pengiriman <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'namapengirim', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => false, 'placeholder'=> 'Nama Mengajukan')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Berat <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'hargacuci', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->textField($model, 'berat', array('class' => 'span2 float2 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => false, 'onblur' => 'hitungHarga(this);', 'placeholder'=> 'Berat')); ?><label>Kg</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Harga <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'harga', array('class' => 'span2 float2 required', 'readonly' => true, 'placeholder'=> 'Harga')); ?><label>Rupiah</label>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keterangan', array('readonly' => false, 'disable' => false, 'rows' => 6, 'cols' => 100, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder'=> 'Keterangan')); ?>
                </div>
            </div>
        </div>
</div>

<?php
    }
?>