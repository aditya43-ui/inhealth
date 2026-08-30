<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'metodepengadaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/ckeditor/ckeditor.js"></script>


<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">

    <div class="col-md-6">
        <div class="control-group">
            <?php
            echo CHtml::label("Jenis Dokumen <span class='required'>*</span>", "", array(
                'class' => 'control-label'
            ));
            ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenissurat_id', CHtml::listData(JenisSuratM::model()->findAll('jenissurat_aktif IS TRUE AND modul_id = '.Params::MODUL_ID_PENGADAAN.' order by jenissurat_nama ASC'), 'jenissurat_id', 'jenissurat_nama'), array('empty'=>'-- Pilih --','class' => 'span3 jenisform required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
            </div>   
        </div>   
        <?php echo $form->textFieldRow($model, 'konfigtemplatesurat_nama', array('class' => 'span4 required', 'onkeyup'=>"namaLain(this)")); ?>
        <?php echo $form->textFieldRow($model, 'nama_lain', array('class' => 'span4')); ?>


        `   </div>
    <div class="col-md-6">
        <?php echo $form->textFieldRow($model, 'keterangan', array('class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'urutan', array('class' => 'span4 numbers-only')); ?>
        <div class="control-group">
            <?php
            echo CHtml::label("", "", array(
                'class' => 'control-label'
            ));
            ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'konfigtemplatesurat_aktif', array('checked' => 'checked')) . "Aktif"; ?>
            </div>
        </div>

    </div>
</div>
<div class="row-fluid">

    <div class = "span12">

        <div class="control-group">
            <?php
            echo CHtml::label("isi", "", array(
                'class' => 'control-label'
            ));
            ?>
            <div class="controls" style="width:75%;">
                <?php echo $form->textArea($model, 'konfigtemplatesurat_isi', array('class' => 'form-control ckeditor'));?> 
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Template Dokumen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',
        );
        $content = $this->renderPartial('pengadaan.views.tips.master', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
function namaLain(nama)
    {
        $('#ADKonfigtemplatesuratK_nama_lain').val(nama.value.toUpperCase());
    }
    $(".ckeditor").ckeditor();
</script>