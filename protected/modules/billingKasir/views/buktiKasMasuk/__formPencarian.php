<fieldset>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Pencarian
            </div>
        </div>
        <div class="panel-body">
            <?php
            $form = $this->beginWidget(
                'ext.bootstrap.widgets.BootActiveForm',
                array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#',
                    'method' => 'GET',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                )
            );
            ?>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <div class="control-group">

                            <?php echo CHtml::label('Tgl. Pembayaran', 'tglPendaftaran', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
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
                            <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
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
                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model, 'nobuktibayar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($model, 'carapembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </td>
                </tr>
            </table>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $action_url,
                    array(
                        'class' => 'btn btn-danger'
                    )
                );
                ?>
            </div>
            <?php
            $this->endWidget();
            ?>
        </div>
    </div>
</fieldset>