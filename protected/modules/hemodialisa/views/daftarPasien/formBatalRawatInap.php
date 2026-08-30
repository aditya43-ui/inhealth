<?php  ?>

<?php
$pasienAdmisi = $modPendaftaran->pasienadmisi_id;
if(!empty($pasienAdmisi)){ 
    $admisi = PasienadmisiT::model()->findByPk($pasienAdmisi);
    $ruangan = RuanganM::model()->findByPk($admisi->ruangan_id);
?>
<br>
<br>
    <div align="center" style="font-size: 14px;">
        <br>
        <br>
        <br>
        <br>
        <br>
        Maaf anda tidak dapat melakukan pembatalan Pasien : <b><?php echo $modPasien->nama_pasien; ?> </b>disini,<br>
        Pasien sudah di rawat inap di ruangan <b><?php echo $ruangan->ruangan_nama; ?></b> pada tanggal <b><?php echo $admisi->tgladmisi; ?></b><br>
        Silakan hubungi petugas Ruangan Rawat Inap yang bersangkutan ?
    </div>
    <div id=""></div>
    <div class="form-actions" align="center">
           <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Yes',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>"parent.$('#dialogBatalRawatInap').dialog('close');")); ?>  </div> 
<?php } else {
?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'batalrawatinap-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'method' => 'POST',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    ));
    $this->widget('bootstrap.widgets.BootAlert');
    echo $form->errorSummary(array($modPasienBatalPulang)); ?>

    <div class="row">
        <fieldset>
            <div class="panel panel-gradient">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-user"></i> Data <b>Pasien</b>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <?php
                        echo CHtml::hiddenField('pendaftaran_id', $modPendaftaran->pendaftaran_id);
                        echo CHtml::hiddenField('pasienpulang_id', $modPendaftaran->pasienpulang_id);
                        ?>
                        <tr>
                            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?> </td>
                            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik') ?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')) ?></td>
                            <td>
                                <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php //echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); 
                      echo CHtml::label('Jenis Kasus Penyakit','jeniskasuspenyakit_nama', array('class'=>'control-label') ) ; ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>
<fieldset>
	<?php if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_HD){?>
    <legend class="rim">Alasan Batal <?php $pulang = HDPasienPulangT::model()->findByPk($modPendaftaran->pasienpulang_id); echo ucwords(strtolower($pulang->carakeluar->carakeluar_nama)); ?></legend>
	<?php } ?>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <br>
        <div class="control-group ">
            <?php echo $form->labelEx($modPasienBatalPulang,'tglpembatalan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php 
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modPasienBatalPulang,
                                'attribute'=>'tglpembatalan',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'timeFormat'=>  Params::TIME_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly'=>true,
                                                 'class'=>'dtPicker3',
                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                 ),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modPasienBatalPulang, 'alasanpembatalan'); ?>
        

    <div class="form-actions">
		<?php 
			$disableSave = false;
			$disableSave = (($tersimpan=='Ya') ? true : false);
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
         <?php echo CHtml::htmlButton($modPasienBatalPulang->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)','disabled'=>$disableSave)); ?>
         <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 'javascript:void(0);' ,
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'closeDialog(); return false;'));  ?>
		<?php
           $content = $this->renderPartial('../tips/transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
    </div>   
</fieldset>
	</div>
<?php
$this->endWidget();
//if($tersimpan=='Ya'){
?>
<script>
//parent.location.reload();
function closeDialog(){
	myConfirm("Apakah anda ingin mengulang","perhatian!",function(r){
		if(r){
			window.location.href=window.location.href;
		}
	});
}
</script>
<?php
//}
}
?>