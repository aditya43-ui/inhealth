<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saklasifikasidiagnosa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <?php
        $dtd = DtdM::model()->findAll(array(
            'condition' => 'dtd_aktif = true',
            'order' => 'dtd_kode asc',
        ));
        echo $form->dropDownListRow($model, 'dtd_id', CHtml::listData($dtd, 'dtd_id', 'dtd_kode')); ?>
        <?php echo $form->textFieldRow($model, 'klasifikasidiagnosa_kode', array('placeholder' => 'Kode Klasifikasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?>
        <?php echo $form->textFieldRow($model, 'klasifikasidiagnosa_nama', array('placeholder' => 'Nama Klasifikasi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
        <div>
            <?php //echo $form->checkBoxRow($model,'klasifikasidiagnosa_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <div class="control-group">
                <?php echo CHtml::label("", 'klasifikasidiagnosa_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'klasifikasidiagnosa_aktif', array()); ?> <label>Aktif</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'klasifikasidiagnosa_namalain', array('placeholder' => 'Nama Lain', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'klasifikasidiagnosa_desc', array('placeholder' => 'Deskripsi Klasifikasi', 'rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
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
        Yii::t('mds', '{icon} Pengaturan Klasifikasi Diagnosa', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>