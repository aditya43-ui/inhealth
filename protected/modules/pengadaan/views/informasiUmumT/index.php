<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <b> Informasi Umum </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPejabatPengadaan', array('model' => $model, 'form' => $form, 'disablePejabat' => $disablePejabat,)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <b> Data Penyedia </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPenyedia', array('model' => $model, 'disableSupplier' => $disableSupplier, 'modSupplier' => $modSupplier, 'form' => $form)) ?>
            </div>
        </div>
        <div class="panel panel-success form-penawaran">
            <div class="panel-heading">
                <div class="panel-title"> <b> Data Penawaran Penyedia </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPenawaranPenyedia', array('model' => $model, 'form' => $form, 'modPenawaran' => $modPenawaran, 'disable' => $disable)) ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                $cri = new CDbCriteria();
                $cri->addCondition('pegawai_id = ' . Yii::app()->user->getState('pegawai_id'));
                $cri->addCondition('pejabatpengadaan_aktif is true');
                $cri->addCondition("jabatan_pengadaan = '" . Params::JABATAN_PENGADAAN_PPK . "'");
                $modPPK = PejabatpengadaanM::model()->find($cri);
                $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'], 'isbatal' => false, 'isaddendum' => true));

                if (!empty($cekSPK)) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                } else {
                    if (isset($_GET['sukses'])) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                        echo "&nbsp;";
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                        echo "&nbsp;";
                    }
                }
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('id' => $_GET['id'])), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('modInformasi'=>$modInformasi,'model' => $model, 'modSupplier' => $modSupplier, 'form' => $form, 'modPenawaran' => $modPenawaran)) ?>