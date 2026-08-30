<?php
/**
 * digunakan untuk Master pasal perjanjian
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasalperjanjian-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'pasalperjanjian_nama'),
        ));
?>
<div class="row-fluid">
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pasalperjanjian_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pasalperjanjian_nama', array('class' => 'span3', 'placeholder' => 'Ketik Nama Pasal Perjanjian', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pasalperjanjian_uraian', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pasalperjanjian_uraian', array('class' => 'span3', 'placeholder' => 'Ketik Uraian Pasal Perjanjian', 'maxlength' => 100)); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("Isi Pasal Perjanjian", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'pasalperjanjian_isi', 'toolbar' => 'mini', 'height' => '200px')) ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label("", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if ($model->pasalperjanjian_aktif == true) {
                    ?>
                    <?php echo $form->checkBox($model, 'pasalperjanjian_aktif', array('value' => 1, 'uncheckValue' => 0, 'checked' => 'pasalperjanjian_aktif')); ?> <label>Aktif</label>
                    <?php
                } else {
                    ?>
                    <?php echo $form->checkBox($model, 'pasalperjanjian_aktif', array('value' => 1, 'uncheckValue' => 0)); ?> <label>Aktif</label>
                    <?php
                }
                ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'urutan', array('class' => 'span3 numbers-only')); ?>

    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pasal Perjanjian', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
    ?>

    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('pengadaan.views.tips.tipsPasal', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<script>
