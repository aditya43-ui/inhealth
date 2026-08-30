<?php
/**
* digunakan untuk Master grading risiko
* @author Elham Budianto <elhambudianto@.com>
**/
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gradingrisiko-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Peluang","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'peluang_id',Chtml::listData(PeluangM::model()->findAllByAttributes(array('peluang_aktif'=>true)),'peluang_id','peluang_descriptor'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                </div>
            </div> 
            <div class="control-group">
                <?php echo CHtml::label("Konsekuensi","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'konsekuensi_id',Chtml::listData(KonsekuensiM::model()->findAllByAttributes(array('konsekuensi_aktif'=>true)),'konsekuensi_id','konsekuensi_namabobot'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                </div>
            </div> 
	</div>
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tingkat Risiko","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'tingkatrisiko_riskregister_id',Chtml::listData(TingkatrisikoRiskregisterM::model()->findAllByAttributes(array('tingkatrisiko_aktif'=>true)),'tingkatrisiko_riskregister_id','tingkatrisiko_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                </div>
            </div> 
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'gradingrisiko_aktif',array('checked'=>'gradingrisiko_aktif')); ?> <label>Aktif</label>
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
