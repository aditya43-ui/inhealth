<?php
$this->breadcrumbs = array(
    'Dokumen SSUK' => array('index'),
    $model->lookup_id,
);
?>
<!--<div class="white-container">-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> Lihat <b> Dokumen SSUK </b> </div>
    </div>
    <div class="panel-body">


        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="span6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'lookup_id',
                        'lookup_name',
                        'lookup_value',                        
                        'lookup_urutan',                        
                        array(
                            'label' => 'Aktif',
                            'type' => 'raw',
                            'value' => ($model->lookup_aktif == true ) ? "Aktif" : "Tidak Aktif",
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),                                         
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->lookup_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Dokumen SSUK', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                <?php $this->widget('UserTips', array('type' => 'view')); ?>
            </div>
        </div>        
    </div>
</div>
<!--</div>-->