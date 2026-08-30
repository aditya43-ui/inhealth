<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>UMDNS</b></div>
    </div>
    <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'UMDNS'=>array('index'),
					$model->umdns_id,
				);
				$arrMenu = array();    
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						'umdns_id',
						'umdns_kode',
						'umdns_nama',
						'umdns_namalainnya',
						'umdns_aktif',
					),
				)); ?>
        <div class="form-actions">
				<?php 
				echo CHtml::link(Yii::t('mds', '{icon} Pengaturan UMDNS', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
				$this->widget('UserTips',array('type'=>'view'));
				?>
        </div>
            </div>
        </div>
    
