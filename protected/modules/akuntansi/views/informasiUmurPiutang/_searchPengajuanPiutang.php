<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Invoice', 'rekonsiliasibank_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo Chtml::hiddenField("filterTanggal", 'tanggal');
                $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 span2', 'onclick' => "return $(this).focusNextInputField(event)", 'style' => 'width:200px;'),
                ));
                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 span2', 'onclick' => "return $(this).focusNextInputField(event)", 'style' => 'width:200px;'),
                ));
                $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No Invoice", 'nopembayaran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopembayaran', array('placeholder' => 'No. Invoice', 'class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pasien', array('class' => 'hurufs-only span3', 'placeholder' => 'Nama Pasien')); ?>
            </div>
        </div>
    </div>
</div>