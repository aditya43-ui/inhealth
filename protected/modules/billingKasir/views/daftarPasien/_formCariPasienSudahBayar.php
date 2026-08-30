<fieldset>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <?php echo  Yii::t('mds', 'Search Patient') ?>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <div class="control-group">
                            <?php $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'), 'medium', 'medium'); ?>
                            <?php echo CHtml::label('Tgl. Bukti Bayar', 'tgl_awal', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'), 'medium', 'medium'); ?>
                            <?php echo CHtml::label('Sampai Dengan', 'tgl_akhir', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //                                                    'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>

                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'nobuktibayar', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nama_bin', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</fieldset>