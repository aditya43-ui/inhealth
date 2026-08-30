<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Lihat Domain</div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Domain'=>array('index'),
	$model->domain_id,
);

$this->menu=array(
//        array('label'=>Yii::t('mds','View').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Create').' Asal Rujukan', 'icon'=>'file', 'url'=>array('create')),
//        array('label'=>Yii::t('mds','Update').' Asal Rujukan', 'icon'=>'pencil','url'=>array('update','id'=>$model->asalrujukan_id)),
//	array('label'=>Yii::t('mds','Delete').' Asal Rujukan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->asalrujukan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
//	array('label'=>Yii::t('mds','Manage').' Asal Rujukan', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<fieldset class="box">-->
    <!--<legend class="rim">Lihat Asal Rujukan</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                   
                    'terminologi',
                    'domain_nama',
                    'domain_kode',
                    'domain_kelas',
                    // 'domain_nama',
                    
                array(               // related city displayed as a link
                    'name'=>'domain_aktif',
                    'label'=>'Domain Aktif',
                    'type'=>'raw',
                    'value'=>(($model->domain_aktif==1)? Yii::t('mds','Ya') : Yii::t('mds','Tidak')),
                ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Domain', array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
	</div>
	</div>
</div>
</div>