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
                                 echo $form->hiddenField($modelAdmisi,'pasienadmisi_id',array('class'=>'span2','readonly'=>true));
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
                        <?php echo $form->labelEx($model,'rencanapulang', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'rencanapulang',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
//                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker3','style'=>'width:110px;'),
                            )); ?>
                            <?php echo $form->error($model, 'rencanapulang'); ?> 
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
        window.parent.myConfirm("<?php echo Yii::t('mds','Do You want to cancel?') ?>","Perhatian!",function(r) {
            if(r)
            {
                $('#iframeRencanaPulang').attr('src',$(this).attr("href"));window.parent.$('#dialogRencanaPulang').dialog('close');
                return false;
            }
            else
            {   
                $('#PIPasienM_no_rekam_medik').focus();
                return false;
            }
        });
    }
</script>
