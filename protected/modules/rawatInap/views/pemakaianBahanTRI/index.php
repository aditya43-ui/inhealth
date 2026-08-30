<?php
$this->breadcrumbs = array(
    'Pemakaian Bahan',
);
$this->widget('bootstrap.widgets.BootAlert');

//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));

//$this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran));
?>

<!--<legend class="rim2">Pemakaian Bahan Pasien</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpemakaian-bahan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#namaObatNonRacik',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-mortar-pestle"></i> Pemakaian Bahan
        </div>
    </div>
    <div class="panel-body">
        <div class="formInputTab">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fas fa-history"></i> Riwayat Pemakaian <b>Obat & Kesehatan</b>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial('_listObatAlkesPasien', array('modViewBmhp' => $modViewBmhp), true); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="far fa-file-alt"></i> Pemakaian Bahan
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial('_formPemakaianBahan', array('modPendaftaran' => $modPendaftaran)); ?>
                </div>
            </div>

            <?php // $this->renderPartial('_formPemakaianBahan',array('modPendaftaran'=>$modPendaftaran)); 
            ?>

            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                ); ?>
                <?php

                echo CHtml::link(
                    Yii::t(
                        'mds',
                        '{icon} Print',
                        array('{icon}' => '<i class="entypo-print"></i>')
                    ),
                    'javascript:void(0);',
                    array(
                        'class' => 'btn btn-info',
                        'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
                    )
                );


                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('modPendaftaran' => $modPendaftaran)); ?>