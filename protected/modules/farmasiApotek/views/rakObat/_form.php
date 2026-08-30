<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'farakobat-m-form',
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
        <?php echo $form->textFieldRow($model, 'rakobat_nama', array('placeholder' => 'Rak Obat', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'rakobat_namalain', array('placeholder' => 'Rak Obat Lainnya', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'rakobat_label', array('placeholder' => 'Rak Obat Label', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 1)); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                
                $ruanganTujuans = array();
                $instalasiTujuans = CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
                    'instalasi_aktif'=>true
                ), array(
                    'order'=>'instalasi_nama asc'
                )), 'instalasi_id', 'instalasi_nama');
                if (!empty($model->instalasi_id)) {
                    $ruanganTujuans = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                        'instalasi_id'=>$model->instalasi_id, 'ruangan_aktif'=>true
                    ), array(
                        'order'=>'ruangan_nama asc'
                    )), 'ruangan_id', 'ruangan_nama');
                }
                
                echo $form->dropDownList(
                    $model,
                    'instalasi_id',
                    $instalasiTujuans,
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                            'update' => '.ruangan_id',
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangan_id', $ruanganTujuans, array('class' => 'span3 ruangan_id', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <?php echo $form->checkBoxRow($model, 'rakobat_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
        Yii::t('mds', '{icon} Pengaturan Rak Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit2', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('FARakobatM_rakobat_namalain').value = nama.value.toUpperCase();
    }
</script>