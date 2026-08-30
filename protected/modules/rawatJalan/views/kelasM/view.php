<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Lihat Kelas</div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Domain'=>array('index'),
	$model->kelas_id,
);



$this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Asal Rujukan</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                   
                    // 'terminologi',
                    'kelas_nama',
                    'kelas_kode',
                    // 'kelas_kelas',
                    // 'kelas_nama',
                    
                array(               // related city displayed as a link
                    'name'=>'kelas_aktif',
                    'label'=>'Kelas Aktif',
                    'type'=>'raw',
                    'value'=>(($model->kelas_aktif==1)? Yii::t('mds','Ya') : Yii::t('mds','Tidak')),
                ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas', array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
	</div>
	</div>
</div>
</div>