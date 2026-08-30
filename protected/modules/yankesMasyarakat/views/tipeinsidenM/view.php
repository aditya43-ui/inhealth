<?php
    $this->breadcrumbs=array(
        'Tipeinsiden Ms'=>array('index'),
        $model->tipeinsiden_id,
    );
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Tipe Insiden</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        array(
                            'label' => 'Nama',
                            'value' => $model->tipeinsiden_nama,
                        ),
                        array(
                            'label' => 'Nama Lain',
                            'value' => $model->tipeinsiden_namalainnya,
                        ),
                        array(
                            'label' => 'Urutan',
                            'value' => $model->tipeinsiden_urutan,
                        ),
                        array(
                            'label' => 'Status',
                            'value' => ($model->tipeinsiden_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
		)); ?>
            </div>
	</div>
	<div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->tipeinsiden_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Insiden',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('type'=>'view')); ?>
            </div>
	</div>
    </div>
</div>
