<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<fieldset class="" id="frmSearchJurnalRek">
    <?php
    $form = $this->beginWidget(
        'ext.bootstrap.widgets.BootActiveForm',
        array(
            'id' => 'form-search-jurnal-rek',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)'
            ),
            'focus' => '#',
        )
    );
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label" for="AKJurnalrekeningT_tgl_akhir">Tanggal Bukti Jurnal</label>
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
                            'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="AKJurnalrekeningT_tgl_akhir">Sampai Dengan</label>
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
                            'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'nobuktijurnal', array('placeholder' => 'No. Bukti Jurnal', 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
            <?php echo $form->textFieldRow($model, 'kodejurnal', array('placeholder' => 'Kode Jurnal', 'class' => 'span4 required numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>

            <?php
            if (isset($this->allow_jenisjurnal)) {
                echo $form->dropDownListRow(
                    $model,
                    'jenisjurnal_id',
                    JenisjurnalM::itemsWithInit(Params::notJnsJurnalPostUmum()),
                    array(
                        'empty' => '-- Pilih --',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4'
                    )
                );
            }
            ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('id' => 'btn_submit', 'title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
