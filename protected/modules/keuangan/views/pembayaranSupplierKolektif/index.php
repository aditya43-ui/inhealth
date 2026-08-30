<?php $linkHalaman = CustomFunction::getUrlByMenuID(3525); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Supplier Kolektif</b>
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
            'Pembayaran Supplier Kolektif',
        );
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
        }
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaransupplierkolektif-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'
            ),
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '_formSearch', array('model' => $modFakturPembelian, 'modBuktiKeluar' => $modBuktiKeluar)); ?>
        <?php $this->renderPartial($this->path_view . '_formTabelSetoran', array()); ?>
        <?php $this->renderPartial($this->path_view . '_formPembayaran', array('form' => $form, 'model' => $model, 'modBuktiKeluar' => $modBuktiKeluar)); ?>
        <div class="form-actions">
            <?php
            $disabled = ((isset($_GET['sukses'])) ? true : false);
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'validasiFaktur();', 'onclick' => 'validasiFaktur();',
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
            $content = $this->renderPartial('keuangan.views/tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('form' => $form, 'model' => $model, 'modBuktiKeluar' => $modBuktiKeluar, 'modFakturPembelian' => $modFakturPembelian)); ?>