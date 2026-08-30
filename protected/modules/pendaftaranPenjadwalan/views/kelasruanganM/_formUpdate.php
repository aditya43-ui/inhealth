<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'ruangan_id'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
            <table width = "100%">
                <tr>
                    <td><?php echo $form->dropDownListRow($model,'ruangan_id',  CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3 form-control', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?></td>
                </tr>
                <tr>
                <td>
                    <?php //echo $form->checkBoxRow($model,'ruangan_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                </tr>
            </table>
            
        
        <div class="control-group">
    <div class="controls">
        
         <?php 
                  $arrKelasPelayanan = array();
                   foreach($modRuangan as $Ruangan)
                     {
                        $arrKelasPelayanan[] = $Ruangan['kelaspelayanan_id'];
                     }
                                
               $this->widget('application.extensions.emultiselect.EMultiSelect',
                             array('sortable'=>true, 'searchable'=>true)
                        );
                echo CHtml::dropDownList(
                'kelaspelayanan_id[]',
                $arrKelasPelayanan,
                CHtml::listData(PPKelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                array('multiple'=>'multiple','key'=>'kelaspelayanan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>  
</div>   
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/kelasruanganM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Ruangan', array('{icon}'=>'<i class="entypo-folder"></i>')),
                            $this->createUrl('/pendaftaranPenjadwalan/kelasruanganM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
   

    </div>

<?php $this->endWidget(); ?>
