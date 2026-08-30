<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Darah Pasien' => Yii::app()->request->getUrlReferrer(),
    'Penyerahan Darah',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Penerimaan Darah
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penyerahandarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body" id="form_permintaan">
                <?php echo $this->renderPartial($this->path_view . 'form/_formPasien', array(
                    'permintaan' => $permintaan,
                    'pendaftaran' => $pendaftaran,
                    'model' => $model,
                ), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Pengiriman Darah
                </div>
            </div>
            <div class="panel-body" id="panel_penyiapan">
                <?php echo $this->renderPartial($this->path_view . 'form/_formPenyiapan', array(
                    'permintaan' => $permintaan,
                    'penyiapan' => $penyiapan,
                ), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Penerimaan Darah
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form/_formPenyerahan', array(
                    'permintaan' => $permintaan,
                    'penyiapan' => $penyiapan,
                    'model' => $model,
                ), true); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php

            //            $model = PenyerahandarahT::model()->findByAttributes(array(
            //                'permintaandarah_id'=>$permintaan->permintaandarah_id,
            //            ));

            $disabled = isset($_GET['sukses']) ? true : false;

            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                'class' => 'btn btn-primary ' . ($disabled ? '' : 'submit'),
                'disabled' => $disabled,
                'onclick' => 'cekForm();',
                'type' => 'button'
            ));
            if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                    'class' => 'btn btn-default',
                    //                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = ' . $this->createUrl('index') . ';}); return false;'
                ));
            }

            // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
            //     'class' => 'btn btn-info', 
            //     'onclick' => "printLabel();return false",
            //     "disabled"=>!$disabled,
            //     ));

            $content = $this->renderPartial($this->path_view . 'tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view . 'form/_jsFunctions', array(
    'permintaan' => $permintaan,
    'model' => $model
), true); ?>

<div hidden>
    <?php

    /**
     * Dikarenakan datepicker di-load via ajax sedangkan tidak ada input tanggal ketika
     * menu ditampilkan, maka dibuat fielf dummy ini.
     */

    $this->widget('MyDateTimePicker', array(
        'name' => 'dummy',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array(
            'hidden' => false,
            'readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>