<?php
$this->breadcrumbs = array(
    'SOP' => array('admin'),
    $model->sop_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i><b>SOP</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-12">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(            
                            'label'=>'Instalasi',
                            'type'=>'raw',
                            'value'=>$model->instalasi->instalasi_nama,
                        ),
                        'sop_nodokumen',
                        'sop_norevisi',
                        array(            
                            'label'=>'Aktif',
                            'type'=>'raw',
                            'value'=>(($model->sop_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                        ),
                    ),
                )); ?>
            </div>
            
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->sop_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan SOP', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>