<style>

    .judul_form {
        font-size: 20pt;
        text-align: center;
        margin-bottom: 50px;
    }

</style>

<div class="judul_form">PRINT SURAT RENCANA KONTROL</div>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'cetak-rencana-kontrol',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'class' => 'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_viewsrk .'_formUtama', array(
    'form'=>$form,
), true); ?>

<?php $this->endWidget(); ?>