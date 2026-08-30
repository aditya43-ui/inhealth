<?php
$this->breadcrumbs=array(
	'Detectability Ms'=>array('index'),
	$model->detectability_id,
);

?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Detectability</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="row-fluid">
		<div class="span6">
		<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                        array(
                            'label' => 'Bobot',
                            'value' => $model->detectability_bobot,
                        ),
                        array(
                            'label' => 'Deskripsi',
                            'value' => $model->detectability_deskripsi,
                        ),
                        array(
                            'label' => 'Kemungkinan Deteksi',
                            'value' => $model->detectability_kemungkinan,
                        ),
                        array(
                            'label' => 'Status',
                            'value' => ($model->detectability_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Detectability',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips.'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
        </div>
    </div>
