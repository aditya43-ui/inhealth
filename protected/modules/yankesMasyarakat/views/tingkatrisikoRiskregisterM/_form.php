<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'tingkatrisiko-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'tingkatrisiko_nama')
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class = "col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Risiko','',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model,'tingkatrisiko_nama',array('placeholder'=>'Tingkat Risiko','class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Batas Bawah','',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model,'tingkatrisiko_batasbawah',array('placeholder'=>'Batas Bawah','class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Batas Atas','',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model,'tingkatrisiko_batasatas',array('placeholder'=>'Batas Atas','class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class = "col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Warna Risiko','',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'tingkatrisiko_warna', LookupM::getItems('tingkatwarna_risiko'), array('empty'=>'--Pilih--','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
            <div class="controls">
                <?php 
                    echo CHtml::link('<span class="btn btn-primary"><i class="icon-plus icon-white"></i></span>',
                        Yii::app()->createUrl('yankesMasyarakat/TingkatrisikoM/tambahWarna'),
                        array("rel"=>"tooltip",
                            "title"=>"Klik untuk Menambahkan Warna Risiko",
                            "target"=>"iframe1", 
                            "onclick"=>"$('#dialogTambahWarna').dialog('open');"));
                ?>			
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tindakan','',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->textArea($model,'tingkatrisiko_tindakan',array('class'=>'span4', 'rows'=>3, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'tingkatrisiko_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'tingkatrisiko_aktif',array('checked'=>'tingkatrisiko_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
		array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                $this->createUrl('admin'), 
                array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tingkat Risiko',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php  
            $tips = array(
                '0' => 'autocomplete-search',
                '1' => 'simpan',
                '2' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Tambah Warna=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogTambahWarna',
    'options'=>array(
    'title'=>'Tambah Warna Risiko',
    'autoOpen'=>false,
    'width'=>500,
    'height'=>300,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php $this->endWidget(); ?>