<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs = array(
    'Asesmen Awal Medis',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'asesmen-awal-medis-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
        ));
?>
<style>
    .groupUkurans{
        display:inline;
    }
    .numbers-only{
        text-align: right;
    }
    .form-horizontal .control-label{
        text-align: left;
    }
    a.accordion-toggle{
        color: #045702 !important;
        text-decoration: none !important;
        background: #BDEDBC none repeat scroll 0% 0% !important;
        border: 1px solid #b4e8a8 !important;
        font-weight: inherit !important;
        padding: 10px !important;
        font-size: 14px !important;
        border-radius: 5px 5px 0px 0px !important;
    }
    .accordion-inner{
        border: 1px solid #b4e8a8 !important;
    }
</style>
<?php

$pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
$modMonitoringPostHd->pendaftaran_id = $pendaftaran_id;
$modPrescription->pendaftaran_id = $pendaftaran_id;

$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'riwayat1',
    'content' => array(
        'content-riwayat1' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan riwayat asesmen awal medis')) . '<b> Riwayat Monitoring Pasien Pre HD</b>',
            'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatPreHd', array(
                'model' => $model,
                    ), true),
            'active' => false,
        ),
    ),
));
?>
<br>
<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'riwayat2',
    'content' => array(
        'content-riwayat2' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan riwayat prescription dokter')) . '<b> Riwayat Prescription Dokter</b>',
            'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatPrescription', array(
                'modPrescription' => $modPrescription,
                    ), true),
            'active' => false,
        ),
    ),
));
?>
<br>
<?php $this->renderPartial($this->path_view . '_form1', array('model' => $model, 'form' => $form)); ?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'form2',
    'content' => array(
        'content-form2' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Monitoring Pasien Pre HD')) . ' Monitoring Pasien Pre HD',
            'isi' => $this->renderPartial($this->path_view . '_form2', array(
                'form' => $form,
                'model' => $model,
                'st' => 'asuhan'
                    ), true),
            'active' => true,
        ),
    ),
));

$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'form3',
    'content' => array(
        'content-form3' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Pengkajian Medis dan Keperawatan')) . ' Pengkajian Medis dan Keperawatan',
            'isi' => $this->renderPartial($this->path_view . '_form3', array(
                'form' => $form,
                'model' => $model,
                'modAksesVaskular' => $modAksesVaskular,
                'st' => 'asuhan',
                'modLabEks' => $modLabEks
                    ), true),
            'active' => true,
        ),
    ),
)); 

$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'form4',
    'content' => array(
        'content-form4' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Masalah Keperawatan')) . ' Masalah Keperawatan',
            'isi' => $this->renderPartial($this->path_view . '_form4', array(
                'form' => $form,
                'model' => $model,
                'modMasalahKeperawatan' => $modMasalahKeperawatan,
                'st' => 'asuhan'
                    ), true),
            'active' => true,
        ),
    ),
)); 

$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'form5',
    'content' => array(
        'content-form5' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Intervensi Keperawatan')) . ' Intervensi Keperawatan',
            'isi' => $this->renderPartial($this->path_view . '_form5', array(
                'form' => $form,
                'model' => $model,
                'modIntervensiKeperawatan' => $modIntervensiKeperawatan,
                'st' => 'asuhan'
                    ), true),
            'active' => true,
        ),
    ),
)); 
?>

<div class="form-actions">
    <?php
    if (empty($_GET['sukses'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false));
        echo "&nbsp;";
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id']), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
        echo "&nbsp;";
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true));
        echo "&nbsp;";
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id']), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
        echo "&nbsp;";
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "myAlert('Coming Soon!');return false", 'enabled' => 'true'));
    }
    ?>
    <?php
    $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran)); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modLabEks' => $modLabEks,
    'model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran)); ?>