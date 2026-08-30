<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'terdugatb-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RKAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Terduga TB
            </div>
        </div>
        <div class="panel-body">
            <?php 
                if(($jenis != 'ubah') && ($jenis != 'salin')){
                    $this->renderPartial('_row_1');
                }
            ?>
            <?php $this->renderPartial('_row_2', array('form' => $form, 'modTerdugaTb' => $modTerdugaTb)); ?>
            <?php 
                if(($jenis != 'ubah') && ($jenis != 'salin')){
                    $this->renderPartial('_row_3', array('form' => $form, 'modUjiTerdugaTb' => $modUjiTerdugaTb)); 
                }
            ?>
            <?php $this->renderPartial('_row_4', array('form' => $form, 'modTerdugaTb' => $modTerdugaTb)); ?>
            <?php $this->renderPartial('_row_5', array('form' => $form, 'modTerdugaTb' => $modTerdugaTb)); ?>
            <?php
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-success', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            ?>
            <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl('jurnalRekPenjamin/admin'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-warning',
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            ?>
            <?php
                if(($jenis == 'ubah') || ($jenis == 'salin')){
                    echo CHtml::link('Kembali', $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'])), array(
                        'class'=>'btn btn-danger'
                    )); 
                }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    $(".row_3").click(function () {
        $('#row_3').slideToggle();
    });
    $(".row_5").click(function () {
        $('#row_5').slideToggle();
    });
</script>