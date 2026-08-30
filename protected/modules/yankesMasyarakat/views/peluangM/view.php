<?php
$this->breadcrumbs=array(
	'Peluang Ms'=>array('index'),
	$model->peluang_id,
);

?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Peluang</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        array(
                            'label' => 'Descriptor',
                            'value' => $model->peluang_descriptor,
                        ),
                        array(
                            'label' => 'Bobot Descriptor',
                            'value' => $model->peluang_bobotdescriptor,
                        ),
                        array(
                            'label' => 'Deskripsi',
                            'value' => $model->peluang_deskripsi,
                        ),
                        array(
                            'label' => 'Frekuensi',
                            'value' => $model->peluang_frekuensi,
                        ),
                        array(
                            'label' => 'Kemungkinan',
                            'value' => $model->peluang_kemungkinan,
                        ),
                        array(
                            'label' => 'Status',
                            'value' => ($model->peluang_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Peluang',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips.'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
        </div>
    </div>
