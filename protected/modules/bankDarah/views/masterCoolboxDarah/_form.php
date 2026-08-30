<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'coolboxdarah-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#'.CHtml::activeId($model,'namacoolbox')
)); ?>
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Cool Box','coolboxdarah_nama' , array('class'=>'control-label required')) ?>
            <div class="controls"><span style="margin-left:-10px" class="required">*</span>
                <?php echo $form->textField($model,'coolboxdarah_nama',array('class'=>'span3', 'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Merek Cool Box','coolbox_merk', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'coolbox_merk',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Cool Box','coolbox_jenis', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'coolbox_jenis',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ukuran','coolbox_ukuran', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'coolbox_ukuran',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'coolbox_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'coolbox_aktif',array('checked'=>'coolbox_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jumlah Ice Pack','jml_icepack', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'jml_icepack',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jumlah Kantong','jml_isikantong', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'jml_isikantong',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kantong','jenis_kantong', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'jenis_kantong',array('class'=>'span3 hurufs-only', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Standart Suhu','standart_suhu', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'standart_suhu',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> &deg C
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            $this->createUrl('create'), 
            array('class'=>'btn btn-danger',
            'onclick'=>'return refreshForm(this);')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Cool Box',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('content'=>''));?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    
$('#tombolDaftarTindakan').click(function(){
             
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:500px;';            
    
});
</script>