<?php
//$this->breadcrumbs=array(
//	'Jenismakanan Ms'=>array('index'),
//	$model->jenismakanan_id,
//);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Jenis Makanan</b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

		<div class="row-fluid">
            <div class="col-sm-6">
            <?php
            
            $model->jenismakanan_aktif = $model->jenismakanan_aktif ? "Aktif" : "Tidak Aktif";
            
            $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                    'jeniswaktu.jeniswaktu_nama',
                    'jenismakanan_nama',
                    'jenismakanan_namalainnya',
                    'urutan',
                    'jenismakanan_aktif',
                    //'create_time',
                    //'update_time',
                    //'create_loginpemakai_id',
                    //'update_loginpemakai_id',
                    //'create_ruangan',
                    ),
            )); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenismakanan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Makanan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php $this->widget('UserTips',array('content'=>''));?>
            </div>
        </div>
    </div>
</div>
