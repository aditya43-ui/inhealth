<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'ppruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'ruangan_id'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow($model, 'ruangan_id',  CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>

<div class="control-group">
    <div class="controls">

        <?php
        $arrKelasPelayanan = array();
        foreach ($modRuangan as $Ruangan) {
            $arrKelasPelayanan[] = $Ruangan['kelaspelayanan_id'];
        }

        $this->widget(
            'application.extensions.emultiselect.EMultiSelect',
            array('sortable' => true, 'searchable' => true)
        );
        echo CHtml::dropDownList(
            'kelaspelayanan_id[]',
            $arrKelasPelayanan,
            CHtml::listData(PPKelaspelayananM::model()->findAll(array('order' => 'kelaspelayanan_nama')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
            array('multiple' => 'multiple', 'key' => 'kelaspelayanan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
        );
        ?>

    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl('admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelas Ruangan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>


</div>

<?php $this->endWidget(); ?>