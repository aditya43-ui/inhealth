<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'lookup-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#'.CHtml::activeId($model,'lookup_type'),
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid">
        
        <div class="control-group ">
            <label for="LookupM_lookup_type" class="control-label required">Type <span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::textField('lookup_type',$model->lookup_type,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onblur'=>'setLookup(this.value);', 'maxlength'=>100,'readonly'=>(!empty($model->lookup_id)?true:true),)); ?>
            </div>
        </div>

        
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Tabel <b>Lantai Ruangan</b>
            </div>
        </div>
        <div class="panel-body overflow-x">
            <table id="table-lookup" class="table table-striped table-bordered table-condensed">
                <thead>
                    <th>Nama Lantai</th>
                    <th>Nama Lainnya</th>
                    <th>Kode</th>
                    <th>No Lantai</th>
                    <?php if ($this->action->id == "update") :?>
                    <th>Aktif</th>
                    <?php endif; ?>
                    <th></th>
                </thead>
                <tbody>

                </tbody>
            </table>        
        <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), 
                "#", 
                array('class'=>'btn btn-default',
                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lantai Ruangan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'create'));?>
	</div>
        </div>
    </div>
    
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array('model'=>$model,'modDetail'=>$modDetail)); ?>
<script>
    function namaLain(obj)
    {
//        console.log(nama);return false;
//        document.getElementById('HDLookupM_lookup_value').value = obj.value.toUpperCase();
//        document.getElementById('HDLookupM_lookup_name')[].value = obj.value;
        $(obj).parents('tr').find('.namalain').val(obj.value.toUpperCase());
    }
</script>