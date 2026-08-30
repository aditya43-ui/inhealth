<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$model->propinsi_id = (!empty($model->propinsi_id))?$model->propinsi_id:Yii::app()->user->getState('propinsi_id');
                ?>
                <?php echo $form->dropDownList(
                    $model,
                    'propinsi_id',
                    CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => 'AKBankM')),
                            'update' => '#AKBankM_kabupaten_id',
                        )
                    )
                ); ?>
                <?php
                //                                echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                //                                                        array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialogAddPropinsi').dialog('open');}",
                //                                                              'id'=>'btnAddPropinsi','onkeypress'=>"return $(this).focusNextInputField(event)",
                //                                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('propinsi_id'))) 
                ?>
                <?php echo $form->error($model, 'propinsi_id'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php //$model->kabupaten_id = (!empty($model->kabupaten_id))?$model->kabupaten_id:Yii::app()->user->getState('kabupaten_id');
                ?>
                <?php echo $form->dropDownList(
                    $model,
                    'kabupaten_id',
                    CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => 'AKBankM'))
                        )
                    )
                ); ?>
                <?php
                //                                echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                //                                                        array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialogAddKabupaten').dialog('open');}",
                //                                                              'id'=>'btnAddKabupaten','onkeypress'=>"return $(this).focusNextInputField(event)",
                //                                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('kabupaten_id'))) 
                ?>
                <?php echo $form->error($model, 'kabupaten_id'); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'kodepos', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kodepos', array('placeholder' => 'Kode Pos', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'negara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'negara', array('placeholder' => 'Negara', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'matauang_id',
                    CHtml::listData(MatauangM::model()->findAll(), 'matauang_id', 'matauang'),
                    array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
                ); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'namabank', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namabank', array('placeholder' => 'Nama Bank', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'alamatbank', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'alamatbank', array('placeholder' => 'Alamat Bank', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:150px;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label("", 'bank_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'bank_aktif', array('checked' => 'bank_aktif', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label for="SABankM_bank_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>