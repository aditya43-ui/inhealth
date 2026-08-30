<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'vaksinasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    //'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
));
?>

<?php echo $this->renderPartial($this->path_view."vaksinasi._infoPasien", array(
    'form'=>$form,
    'model'=>$model,
), true); ?>


<br/>
<div class="form-action">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'return cekValidasiRiwayatVaksinasi();', 'title' => 'Simpan')
    );
    
    ?>
</div>


<?php $this->endWidget(); ?>
<script>
</script>