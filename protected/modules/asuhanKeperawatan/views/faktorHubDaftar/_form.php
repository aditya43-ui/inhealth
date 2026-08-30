<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'faktorHubDaftar-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'lookup_type'),
        ));
    ?>
    <div class="row">
	<div class="col-sm-12">
            <div class="control-group">
                <?= CHtml::label('Nama Kondisi Klinis Terkait', 'faktorhub_daftar_nama', ['class' => 'col-sm-3']) ?>
                <div class="controls">
                    <?= $form->textArea($model, 'faktorhub_daftar_nama', ['rows'=>3, 'style'=>'resize:none;']) ?>
                </div>
            </div>
            <div class="control-group">
                <?= CHtml::label('Nama Lain Kondisi Klinis Terkait', 'faktorhub_daftar_namalain', ['class' => 'col-sm-3']) ?>
                <div class="controls">
                    <?= $form->textArea($model, 'faktorhub_daftar_namalain', ['rows'=>3, 'style'=>'resize:none;']) ?>
                </div>
            </div>
            <div class="control-group">
                <?= CHtml::label('', 'faktorhub_daftar_aktif', ['class' => 'col-sm-3']) ?>
                <div class="controls">
                    <?= $form->checkBox($model, 'faktorhub_daftar_aktif', []) ?>
                </div>
            </div>
	</div>
    </div>

    <div class="form-actions">
            <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array('class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kondisi Klinis Terkait', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
            <?php $this->widget('UserTips', array('type' => 'create')); ?>
    </div>
<?php $this->endWidget(); ?>
