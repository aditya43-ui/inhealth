<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pasienpulang-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert');?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary(array($model)); ?>
        
        <table>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien,'no_rekam_medik', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPasien,'no_rekam_medik',array('class'=>'span2','readonly'=>true));
                                 echo $form->hiddenField($modPendaftaran,'pendaftaran_id',array('class'=>'span2','readonly'=>true));
                            ?>
                            <?php echo $form->error($modPasien, 'no_rekam_medik'); ?> 
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                 <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPendaftaran,'no_pendaftaran', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPendaftaran,'no_pendaftaran',array('class'=>'span2','readonly'=>true));
                            ?>
                            <?php echo $form->error($modPendaftaran, 'no_pendaftaran'); ?> 
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPasien,'nama_pasien',array('class'=>'span2','readonly'=>true));
                            ?>
                            <?php echo $form->error($modPasien, 'nama_pasien'); ?> 
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'tglrenkontrol', array('class'=>'control-label')) ?>
                        <div class="controls">
							<?php   
                                 echo $form->textField($model,'tglrenkontrol',array('class'=>'span2','readonly'=>true,'style'=>'width:125px;',"rel"=>"tooltip","title"=>"Satu tahun dari tanggal pendaftaran"));
                            ?>
                            <?php   
//                                    $this->widget('MyDateTimePicker',array(
//                                                    'model'=>$model,
//                                                    'attribute'=>'tglrenkontrol',
//                                                    'mode'=>'datetime',
//                                                    'options'=> array(
//                                                        'dateFormat'=>Params::DATE_FORMAT,
////                                                        'maxDate' => 'd',
//                                                    ),
//                                                    'htmlOptions'=>array('class'=>'dtPicker3','style'=>'width:125px;'),
//									)); 
							?>
                            <?php echo $form->error($model, 'tglrenkontrol'); ?> 
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>

        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
                                                                array('class' => 'btn btn-default','onclick'=>'konfirmasi()')); ?>
    </div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        // Notifikasi Pasien
        <?php 
            if(isset($smspasien)){
                if($smspasien==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
            simpanNotifikasi(params);
        <?php            
                }
            }
        ?>
    });
</script>
<?php
if($tersimpan=='Ya'){
?>
<script>
parent.location.reload();
</script>
<?php
}
?>
<script>
    function konfirmasi()
    {
//        if(confirm('<?php echo Yii::t('mds','Do You want to cancel?') ?>'))
//        {
//            $('#iframeRencanaKontrol').attr('src',$(this).attr("href"));window.parent.$('#dialogRencanaKontrol').dialog('close');
//            return false;
//        }
//        else
//        {   
//            $('#PasienM_no_rekam_medik').focus();
//            return false;
//        }
        myConfirm(' <?php echo Yii::t('mds','Do You want to cancel?') ?> ', 'Perhatian!', function(r){
            if(r){
                 $('#iframeRencanaKontrol').attr('src',$(this).attr("href"));window.parent.$('#dialogRencanaKontrol').dialog('close');
                return false;
            }else{
                $('#PasienM_no_rekam_medik').focus();
                return false;
            }
        });
    }

</script>