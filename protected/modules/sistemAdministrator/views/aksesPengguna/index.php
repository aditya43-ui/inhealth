<?php
$this->breadcrumbs = array(
    'saaksespengguna Ks',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="col-sm-12">
    <div class="panel panel-primary" data-collapsed="0">
        <div class="panel-heading">
            <div class="panel-title"> Akses Pemakai </div>
        </div>
        <div class='panel-body'>
            <?php $this->widget('ext.bootstrap.widgets.BootListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_view',
            )); ?>

            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/admin'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
                    )
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Pengaturan Akses Pemakai', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                    $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('class' => 'btn btn-success',)
                ); ?>
                <?php $this->widget('UserTips', array('type' => 'list')); ?>
            </div>
        </div>
    </div>
</div>