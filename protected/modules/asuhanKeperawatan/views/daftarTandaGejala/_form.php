<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenisintervensi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event);', 
        'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 200px !important;
    }
</style>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'tandagejala_daftar_nama', array('placeholder' => 'Masukkan Nama Tanda Gejala',  'class' => 'span3', 'onkeyup' => "namaLain(this); return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'tandagejala_daftar_namalain', array('placeholder' => 'Masukkan Nama Lain Tanda Gejala', 'class' => 'span3', 'onkeyup' => " return $(this).focusNextInputField(event);")); ?>        
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'tandagejala_daftar_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?> <label> Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Tanda Gejala', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    function namaLain(nama)
    {
        $('#<?php echo CHtml::activeId($model, 'tandagejala_daftar_namalain') ?>').val(nama.value.toUpperCase());
    }
</script>
