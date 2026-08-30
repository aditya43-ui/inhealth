<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-tshirt"></i> Transaksi <b>Pembersihan Sterilisasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Dekontaminas' => Yii::app()->request->getUrlReferrer(),
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembersihansteril-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($modPembersihan); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tablePenerimaan', array(
                    'modPenerimaanSteril' => $modPenerimaanSteril,
                    'modPenerimaanSterilDetail' => $modPenerimaanSterilDetail,
                    'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pembersihan
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPembersihan', array(
                    'modPembersihan' => $modPembersihan,
                    'format' => $format,
                    'form' => $form,
                    'modDekontaminasiDetail' => $modDekontaminasiDetail,
                    'modDekontaminasi' => $modDekontaminasi
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if ($modPembersihan->isNewRecord) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Mulai', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => ''));
                //                                                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false;",'disabled'=>'true', 'style'=>'cursor:not-allowed;'));

            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Mulai', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true));
                //                                                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAsesmen();return false",'enabled'=>'true'));
            } ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script>
    $(document).ready(function() {
        setValidasiCekDisabled($('#pembersihansteril-t-form'));
    });
</script>