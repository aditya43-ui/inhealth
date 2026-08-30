<script type="text/javascript">
    var id_diagnosax = new Array();
</script>
<?php
$this->breadcrumbs = array(
    'Verifikasi Diagnosis',
);
//$this->renderPartial($path_view . '_formDataPasien',array('modPendaftaran'=>$modPendaftaran));
?>

<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-x-ray"></i> Diagnosis
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'id' => 'uraian-diagnosax-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)'
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
                'path_view' => $path_view,
                'modAdmisi' => $modAdmisi,
            )
        );
        ?>
        <br>
        <?php
        $this->renderPartial(
            $path_view . '_gridDiagnosaICDIX',
            array(
                'form' => $form,
                'modDiagnosaix' => $modDiagnosaix,
                'model' => $model_ix,
                'modPendaftaran' => $modPendaftaran,
                'modUraian' => $modUraianIx,
                'path_view' => $path_view,
                'modAdmisi' => $modAdmisi,
            )
        );
        ?>

        <div class="form-actions">
            <?php
            if ($instalasi == Params::INSTALASI_ID_RJ) {
                $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRJ" : "InfoKunjunganRJ");
                $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
            } else if ($instalasi == Params::INSTALASI_ID_RD) {
                $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRD" : "InfoKunjunganRJ");
                $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
            } else if ($instalasi == Params::INSTALASI_ID_RI) {
                $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRI" : "InfoKunjunganRJ");
                $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
            }
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            if (@$_GET['frame'] != 1) {

                $modDaftar = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id, array('select' => 'pasienadmisi_id'));
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $modDaftar->pasienadmisi_id)), array('class' => 'btn btn-default'));
                //            echo CHtml::htmlButton(Yii::t('mds','{icon} Back',array('{icon}'=>'<i class="entypo-cancel"></i>')),
                //                array('class'=>'btn btn-primary-blue','onKeypress'=>'return formSubmit(this,event)',
                //                    'onclick'=>'$("#iframeVerifikasiDiagnosa").attr("src",$(this).attr("href")); window.parent.$("#dialogVerifikasiDiagnosa").dialog("close");return false;'));
            }

            ?>
        </div>

        <?php
        $this->endWidget();
        ?>
    </div>
</div>