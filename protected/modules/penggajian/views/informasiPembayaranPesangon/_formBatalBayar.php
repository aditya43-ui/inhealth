<div>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'batalbayarpemb-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    ));
    $this->widget('bootstrap.widgets.BootAlert');
    echo $form->errorSummary(array($modBatalBayar)); ?>

    <fieldset>
        <!--legend class="rim">Pembatalan Pembayaran Gaji Pegawai</legend-->
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <br>
        <?php
        if ($sukses = 1) {
            Yii::app()->user->setFlash('success', "Pembatalan pembayaran pesangon pegawai berhasil disimpan!");
        } else {
            Yii::app()->user->setFlash('error', "Pembatalan pembayaran pesangon pegawai gagal disimpan!");
        } ?>
        <div class="control-group">
            <?php echo $form->labelEx($modBatalBayar, 'tglbatalkeluar', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modBatalBayar,
                    'attribute' => 'tglbatalkeluar',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'timeFormat' =>  Params::TIME_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => 'span3 dtPicker3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modBatalBayar, 'alasanbatalkeluar'); ?>

        <div class="form-actions">
            <?php
            if (!$modBatalBayar->isNewRecord) {
                echo CHtml::htmlButton(
                    $modBatalBayar->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('disabled' => true, 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            } else {
                echo CHtml::htmlButton(
                    $modBatalBayar->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('disabled' => false, 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            }
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('class' => 'btn btn-danger')
            );
            ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>
</div>