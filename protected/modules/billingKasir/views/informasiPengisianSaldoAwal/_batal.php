<?php 
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'batalpengisiansaldoawal-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        // 'focus'=>'#'.CHtml::activeId($model,'nilaisaldoawal'),
));

$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Transaksi Pembatalan Pengisian Saldo Awal berhasil disimpan !");
}

$this->widget('bootstrap.widgets.BootAlert'); 

?>

<?php  ?>
<!-- <p>sadasdasd</p>
 -->

<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

<?php echo $form->errorSummary($model); ?>
<div class='row'>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo $form->labelEx($model,'tglpembatalan',array('class' => 'control-label')) ?>
            <div class="controls"> <span class="required">*</span>
                <?php
                                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpembatalan',
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
            <?php echo CHtml::label('Pegawai Yang Membatalkan', '', array('class' => 'control-label')); ?>
            <div class="controls"> <span class="required">*</span>
                <?php
                        $cekLoginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
                        if (!empty($cekLoginpemakai->pegawai_id))
                        $cekPegawai = PegawaiM::model()->findByPk($cekLoginpemakai->pegawai_id);
                        
                        $model->pegawaibatal_id = $cekPegawai->pegawai_id;
                        $model->pegawaibatal_nama = $cekPegawai->namaLengkap;
                        echo $form->hiddenField($model, 'pegawaibatal_id', array('readonly' => true));
                        echo $form->textField($model, 'pegawaibatal_nama', array('readonly' => true,'class' => 'span3'));
                        ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Alasan Pembatalan', '', array('class' => 'control-label')); ?>
            <div class="controls"> <span class="required">*</span>
                <?php echo $form->textArea($model,'alasanpembatalan',array('required'=>'required','class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'btn_simpan','SACaraBayarM_carabayar_namalainnya')", 'maxlength'=>50)); ?>
                
            </div>
        </div>
      
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="fa fa-check"></i>')) : 
                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="fa fa-check"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="fa fa-refresh"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/informasiPengisianSaldoAwal/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;});$(\'#dialogBatal\').dialog(\'close\'); return false;'));  ?>
                              </div>

<?php $this->endWidget(); ?>
