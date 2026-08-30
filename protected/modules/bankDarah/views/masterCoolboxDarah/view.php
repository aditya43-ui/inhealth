<?php
$this->breadcrumbs=array(
	'Coolboxdarah Ms'=>array('index'),
	$model->coolboxdarah_id,
);
?>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <strong>Cool Box Darah</strong></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="col-sm-12">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        'coolboxdarah_id',
                        'jml_icepack',
                        'coolboxdarah_nama',
                        'coolbox_merk',
                        'coolbox_jenis',
                        'coolbox_ukuran',
                        'coolbox_jml',
                        'jml_isikantong',
                        'jenis_kantong',
                        'standart_suhu',
                        array(
                            'name'=>'coolbox_aktif',
                            'value'=>($model->coolbox_aktif == 1) ? "Aktif" : "Tidak Aktif",
                            'filter'=>array(1=>'Aktif',0=>'Tidak Aktif'),
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),
                    ),
            )); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Coolbox Darah',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('content'=>''));?>
            </div>
        </div>
    </div>
</div>            
