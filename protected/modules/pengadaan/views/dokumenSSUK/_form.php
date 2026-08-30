<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'dokumenpengadaan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event);',
            'onsubmit'=>'return requiredCheck(this);',
            'enctype'=>'multipart/form-data',
        ),
	'focus'=>'#',
)); 

$req = false;
if ($model->isNewRecord){
    $req = true;
}
?>


	<?php echo $form->errorSummary($model); ?>       
        
        <div class="col-sm-6">        
            <div class="control-group">
                <label class="control-label">Nama Dokumen SSUK<span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'lookup_name',array('class'=>'span3 required','maxlength'=>100,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Dokumen SSUK<span class="required"><?php echo !empty($req)?'*':'' ?></span></label></label>
                <div class="controls">
                <?php
                    echo CHtml::link("File",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
                    echo CHtml::activeHiddenField($model, 'temp_file',array('readonly' => true, 'class'=>'temp_picture_nama'));
                    echo "<br/>".CHtml::link("<u>".$model->temp_file."</u>",$this->createUrl('unduhDok',array('id'=>$model->lookup_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;', 'target'=>'_BLANK'));
                    echo "<div class='hide'>";
                    echo CHtml::activeFileField($model,'lookup_value',array( 'onchange'=>'cekFile(this);','accept'=>'application/pdf,.pdf', 'class'=>!empty($req)?'required':''));
                    echo "</div>";                                   
                ?>    
                </div>
            </div> 
            <span style="color:red;font-size:10px;"><i>File berformat PDF dan maks 5mb</i></span>
            
            <div class="control-group">
                <label class="control-label">Urutan<span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'lookup_urutan',array('class'=>'span3 numbers-only required','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                </div>
            </div>
            
            <?php if(!empty($model->lookup_id)) :?>
            <div class="control-group">
                <label class="control-label"> </label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'lookup_aktif', array('span1'))?> <label> Aktif </label>
                </div>
            </div>
            <?php endif;?>
            
        </div>
        
        <div class="col-sm-6">     
            
        </div>
        <div class="clear"></div>
	<div class="row-fluid">
	<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        $this->createUrl('create'), 
                        array('class'=>'btn btn-default',
                                  'onclick'=>'return refreshForm(this);')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Dokumen SSUK',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php 
            $content = $this->renderPartial('pengadaan.views.tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>
		</div>
	</div>
<?php $this->renderPartial('_jsFunction', array('model' => $model,'form' => $form)); ?>
<?php $this->endWidget(); ?>

        