<?php
$this->breadcrumbs = array(
    'Sadokrekammedis Ms',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => $this->path_view . '_view',
)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        $this->createUrl($this->id . '/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Dokumen Rekam Medis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'list')); ?>
</div>