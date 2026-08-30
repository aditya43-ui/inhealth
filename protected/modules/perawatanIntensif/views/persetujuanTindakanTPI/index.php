<?php
$arrMenu = array();

if (isset($_GET['pendaftaran_id'])) {
    $arrMenu["Informasi Rawat Intensif"] = $this->getReferrer();
}

$arrMenu[] = "Surat Persetujuan Tindakan";

$this->breadcrumbs = $arrMenu;

?>

<div class="panel panel-gradient">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI 
    ?>
    <div class="panel-heading">
        <div class="panel-title">Surat Persetujuan Tindakan</div>
        <div class="panel-options">
            <?php
            if (!empty($this->getReferrer())) {
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', $this->getReferrer(), array('class' => 'btn btn-default', 'style' => 'color: white;'));
            } ?>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'suratpersetujuantindakan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#nama_pasien',
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Surat Pesertujuan Tindakan berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="row">
            <fieldset class="box" id="form-persetujuan tindakan">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formSuratPersetujuan', array(
                        //                                                'modKunjungan'=>$modKunjungan,
                        'modSuratPersetujuan' => $modSuratPersetujuan,
                        'format' => $format,
                        'form' => $form,
                        'data' => $data,
                        'modPasienAnestesi' => $modPasienAnestesi,
                        'modPraAnestesi' => $modPraAnestesi,
                        'modTindakanAnestesi' => $modTindakanAnestesi,
                        'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
                        'modPendaftaran' => $modPendaftaran,
                        'modPasien' => $modPasien
                    )); ?>
                </div>
            </fieldset>
        </div>

        <div class="form-actions">
            <?php
            if (!empty($_GET['suratpersetujuantm_id'])) {
                echo CHtml::htmlButton(Yii::t(
                    'mds',
                    '{icon} Create',
                    array('{icon}' => '<i class="entypo-check"></i>')
                ), array(
                    'class' => 'btn btn-danger', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => true
                ));
                echo "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t(
                    'mds',
                    '{icon} Create',
                    array('{icon}' => '<i class="entypo-check"></i>')
                ), array(
                    'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'
                ));
                echo "&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    //                                                'modKunjungan'=>$modKunjungan,
    'modSuratPersetujuan' => $modSuratPersetujuan,
    'format' => $format,
    'form' => $form,
    'data' => $data,
    'modPasienAnestesi' => $modPasienAnestesi,
    'modPraAnestesi' => $modPraAnestesi,
    'modTindakanAnestesi' => $modTindakanAnestesi,
    'modObatAlkesAnestesi' => $modObatAlkesAnestesi,
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien
));
?>