<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarian-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modPenerimaanLinenDetail, 'nopenerimaanlinen'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Penerimaan', 'Tanggal Awal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPenerimaanLinen, 'tglpenerimaanlinen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                    <?php  
//                    $this->widget('MyDateTimePicker', array(
//                        'model' => $modPenerimaanLinenDetail,
//                        'attribute' => 'tgl_awal',
//                        'mode' => 'date',
//                        'options' => array(
//                            'showOn' => false,
//                            //                                'maxDate' => 'd',
//                            'yearRange' => "-150:+0",
//                        ),
//                        'htmlOptions' => array('readonly' => true,'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
//                        ),
//                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('No. Penerimaan', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPenerimaanLinen, 'nopenerimaanlinen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                    <?php echo $form->hiddenField($modPenerimaanLinenDetail, 'nopenerimaanlinen', array('class' => 'span3')); ?>
                    <?php // echo $form->textField($modPenerimaanLinenDetail, 'nopenerimaanlinen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => false)); ?>
                </div> 
            </div>
            
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                    <?php echo $form->labelEx($modPenerimaanLinenDetail, 'Jenis Perawatan', array('class' => 'control-label')) ?>
                <div class="controls">
<?php // echo $form->dropDownList($modPenerimaanLinenDetail,'jenisperawatanlinen',LookupM::getItems('jenisperawatan'),array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textField($modPenerimaanLinenDetail, 'jenisperawatanlinen', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'readonly' => 'readonly')); ?>
                </div> 
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modPenerimaanLinenDetail, 'instalasi_id', array('class' => 'span3')); ?>
                    <?php echo $form->textField($modPenerimaanLinen, 'instalasi_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                    <?php
//                    echo $form->dropDownList($modPenerimaanLinenDetail, 'instalasi_id', $instalasiTujuans, array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
//                        'ajax' => array('type' => 'POST',
//                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPenerimaanLinenDetail))),
//                            'update' => "#" . CHtml::activeId($modPenerimaanLinenDetail, 'ruangan_id'),
//                    )));
                    ?>
                </div>
            </div>
            <div class="control-group">
<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modPenerimaanLinenDetail, 'ruangan_id', array('class' => 'span3')); ?>
                    <?php echo $form->textField($modPenerimaanLinen, 'ruangan_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
<?php // echo $form->dropDownList($modPenerimaanLinenDetail, 'ruangan_id', $ruanganTujuans, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>           
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php // echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
        <?php
//        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
//            'onclick' => 'return refreshForm(this);'));
        ?>
    </div>
<?php $this->endWidget(); ?>
</div>