<?php
$this->breadcrumbs=array(
	'Pemakaian Bahan',
);

$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Anamnesis', 'url'=>$this->createUrl('/persalinan/anamnesa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Periksa Fisik', 'url'=>$this->createUrl('/persalinan/pemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Laboratorium', 'url'=>$this->createUrl('/persalinan/laboratorium',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Radiologi', 'url'=>$this->createUrl('/persalinan/radiologi',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Rehab Medis', 'url'=>$this->createUrl('/persalinan/rehabMedis',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Konsultasi Gizi', 'url'=>$this->createUrl('/persalinan/konsulGizi',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Konsul Poliklinik', 'url'=>$this->createUrl('/persalinan/konsulPoli',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Tindakan', 'url'=>$this->createUrl('/persalinan/tindakan',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),'linkOptions'=>array('onclick'=>'return palidasiForm(this);')),
        array('label'=>'Diagnosis', 'url'=>$this->createUrl('/persalinan/diagnosa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Bedah Sentral', 'url'=>$this->createUrl('/persalinan/bedahSentral',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Rujukan Ke Luar', 'url'=>$this->createUrl('/persalinan/rujukanKeluar',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Reseptur', 'url'=>$this->createUrl('/persalinan/reseptur',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id))),
        array('label'=>'Pemakaian Bahan', 'url'=>'','linkOptions'=>array(),'active'=>true),
    ),
));
?>

<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpemakaian-bahan-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return cekInput();'),
)); ?>
<?php $this->renderPartial('_listObatAlkesPasien',array('modViewBmhp'=>$modViewBmhp)); ?>
<?php $this->renderPartial('_formPemakaianBahan',array()); ?>

    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
    </div>
<?php $this->endWidget(); ?>