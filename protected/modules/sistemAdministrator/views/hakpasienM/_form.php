<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hakpasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!-- <p class="help-block"><?php //echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p> -->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'hakpasien_nama', array('placeholder' => 'Nama', 'class' => 'span4', 'rows' => 2, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'hakpasien_urutan', array('class' => 'span1 integer urutan', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
        <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelompok', LookupM::getItems("kelompokhakpasien"), array('empty' => '-- Pilih --', 'class' => 'span3 kelompok', 'onchange' => 'setKelompok()', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group" <?php echo $model->isNewRecord ? "hidden" : ""; ?>>
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'hakpasien_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="HakpasienM_hakpasien_aktif">Aktif</label>
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
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Hak dan Kewajiban Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function setKelompok() {

        var kel = $('.kelompok').val();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getKelompok') ?>',
            dataType: "json",
            data: {
                kel: kel
            },
            success: function(data) {
                $('.urutan').val(data.data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>