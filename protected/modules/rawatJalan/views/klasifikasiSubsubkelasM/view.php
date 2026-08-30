<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Lihat Klasifikasi Sub Sub kelas</div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Sub Kelas'=>array('index'),
	$model->klasifikasisubsubkelas_id,
);



$this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Asal Rujukan</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                   
                    // 'terminologi',
                    'klasifikasisubsubkelas_nama',
                    'klasifikasisubsubkelas_kode',
                    // 'klasifikasisubsubkelas_klasifikasisubsubkelas',
                    // 'klasifikasisubsubkelas_nama',
                    
                array(               // related city displayed as a link
                    'name'=>'klasifikasisubsubkelas_aktif',
                    'label'=>'Klasifikasi Sub kelas Aktif',
                    'type'=>'raw',
                    'value'=>(($model->klasifikasisubsubkelas_aktif==1)? Yii::t('mds','Ya') : Yii::t('mds',' Tidak')),
                ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sub Sub Kelas', array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
	</div>
	</div>
</div>
</div>