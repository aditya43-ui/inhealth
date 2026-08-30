<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>'.',
        'thousands'=>',',
        'precision'=>1,
    )
));
?>
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'returpenjualan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'method'=>'post',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onSubmit'=>'return requiredCheck(this);'),
));
?>

<fieldset>
    <legend class="rim">Retur Penjualan</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($detailJuals[0],'no_rekam_medik',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'nama_pasien',array('class'=>'span3','readonly'=>true)); ?>
                <div class="control-group">
                    <label for="FAInformasipenjualanapotikV_jeniskelamin" class="control-label">Umur / Jeniskelamin</label>
                    <div class="controls">
                        <?php echo $form->textField($detailJuals[0],'umur',array('class'=>'span2','readonly'=>true)); ?> /
                        <?php echo $form->textField($detailJuals[0],'jeniskelamin',array('class'=>'span2','readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($detailJuals[0],'tglpenjualan',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'tglresep',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'noresep',array('class'=>'span3','readonly'=>true)); ?>
            </td>
        </tr>
    </table>
</fieldset>

<table>
    <tr>
        <td>
            <div class="control-group">
                <?php //echo $form->textFieldRow($modRetur,'tglretur',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->labelEx($modRetur,'tglretur', array('class'=>'control-label')) ?>
                <div class="controls">  
                 <?php $this->widget('MyDateTimePicker',array(
                                     'model'=>$modRetur,
                                     'attribute'=>'tglretur',
                                     'mode'=>'datetime',
                                     'options'=> array(
                                         'maxDate'=>'d',
                                         'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                     'htmlOptions'=>array('readonly'=>true,
                                     'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                </div> 
            </div>
            
            <?php echo $form->hiddenField($modRetur,'pasien_id',array('class'=>'span3','readonly'=>true)); ?>
            <?php echo $form->textAreaRow($modRetur,'alasanretur',array('class'=>'span3','readonly'=>false)); ?>
            <?php echo $form->textFieldRow($modRetur,'noreturresep',array('class'=>'span3','readonly'=>false)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($modRetur,'keteranganretur',array('class'=>'span3','readonly'=>false)); ?>
            <?php echo $form->textFieldRow($modRetur,'pegretur_id',array('class'=>'span3','readonly'=>true)); ?>
            <?php echo $form->dropDownListRow($modRetur,'mengetahui_id', CHtml::listData(PegawairuanganV::model()->findAll(array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3','readonly'=>false)); ?>
        </td>
    </tr>
</table>

<div id="divTabelRetur">
<?php $this->renderPartial('_tblReturPenjualan',array('detailJuals'=>$detailJuals)); ?>
</div>

<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
									      <?php 
//           $content = $this->renderPartial('../tips/tips',array(),true);
//			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
			
</div>
<div id="errorMessage" class="errorSummary"></div>

<?php $this->endWidget(); ?>