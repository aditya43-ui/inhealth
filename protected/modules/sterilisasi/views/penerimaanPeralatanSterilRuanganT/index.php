<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-archive'></i> Transaksi <b>Penerimaan Peralatan Steril Ruangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php

        $menuArr = array();

        if (isset($_GET['kirimperlinensteril_id'])) {
            $menuArr['Penerimaan Peralatan Steril'] = $this->getReferrer();
        }

        $this->breadcrumbs = array(
            'Transaksi Penerimaan Peralatan Steril Ruangan',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Penerimaan Peralatan Steril " . $model->terimaperlinensteril_no . " berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cspenerimaanperalatansteril-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#' . CHtml::activeId($model, 'terimaperlinensteril_ket'),
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php
                    if (isset($_GET['kirimperlinensteril_id'])) {
                    ?>
                        <i class="glyphicon glyphicon-file"></i> Data <b>Pengiriman</b>
                    <?php
                    } else {
                    ?>
                        <i class="entypo-search"></i> Data <b>Pencarian</b>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPencarian', array(
                    'modCari' => $modCari, 'form' => $form
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Peralatan dan Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tabelPengiriman', array('modPengDetails' => $modPengDetails)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPenerimaan', array('model' => $model, 'form' => $form, 'format' => $format)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)
            ); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                'class' => 'btn btn-default',
                'title' => 'Ulang',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
            ));
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>

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
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modCari' => $modCari)); ?>