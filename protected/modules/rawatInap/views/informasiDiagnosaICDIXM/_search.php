<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sadiagnosa-icdixm-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'diagnosaicdix_kode'),
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'diagnosaicdix_kode', array('placeholder' => 'Kode Diagnosa', 'class' => 'span3 angkadot-only', 'maxlength' => 10)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'diagnosaicdix_nama', array('placeholder' => 'Nama Diagnosa', 'class' => 'span3 hurufs-only', 'maxlength' => 50)); ?>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'diagnosaicdix_id',array('class'=>'span5')); 
?>
<?php //cho $form->textFieldRow($model,'diagnosaicdix_namalainnya',array('class'=>'span5','maxlength'=>50)); 
?>
<?php //echo $form->textFieldRow($model,'diagnosatindakan_katakunci',array('class'=>'span5','maxlength'=>50)); 
?>
<?php //echo $form->textFieldRow($model,'diagnosaicdix_nourut',array('class'=>'span5')); 
?>
<?php //echo $form->checkBoxRow($model,'diagnosaicdix_aktif',array('checked'=>'diagnosaicdix_aktif')); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $tips = array(
        '0' => 'cari',
        '1' => 'ulang2'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>