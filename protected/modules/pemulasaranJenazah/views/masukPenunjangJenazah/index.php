<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'masukkamar-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#PJPasienpulangT_penerimapasien',
        'method'=>'post',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'readOnlyNoRm'=>true)) ?>

<?php $this->renderPartial('_formPasienPulang',array('modelPulang'=>$modelPulang,
                                                     'modPasien'=>$modPasien,
                                                     'form'=>$form,
                                                     'instalasi_id'=>$instalasi_id,
                                                     'modMasukKamar'=>$modMasukKamar,
                                                     'tersimpan'=>$tersimpan,
        )); ?>

<?php $this->endWidget(); ?>
