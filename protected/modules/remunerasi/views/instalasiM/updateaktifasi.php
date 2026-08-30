<?php
$this->breadcrumbs = array(
    'Pengaturan Instalasi',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Pengaturan <b>Instalasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'sainstalasi-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#SAInstalasiM_instalasi_nama',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>

        <div class="control-group">
            <?php // echo CHtml::label('Aktifasi Instalasi','',array('class'=>'control-label')); 
            ?>
            <div class="controls">
                <?php
                $instalasifalse = array();
                $modInstalasifalse = InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama ASC');
                foreach ($modInstalasifalse as $tampilInstalasi) {
                    $instalasifalse[] = $tampilInstalasi['instalasi_id'];
                }
                echo CHtml::listBox('instalasi_nonaktif[]', $instalasifalse, CHtml::listData(InstalasiM::model()->findAll(array('order' => 'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array('multiple' => 'multiple', 'key' => 'instalasi_id', 'class' => 'multiselect', 'style' => 'width:500px; height:200px'));
                $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true));
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'name' => 'submitInstalasi')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/instalasiM/admin'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>