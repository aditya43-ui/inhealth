<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sop-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'instalasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::activeDropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'sop_nodokumen', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'sop_tglterbit', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'sop_tglterbit',
                        'mode' => 'date',
                        'options' => array(
                            'showOn' => false,
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style'=>'width: 100px'
                        ),
                    )); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal/ No. Revisi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'sop_tglrevisi',
                        'mode' => 'date',
                        'options' => array(
                            'showOn' => false,
                        ),
                        'htmlOptions' => array(
                            'class' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style'=>'width: 150px'
                        ),
                    )); 
                ?>
            </div>
            <div class="controls">
                <?php echo $form->textField($model, 'sop_norevisi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::activeDropDownList($model, 'pegawai_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true order by nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --','class'=>'span3')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'sop_jmlhalaman', array('class' => 'span3 number-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'sop_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength'=>150)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'sop_pengertian', array('class' => 'control-label')); ?>
            <div class="controls" style="width: 70%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'sop_pengertian', 'name' => 'jenisdiet_catatan', 'toolbar' => 'mini', 'height' => '200px')) ?>
            </div>
        </div> 
        <?php echo $form->textFieldRow($model, 'sop_tujuan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength'=>250)); ?>
        <?php echo $form->textFieldRow($model, 'sop_kebijakan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength'=>250)); ?>          
        <div class="control-group">
            <?php echo $form->labelEx($model, 'sop_image', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'sop_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Gambar')); ?>
            </div>
        </div>      
        
        <?php if(!empty($model->sop_id)){ ?>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'sop_aktif', array()) ?>
                <label for="">Aktif</label>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan SOP', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'autocomplete-search',
        '1' => 'simpan',
        '2' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
