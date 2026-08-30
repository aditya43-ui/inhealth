<style>
    .sorot {
        background-color: yellow !important;
    }
</style>

<script type="text/javascript">
    var id_diagnosax = new Array();
    var id_diagnosax_m = new Array();
</script>
<?php
$this->breadcrumbs = array(
    'Verifikasi Diagnosa',
);
$this->renderPartial($path_view . '_formDataPasien', array('modPendaftaran' => $modPendaftaran));

?>

<div class="row">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penjualanresep',
            'content' => array(
                'content-list-penjualanresep' => array(
                    'header' => '<b>Riwayat Diagnosa</b>',
                    'isi' => $this->renderPartial($this->path_view . "_riwayatDiagnosa", array(
                        'modDiagnosa'=>$modDiagnosa,
                        'model'=>$model,
                        'modPendaftaran'=>$modPendaftaran, 
                        'modUraian'=>$modUraian,
                        'path_view'=>$path_view,
                        'modRiwayat' => $modRiwayat
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-resumemedis',
            'content' => array(
                'content-list-resumemedis' => array(
                    'header' => '<b>Riwayat Resume Medis</b>',
                    'isi' => $this->renderPartial($this->path_view . "_riwayatResume", array(
                        'modRiwayatResume' => $modRiwayatResume,
                        'modResume' => $modResume,
                        'riwayatDiagnosaICDX' => $riwayatDiagnosaICDX,
                        'riwayatDiagnosaICD9' => $riwayatDiagnosaICD9,
                        'riwayatDiagnosaKematian' => $riwayatDiagnosaKematian,
                        'riwayatObatAlkesPasien' => $riwayatObatAlkesPasien
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>

<?php

$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'uraian-diagnosax-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)',
            'onSubmit' => 'return requiredCheck(this);'
        ),
        'focus' => '#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial(
    $path_view . '_gridDiagnosaICDX',
    array(
        'form' => $form,
        'modDiagnosa' => $modDiagnosa,
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modUraian' => $modUraian,
        'path_view' => $path_view
    )
);
?>

<?php
// var_dump($model_ix); die;
$this->renderPartial(
    $path_view . '_gridDiagnosaICDIX',
    array(
        'form' => $form,
        'modDiagnosaix' => $modDiagnosaix,
        'model' => $model_ix,
        'modPendaftaran' => $modPendaftaran,
        'modUraian' => $modUraianIx,
        'path_view' => $path_view
    )
);
?>


<?php 
$menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
$is_meninggal = false;

if($menu == 'RI') {
    if(!empty($modResume->pasienadmisi->pasienpulang_id)) {
        if($modResume->pasienadmisi->pasienpulang->carakeluar_id == 4) {
            $is_meninggal = true;
        }
    }
} else {
    if(empty($modResume->pendaftaran->pasienadmisi_id)) {
        if(!empty($modResume->pendaftaran->pasienpulang_id)) {
            if($modResume->pendaftaran->pasienpulang->carakeluar_id == 4) {
                $is_meninggal = true;
            }
        }
    }
}

?>

<?php
// var_dump($model_ix); die;
$this->renderPartial(
    $path_view . '_gridDiagnosaKematian',
    array(
        'form' => $form,
        'path_view' => $path_view,
        'riwayatMortalitas' => $riwayatMortalitas,
        'modPendaftaran' => $modPendaftaran,
        'is_meninggal' => $is_meninggal
    )
);
?>

<?php

if (!empty($verifikasi->petugasverifikasi)) {
    $verifikasi->petugasverifikasi_nama = $verifikasi->petugasverifikasi->namaLengkap;
}

?>
<div class="col-sm-offset-6" style="margin-top: 17px;">
    <?php if($is_meninggal == 4):?>
        <div class="control-group" hidden>
           <label for="" class="control-label">Penyebab Kematian</label>
            <div class="controls">
                <?php echo $form->textArea($verifikasi, 'penyebabkematian', array(
                    'placeholder' => 'Penyebab Kematian', 'readonly' => false, 'class' => 'span3'
                )); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="control-group">
        <?php echo $form->labelEx($verifikasi, 'keteranganverifikasi', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textArea($verifikasi, 'keteranganverifikasi', array(
                'placeholder' => 'Keterangan', 'readonly' => false, 'class' => 'span3'
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($verifikasi, 'petugasverifikasi_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($verifikasi, 'petugasverifikasi_nama', array(
                'readonly' => true, 'class' => 'span3'
            )); ?>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="form-actions">
    <?php
    $menu = (isset($_GET['menu']) ? $_GET['menu'] : "");
    if ($menu == 'RJ') {
        $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRJ" : "InfoKunjunganRJ");
        $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
    } else if ($menu == 'RD') {
        $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRD" : "InfoKunjunganRJ");
        $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
    } else if ($menu == 'RI') {
        $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRI" : "InfoKunjunganRJ");
        $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
    }
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    if ($_GET['frame'] != 1) {
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('id' => $modPendaftaran->pendaftaran_id)), array('class' => 'btn btn-default'));
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Back', array('{icon}' => '<i class="entypo-cancel"></i>')),
            array(
                'class' => 'btn btn-primary', 'onKeypress' => 'return formSubmit(this,event)',
                'onclick' => '$("#iframeVerifikasiDiagnosa").attr("src",$(this).attr("href")); window.parent.$("#dialogVerifikasiDiagnosa").dialog("close");return false;'
            )
        );
    }

    ?>
</div>

<?php 
// dialog dignosa
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosaKematian',
    'options' => array(
        'title' => 'Daftar Diagnosa',
        'autoOpen' => false,        
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

$this->renderPartial($this->path_view . '_dialogDiagnosaKematian', array('modPendaftaran' => $modPendaftaran));

$this->endWidget();
?>
<?php
$this->endWidget();
?>
<?php 
    $this->renderPartial($this->path_view . '_jsFunctionsKematian');
?>