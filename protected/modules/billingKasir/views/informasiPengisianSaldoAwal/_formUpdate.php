<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengisiansaldoawal-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nilaisaldoawal'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
<div class='row'>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo $form->labelEx($model,'tglpengisiansaldo',array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpengisiansaldo',
                                                'mode'=>'date',
                                                'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate'=>'d',   
                                                ),
                                                'htmlOptions'=>array('onchange'=>'resetTgl(this);','readonly'=>true, 'class'=>'span3 dtPicker3 realtime',
                                                'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); 
                                    ?>
            </div>
        </div>
        <div class="control-group">

        <?= CHtml::label('Cabang', '', array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_rumahsakit', array('readOnly'=>true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?= CHtml::label('Ruangan', '', array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'ruangan_nama', array('readOnly'=>true,'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Shift', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData($model->getShiftItems(), 'shift_id', 'shift_nama'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        ?>
            </div>
        </div>
       
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Pegawai', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                        $cekLoginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
                        if (!empty($cekLoginpemakai->pegawai_id))
                        $cekPegawai = PegawaiM::model()->findByPk($cekLoginpemakai->pegawai_id);
                        
                        $model->pegawai_id = $cekPegawai->pegawai_id;
                        $model->pegawai_nama = $cekPegawai->namaLengkap;
                        echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true));
                        // echo $form->hiddenField($model, 'loginpemakai_id', array('readonly' => true));
                        echo $form->textField($model, 'pegawai_nama', array('readonly' => true,'class' => 'span3'));
                        ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model,'nilaisaldoawal',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength'=>50)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($model,'keterangan',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength'=>50)); ?>
                
            </div>
        </div>
    </div>
</div>
<table>


    <tr>
   
    </tr>
</table>


<div class="row">

</div>

<!-- <div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div> -->



<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="fa fa-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="fa fa-check"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="fa fa-refresh"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/pengisiansaldoawalT/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
     <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print('.$model->pengisiansaldoawal_id.')'))."&nbsp&nbsp";?>
    <?php
                    $content = $this->renderPartial('../tips/transaksi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
    <?php //echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pengisian Saldo', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/billingKasir/pengisiansaldoawalT/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
</div>

<?php $this->endWidget(); ?>
<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(obj)
{

window.open("${urlPrint}/"+"&id="+obj,"",'location=_new, width=900px');
    

}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
