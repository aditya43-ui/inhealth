<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lbkelkumurhasillab-m-form',
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
        <?php echo $form->textFieldRow($model, 'kelkumurhasillabnama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Kelompok Umur Hasil Lab.')); ?>
        <?php echo $form->textFieldRow($model, 'umurminlab', array('class' => 'span3 integer umurminlab', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onblur' => 'setHariLab()', 'placeholder' => '00')); ?>
        <?php echo $form->textFieldRow($model, 'umurmakslab', array('class' => 'span3 integer umurmakslab', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onblur' => 'setHariLab()', 'placeholder' => '00')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'kelkumurhasillab_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelkumurhasillab_aktif', array('id' => 'aktif')); ?> <label for="aktif">Kelompok Umur Hasil Laboratorium Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'satuankelumur', LookupM::getItems(Params::LOOKUPTYPE_SATUAN_KELOMPOK_UMUR), array('empty' => '-- Pilih --', 'class' => 'span3 satuankelumur', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onchange' => 'setHariLab()')); ?>
        <?php echo $form->textFieldRow($model, 'hariminlab', array('class' => 'span3 integer hariminlab', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => '00')); ?>
        <?php echo $form->textFieldRow($model, 'harimakslab', array('class' => 'span3 integer harimakslab', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => '00')); ?>
        <?php echo $form->textFieldRow($model, 'kelkumurhasillab_urutan', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 9, 'placeholder' => '00')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'class' => 'btn btn-default', 'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelompok Umur Hasil Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelompok Umur', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips.tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function setHariLab() {
        var umurminlab = $('.umurminlab').val();
        var umurmakslab = $('.umurmakslab').val();
        var satuankelumur = $('.satuankelumur').val();
        var hariminlab = 0;
        var harimakslab = 0;

        if (satuankelumur == 'Hr') {
            var hariminlab = umurminlab;
            var harimakslab = umurmakslab;
        } else if (satuankelumur == 'Bln') {
            var hariminlab = umurminlab * 30;
            var harimakslab = umurmakslab * 30 + 29;
        } else if (satuankelumur == 'Thn') {
            var hariminlab = umurminlab * 360;
            var harimakslab = umurmakslab * 360 + 359;
        }
        $('.hariminlab').val(hariminlab);
        $('.harimakslab').val(harimakslab);
    }
</script>