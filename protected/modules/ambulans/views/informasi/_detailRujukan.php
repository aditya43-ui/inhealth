<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

)); ?>
<table>
    <tr>
        <td width="50%">
            <?php echo $form->textFieldRow($model,'rumahsakitrujukan',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'alamatrsrujukan',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'telp_fax',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td width="50%">
            <?php echo $form->textFieldRow($model,'tgldirujuk',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'kepadayth',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'dirujukkebagian',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textAreaRow($model,'alasandirujuk',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model,'hasilpemeriksaan_ruj',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model,'diagnosasementara_ruj',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'pengobatan_ruj',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model,'lainlain_ruj',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model,'catatandokterperujuk',array('readonly'=>true,'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget();?>