<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppjadwal-buka-poli-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#' . CHtml::activeId($model, 'ruangan_id'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow(
            $model,
            'ruangan_id',
            CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),
            array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'onkeyup' => "return $(this).focusNextInputField(event)"
            )
        ); ?>
        <?php echo $form->dropDownListRow($model, 'hari',  CustomFunction::getNamaHari(), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'jmabuka', array('class' => 'span3 form-control', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'maxantiranpoli', array('style' => 'text-align:right;', 'class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jam Buka Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulai',
                    'mode' => 'time',
                    'options' => array(
                        'onSelect' => 'js:function(){getJamBukaDariJamMulai(this);}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jammulai'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jam Tutup Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamtutup',
                    'mode' => 'time',
                    'options' => array(
                        'onSelect' => 'js:function(){getJamBukaDariJamTutup(this);}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jamtutup'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jam Mulai Pendaftaran Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulaipendaftaran',
                    'mode' => 'time',
                    'options' => array(
                        'onSelect' => 'js:function(){getJamBukaDariJamMulaiPendaftaran(this);}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jammulaipendaftaran'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Jam Akhir Pendaftaran Poliklinik', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamakhirpendaftaran',
                    'mode' => 'time',
                    'options' => array(
                        'onSelect' => 'js:function(){getJamBukaDariJamAkhirPendaftaran(this);}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'jamakhirpendaftaran'); ?>
            </div>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jadwalBukaPoliM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jadwal Buka Poli', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/pendaftaranPenjadwalan/jadwalBukaPoliM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit4', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$idJamMulai =  CHtml::activeId($model, 'jammulai');
$idJamTutup =  CHtml::activeId($model, 'jamtutup');
$idJamBuka =  CHtml::activeId($model, 'jmabuka');
$jscript = <<< JS

function getJamBukaDariJamMulai(obj)
{
    jamMulai = obj.value;
    jamTutup = $('#${idJamTutup}').val();
    $('#${idJamBuka}').val(jamMulai+' s/d '+jamTutup);    
}  

function getJamBukaDariJamTutup(obj)
{
    jamMulai = $('#${idJamMulai}').val(); 
    jamTutup = obj.value;
    $('#${idJamBuka}').val(jamMulai+' s/d '+jamTutup);    
}

function numberOnly(obj)
{
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;

    if (d == 'decimal') {
    value = value.replace(/\./, "");
    msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
    orignalValue = orignalValue.replace(/([^1-9].*)/g, "")
    $(obj).val(orignalValue);
    }else{
    $(obj).val(1);
    }
}
JS;
Yii::app()->clientScript->registerScript('faktur', $jscript, CClientScript::POS_HEAD);
?>