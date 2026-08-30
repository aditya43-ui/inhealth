<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Jenis Gerak Dasar</strong></div>
            </div>
            <div class="panel-body">
				<?php
				$arrMenu = array();
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
            array(
							'label' => 'Pemeriksaan Fisik Gerak Dasar',
							'value' => (isset($model->periksafungsigerakdasar) ? $model->periksafungsigerakdasar->periksafungsigerakdasar_nama: "")
						),
            'fungsigerakdasarsinistra_nama',
						'fungsigerakdasarsinistra_namalainnya',
						'fungsigerakdasarsinistra_urutan',
            array(
							'label' => 'Status',
							'value' => (($model->fungsigerakdasarsinistra_aktif==true)?"Aktif":"Tidak Aktif")
						),
					),
				)); ?>
				<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pemeriksaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
				<?php $this->widget('UserTips',array('type'=>'view'));?>
            </div>
        </div>
    </div>
</div>
