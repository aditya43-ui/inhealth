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
<div class="formInputTab">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Riwayat Pemakaian <b>Obat & Kesehatan</b>
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view_rj . '_listObatAlkesPasien', array('modViewBmhp' => $modViewBmhp)); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Pemakaian Bahan
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial($this->path_view_rj . '_formPemakaianBahan', array('modPendaftaran' => $modPendaftaran)); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick'=>'cekSimpan();', 'onkeypress'=>'cekSimpan();', 'id' => 'btn_simpan')
            ) . '&nbsp;';
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
            ) . '&nbsp;';
        }
        echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id']),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
        ?>

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
<?php $this->renderPartial($this->path_view_rj . '_jsFunctions', array('modPendaftaran' => $modPendaftaran)); ?>