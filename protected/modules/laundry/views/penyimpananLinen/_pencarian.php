<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modInfoPencucian, 'nopencucianlinen'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($modInfoPencucian, 'Tanggal Penerimaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modInfoPencucian, 'tgl_awal', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modInfoPencucian, 'tgl_akhir', array('class' => 'span3')); ?>
                    <?php                    
//                    $this->widget('MyDateTimePicker', array(
//                        'model' => $modInfoPencucian,
//                        'attribute' => 'tgl_awal',
//                        'mode' => 'date',
//                        'options' => array(
//                            'showOn' => false,
//                            //                                'maxDate' => 'd',
//                            'yearRange' => "-150:+0",
//                        ),
//                        'htmlOptions' => array('placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
//                        ),
//                    ));
                    ?>
                </div>
            </div>
            <!--<div class="control-group">-->
                    <?php // echo $form->labelEx($modInfoPencucian, 'Sampai Dengan', array('class' => 'control-label')) ?>
                <!--<div class="controls">-->
                    <?php                    
//                    $this->widget('MyDateTimePicker', array(
//                        'model' => $modInfoPencucian,
//                        'attribute' => 'tgl_akhir',
//                        'mode' => 'date',
//                        'options' => array(
//                            'showOn' => false,
//                            //                                'maxDate' => 'd',
//                            'yearRange' => "-150:+0",
//                        ),
//                        'htmlOptions' => array('placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
//                        ),
//                    ));
                    ?>
                <!--</div>-->
            <!--</div>-->
            <div class="control-group">
                    <?php echo CHtml::label('No. Pencucian/ Perawatan', '', array('class' => 'control-label')); ?>
                <div class="controls">
<?php echo $form->textField($modInfoPencucian, 'no_linen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modInfoPencucian, 'instalasi_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modInfoPencucian, 'instalasi_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php
//                    echo $form->dropDownList($modInfoPencucian, 'instalasi_id', $instalasiTujuans, array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
//                        'ajax' => array('type' => 'POST',
//                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modInfoPencucian))),
//                            'update' => "#" . CHtml::activeId($modInfoPencucian, 'ruangan_id'),
//                    )));
                    ?>
                </div>
            </div>
            <div class="control-group">
<?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modInfoPencucian, 'ruangan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modInfoPencucian, 'ruangan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
<?php // echo $form->dropDownList($modInfoPencucian, 'ruangan_id', $ruanganTujuans, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
    </div>

        <div class="form-actions">
            <?php // echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
            <?php
//            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
//                'onclick' => 'return refreshForm(this);'));
            ?>
        </div>
<?php $this->endWidget(); ?>
    </div>