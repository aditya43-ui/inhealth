<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat Jenis <b> Tindakan Rekam Medik</b></div>
    </div>
    <div class="panel-body">
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'jenistindakanrm_id',
		'jenistindakanrm_nama',
		'jenistindakanrm_namalainnya',
		'jenistindakanrm_aktif',
	),
)); ?>

<?php 
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$this->widget('UserTips',array('type'=>'view'));?>
</div>
</div>