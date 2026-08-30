<?php
$this->breadcrumbs=array(
	'Konsekuensi Ms'=>array('index'),
	$model->konsekuensi_id,
);

?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Konsekuensi</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        array(
                            'label' => 'Domain',
                            'value' => $model->konsekuensi_domain,
                        ),
                        array(
                            'label' => 'Bobot Domain',
                            'value' => $model->konsekuensi_bobot,
                        ),
                        array(
                            'label' => 'Bobot Nama',
                            'value' => $model->konsekuensi_namabobot,
                        ),
                        array(
                            'label' => 'Deskripsi',
                            'value' => $model->konsekuensi_deskripsi,
                        ),
                        array(
                            'label' => 'Status',
                            'value' => ($model->konsekuensi_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Konsekuensi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips.'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
        </div>
    </div>
