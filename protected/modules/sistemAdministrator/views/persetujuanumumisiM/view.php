<?php
$this->breadcrumbs=array(
	'Isi Persetujuan'=>array('index'),
	$model->persetujuanumumisi_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Lihat <b>Isi Persetujuan</b>
        </div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					'persetujuanumumisi_id',
				'persetujuanumum_id',
				'persetujuan_isi',
				'persetujuan_urutan',
				'persetujuan_isiadagambar',
				'persetujuan_gambar',
				'persetujuan_isiadainputan',
				//'isaktif',
				//'create_time',
				//'update_time',
				//'create_loginpemakai_id',
				//'update_loginpemakai_id',
				//'create_ruangan_id',
				),
		)); ?>
		</div>
		<div class="span6">
			<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
					//'persetujuanumumisi_id',
				//'persetujuanumum_id',
				//'persetujuan_isi',
				//'persetujuan_urutan',
				//'persetujuan_isiadagambar',
				//'persetujuan_gambar',
				//'persetujuan_isiadainputan',
				'isaktif',
				'create_time',
				'update_time',
				'create_loginpemakai_id',
				'update_loginpemakai_id',
				'create_ruangan_id',
				),
		)); ?>
		</div>
	</div>
	<div class="row">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->persetujuanumumisi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Isi Persetujuan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
        
    </div>
</div>


