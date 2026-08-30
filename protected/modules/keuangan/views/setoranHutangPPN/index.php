<?php $linkHalaman = CustomFunction::getUrlByMenuID(3536); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Setoran Utang PPN Keluaran</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Setoran Utang PPN Keluaran',
        );
        ?>
        <?php $this->renderPartial($this->path_view . '_formSearch', array('model' => $modSrch)); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'setoranhutangppn-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'
            ),
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '_formTabelSetoran', array()); ?>
        <?php $this->renderPartial($this->path_view . '_formPembayaran', array('form' => $form, 'model' => $model, 'modBuktiKeluar' => $modBuktiKeluar)); ?>
        <div class="form-actions">
            <?php
            $disabled = ((isset($_GET['sukses'])) ? true : false);
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'validasiFaktur();', 'onclick' => 'simpanSetoran();',
                    'disabled' => $disabled
                )
            );
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
            );
            ?>
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
                    'class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => FALSE
                ));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
                    'class' => 'btn btn-info', 'disabled' => TRUE
                ));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'cari2',
                '1' => 'simpan',
                '2' => 'ulang',
                '3' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('form' => $form, 'model' => $model, 'modBuktiKeluar' => $modBuktiKeluar, 'modSrch' => $modSrch)); ?>