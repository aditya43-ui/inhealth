<?php
$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif Instalasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Tarif', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); ?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<div class="control-group">
  <div class="controls">
   <?php echo $form->labelEx($model,'komponentarif_id',array('class'=>'control-label required')); ?>
   <?php echo $form->dropDownList($model, 'komponentarif_id', CHtml::listData($model->instalasi_id, 'komponentarif_id', 'komponentarif_nama'),array('empty'=>'-- Pilih Ruangan--','class'=>'span3'));?>
  </div>
</div>    
 <?php  echo $form->labelEx($model,'kelaspelayanan_id',array('class'=>'control-label required')); ?>
<div class="control-group">
    <div class="controls">
        
         <?php 
               $this->widget('application.extensions.emultiselect.EMultiSelect',
                             array('sortable'=>true, 'searchable'=>true)
                        );
                echo CHtml::dropDownList(
                'kelaspelayanan_id[]',
                '',
                CHtml::listData(SAKelasPelayananM::model()->findAll(array('order'=>'kelaspelayanan_nama')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                array('multiple'=>'multiple','key'=>'kelaspelayanan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>
</div>
 <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                              array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'submitButton')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle"></i>')), 
                                                              Yii::app()->createUrl($this->module->id.'/'.ruanganM.'/admin'), 
                                                              array('class' => 'btn btn-default','onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php
$content = $this->renderPartial('sistemAdministrator.views.tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>           
 </div>
<?php $this->endWidget(); ?>