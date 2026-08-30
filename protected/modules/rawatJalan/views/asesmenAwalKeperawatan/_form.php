
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<div class="row-fluid" style="height: 1000px">
    <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id'); ?>
    <?php echo CHtml::activeHiddenField($model, 'pasienadmisi_id'); ?>
    <?php echo CHtml::activeHiddenField($model, 'pasien_id'); ?>
    <?php echo CHtml::activeHiddenField($model, 'asesmenawalkeperawatan_id'); ?>
    <?php echo CHtml::hiddenField('checkSimpanData',''); ?>
    <?php $this->renderPartial($this->path_view.'_formTabulasi',array('modPendaftaran'=>$modPendaftaran,'model'=>$model,'modPasien'=>$modPasien,'modAsesmenkebutuhanEdukasiT' => $modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT' => $modAsesmenkebutuhanEdukasidetT,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT, 'dataFlaCcs' => $dataFlaCcs,'getFlaCcs' => $getFlaCcs, 'modRiwayatObstetrikPasien'=>$modRiwayatObstetrikPasien, 'modAsesmenawalkeperawatanT'=>$modAsesmenawalkeperawatanT)) ?>
</div>
