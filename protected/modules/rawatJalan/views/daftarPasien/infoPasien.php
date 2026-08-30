<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pasienpulang-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert');?>
    
    <legend class="rim"><?php echo $data['judulLaporan']; ?></legend>
    <hr>
	<?php echo $form->errorSummary(array($modPendaftaran)); ?>
        
        <table>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPendaftaran,'no_pendaftaran', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $modPendaftaran['no_pendaftaran'];
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modRincian,'tgl_rekam_medik', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $modRincian['tgl_rekam_medik'];
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modRincian,'nama_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $modRincian->nama_pasien;
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modRincian,'no_rekam_medik', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $modRincian['no_rekam_medik'];
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="margin: 0; text-align: center;"><legend class="rim"> STATUS PASIEN: <u><?php echo $data['judulLaporan']; ?></u></legend>
                    </p>
                </td>
            </tr>
        </table>

<?php $this->endWidget(); ?>