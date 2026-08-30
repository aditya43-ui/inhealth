<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'htmlOptions'=>array(),

)); ?>
<fieldset class="box">
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
<!--					<div class="controls-label">
					<?php echo CHtml::activeLabel($model, 'Tanggal Pendaftaran');?><br>
                    </div>-->
					<label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Masuk 
                  </label>
                    <div class="controls">
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                        <?php   $format = new MyFormatter;
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        ));?> </div></div>
				<div class="control-group">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                    </label>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                              <?php   $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                    </div>
                </div>                
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'instalasi_id',CHtml::listData(PCInstalasiM::model()->getInstalasiPelayanans(),'instalasi_id','instalasi_nama'),array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama')),'ruangan_id','ruangan_nama'),array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); ?>
            </td>
        </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan'));
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');

?>
<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
<?php 
           $content = $this->renderPartial('../tips/informasi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
<?php $this->endWidget();?>
</fieldset>  
<script>
document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#RIInfopasienmasukkamarV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
</script>