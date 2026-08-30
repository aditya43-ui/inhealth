<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpkolomrating-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'indikatorperilaku_id', CHtml::listData(
            IndikatorperilakuM::model()->findAll(array(
                'order' => 'indikatorperilaku_nama',
                'condition' => 'indikatorperilaku_aktif = true',
            )),
            'indikatorperilaku_id',
            'indikatorperilaku_nama'
        ), array(
            'empty' => '-- Pilih --',
            'class' => 'span3',
        )); ?>
        <?php echo $form->textFieldRow($model, 'kolomrating_namalevel', array('placeholder' => 'Nama Level', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'kolomrating_point', array('placeholder' => 'Point', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label('Score', 'Score', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kolomrating_nilaiawal', array('placeholder' => '00', 'class' => 'span1 numbers-only')); ?> s/d
                <?php echo $form->textField($model, 'kolomrating_nilaiakhir', array('placeholder' => '00', 'class' => 'span1 numbers-only')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kolomrating_uraian', array('placeholder' => 'Uraian', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'kolomrating_deskripsi', array('placeholder' => 'Deskripsi', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kolomrating_aktif'); ?>
                <label for="KPKolomratingM_kolomrating_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kolom Rating', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>