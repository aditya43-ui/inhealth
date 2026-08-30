<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sakamar-ruangan-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'kamarruangan_id',array('class'=>'span5')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>

        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'span3 inputRequire', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                        'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                    )
                ));
                ?>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->RuanganKamarItems, 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
        <?php 
            if ($this->module->id != 'hemodialisa'){
                echo $form->textFieldRow($model, 'kamarruangan_nokamar', array('class' => 'span3', 'placeholder' => 'Nama Kamar',)); 
            }else{
                echo '<div class="control-group">';
                echo '<label class="control-label">Lantai</label>';
                echo '<div class="controls">';
                echo $form->textField($model, 'kamarruangan_nokamar', array('class' => 'span3', 'placeholder' => 'Lantai',)); 
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
    <div class="col-sm-6">
        <?php //echo $form->textFieldRow($model,'kamarruangan_nokamar',array('class'=>'span1','maxlength'=>2)); 
        ?>

        <?php //echo $form->textFieldRow($model,'kamarruangan_jmlbed',array('class'=>'span1','maxlength'=>2)); 
        ?>

        <?php //echo $form->textFieldRow($model,'kamarruangan_nobed',array('class'=>'span1','maxlength'=>2)); 
        ?>

        <?php //echo $form->checkBoxRow($model,'kamarruangan_status'); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'kamarruangan_status', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kamarruangan_status', array('checked' => 'kamarruangan_status')); ?> <label for="SAKamarRuanganM_kamarruangan_status">Terpakai</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'kamarruangan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kamarruangan_aktif', array('checked' => 'kamarruangan_aktif')); ?> <label for="SAKamarRuanganM_kamarruangan_aktif">Aktif</label>
            </div>
        </div>
        <?php //echo $form->checkBoxRow($model,'kamarruangan_aktif',array('checked'=>'kamarruangan_aktif')); 
        ?>
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