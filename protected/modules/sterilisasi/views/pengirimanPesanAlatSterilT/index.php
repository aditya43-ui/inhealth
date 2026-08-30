<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-file-import"></i> Transaksi <b>Pengiriman Peralatan dan Linen Steril</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pemesanan Alat Steril' => Yii::app()->request->getUrlReferrer(),
            'Create',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Pengiriman Peralatan dan Linen Steril " . $model->kirimperlinensteril_no . " berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cspengirimanalatsteril-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
            'focus' => '#' . CHtml::activeId($model, 'kirimperlinensteril_ket'),
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengiriman</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPengiriman', array('model' => $model, 'form' => $form, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Peralatan dan Linen
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tabelPenyimpanan', array('modPemesananDet' => $modPemesananDet)); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['sukses'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            ); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial('tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions'); ?>