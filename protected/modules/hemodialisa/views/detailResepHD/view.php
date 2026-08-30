<?php
$this->breadcrumbs=array(
	'Detail Paket HD'=>array('index'),
	$model->resephd_det_id,
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Detail Paket HD</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
				'data'=>$model,
				'attributes'=>array(
                                    
                                    array(
                                        'name'=>'Nama Paket',
                                        'value'=>$model->resephd_nama
                                    ),
                                    array(
                                        'name'=>'Kode Obat/Alkes',
                                        'value'=>$model->obatalkes_kode
                                    ),
                                    array(
                                        'name'=>'Nama Obat/Alkes',
                                        'value'=>$model->obatalkes_nama
                                    ),
                                    array(
                                        'name'=>'Satuan Kecil',
                                        'value'=>$model->satuankecil_nama
                                    ),
                                    array(
                                        'name'=>'Harga Satuan',
                                        'value'=>$model->hargajual
                                    ),
//                                    array(
//                                        'name'=>'Nama Paket HD',
//                                        'value'=>$model->resephd_nama
//                                    ),
//					'resephd_id',
//				'resephd_nama',
//				'resephd_desc',
//				array(
//                'label'=>'Aktif.',
//				'type'=>'raw',
//				'value' => (($model->resephd_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
//            ),
				),
		)); ?>
		</div>
		<div class="span6">
			<?php // $this->widget('ext.bootstrap.widgets.BootDetailView',array(
//				'data'=>$model,
//				'attributes'=>array(
					//'resephd_id',
				//'resephd_nama',
//				'resephd_desc',
//				'resephd_aktif',
//				),
//		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->resephd_det_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Paket HD',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
    </div>
</div>