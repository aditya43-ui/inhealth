<?php
$this->breadcrumbs=array(
	'Tipe Resiko Ms'=>array('index'),
	$model->tiperesiko_id,
);

?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Lihat <b> Tipe Risiko</b> </div>
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
                            'value' => $model->tiperesiko_nama,
                        ),
                        array(
                            'label' => 'Nama Lain',
                            'value' => $model->tiperesiko_namalain,
                        ),
                        array(
                            'label' => 'Kode',
                            'value' => $model->tiperesiko_kode,
                        ),
                        array(
                            'label' => 'Keterangan',
                            'value' => $model->tiperesiko_keterangan,
                        ),
                        array(
                            'label' => 'Status',
                            'value' => ($model->tiperesiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Risiko',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $content = $this->renderPartial($this->path_tips.'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
        </div>
    </div>
