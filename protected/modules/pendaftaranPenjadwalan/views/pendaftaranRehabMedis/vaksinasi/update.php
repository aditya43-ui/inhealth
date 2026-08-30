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
    'modPasien'=>$modPasien,
    'admisi'=>$admisi,
), true); ?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Vaksinasi/Imunisasi</div>
    </div>
    <div class="panel-body" style="overflow-x: auto;">
        <?php echo $this->renderPartial($this->path_view . 'vaksinasi._formVaksinasi', array(
            'form' => $form,
            'model' => $model,
            'modPasien' => $modPasien,
        ), true); ?>
    </div>
</div>
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


<?php $this->renderPartial($this->path_view.'.vaksinasi._dialogVaksinasi', array()); ?>

<script>
    
    $(document).ready(function() {
        getDataRiwayatVaksinasi(<?php echo $model->pasien_id; ?>);
    });

</script>