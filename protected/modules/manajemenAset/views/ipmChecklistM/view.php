<?php
/**
* - digunakan sebagai Admin IPM CHECKLIST
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>IPM Checklist</b></div>
    </div>
    <div class="panel-body">
				<?php
				$this->breadcrumbs=array(
					'IPM Checklist'=>array('index'),
					$model->ipmchecklist_id,
				);
				$arrMenu = array();    
				$this->menu=$arrMenu;
				$this->widget('bootstrap.widgets.BootAlert'); ?>
				<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
					'data'=>$model,
					'attributes'=>array(
						'ipmchecklist_id',
						'ipm_jenis',
						'ipm_list_nourut',
						'ipm_listnama',
						array(
                            'label'=>'Status',
                            'type'=>'raw',
                            'value'=>($model->ipm_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
					),
				)); ?>
        <div class="form-actions">
				<?php 
				echo CHtml::link(Yii::t('mds', '{icon} Pengaturan IPM Checklist', array('{icon}'=>'<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
				$this->widget('UserTips',array('type'=>'view'));
				?>
        </div>
            </div>
        </div>
