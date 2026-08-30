<?php
    $this->breadcrumbs=array(
        'tingkatrisiko Ms'=>array('index'),
        $model->tingkatrisiko_id,
    );
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Tingkat Risiko</b></div>
    </div>
    <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row-fluid">
            <div class="span6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        array(
                            'label' => 'Tingkat Risiko',
                            'value' => $model->tingkatrisiko_nama,
                        ),
                        array(
                            'label' => 'Skor Risiko',
                            'value' => $model->tingkatrisiko_nilai,
                        ),
                        array(
                            'label' => 'Warna Risiko',
                            'value' => $model->tingkatrisiko_warna,
                        ),
                        array(
                            'label' => 'Tindakan',
                            'value' => $model->tingkatrisiko_tindakan,
                        ),
                        array(
                            'label' => 'Status',
                            'value' => ($model->tingkatrisiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
		)); ?>
            </div>
	</div>
	<div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->tingkatrisiko_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tingkat Risiko',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('type'=>'view')); ?>
            </div>
	</div>
    </div>
</div>
