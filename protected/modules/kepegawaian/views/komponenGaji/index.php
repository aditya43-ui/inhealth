<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Transaksi <b>Komponen Gaji Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pegawai' => Yii::app()->request->getUrlReferrer(),
            'Transaksi Komponen Gaji Pegawai',
        );
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'sapegawai-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekSubmit(this);return false;'),
            'focus' => '#',

        ));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $form->errorSummary($modKomGajiDet); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPegawai', array('modPegawai' => $modPeg, 'form' => $form)) ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Detail <b>Komponen Gaji</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_form', array('modPegawai' => $modPeg, 'form' => $form, 'modKomGajiDet' => $modKomGajiDet,)) ?>
            </div>
        </div>
        <div class="form-actions">
            <?php

            $link_ulang = Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/index&id=' . (!isset($_GET['id']) ? '' : $_GET['id']));

            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger', 'disabled' => 'disabled', 'type' => 'button')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit')
                );
            }

            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $link_ulang,
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $link_ulang . '";}); return false;'
                )
            );

            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit2b', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('modelGaji' => $modelGaji, 'modKomGajiDet' => $modKomGajiDet)); ?>