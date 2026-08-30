<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppkelaspelayanan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'jeniskelas_id'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),array('class'=>'span3 form-control', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'kelaspelayanan_nama',array('class'=>'span3 form-control', 'onkeyup'=>"namaLain(this)", 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'kelaspelayanan_namalainnya',array('class'=>'span3 form-control', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
                </td>
            </tr>
            <tr>
                <td>
					<div class="control-group">
						<?php echo CHtml::label("Aktif",'kelaspelayanan_aktif', array('class'=>'control-label')) ?>
						<div class="controls">
							  <?php echo $form->checkBox($model,'kelaspelayanan_aktif',array('checked'=>'checked')); ?> 
						</div>
					</div>
                    <?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
            
            
            
            
         <?php  echo $form->labelEx($model,'Ruangan',array('class'=>'control-label required')); ?>
<div class="control-group">
    <div class="controls">
        
         <?php 
                  $arrRuangan = array();
                   foreach($modRuangan as $Ruangan)
                     {
                        $arrRuangan[] = $Ruangan['ruangan_id'];
                     }
                                
               $this->widget('application.extensions.emultiselect.EMultiSelect',
                             array('sortable'=>true, 'searchable'=>true)
                        );
                echo CHtml::dropDownList(
                'ruangan_id[]',
                $arrRuangan,
                CHtml::listData(PPRuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama"), 'ruangan_id', 'ruangan_nama'),
                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>  
</div>   
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/kelaspelayananM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Pelayanan', array('{icon}'=>'<i class="entypo-folder"></i>')),
                            $this->createUrl('/pendaftaranPenjadwalan/kelaspelayananM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    
    </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('PPKelaspelayananM_kelaspelayanan_namalainnya').value = nama.value.toUpperCase();
    }
</script>