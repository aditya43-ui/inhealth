<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadokrekammedis-m-search',
	'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'warnadokrm_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'subrak_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'nodokumenrm',array('class'=>'span3','maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'tglrekammedis',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'tglmasukrak',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'statusrekammedis',array('class'=>'span3','maxlength'=>10)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'tglkeluarakhir',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'tglmasukakhir',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'nomortertier',array('class'=>'span3','maxlength'=>2)); ?>
            <?php echo $form->textFieldRow($model,'nomorsekunder',array('class'=>'span3','maxlength'=>2)); ?>
            <?php echo $form->textFieldRow($model,'nomorprimer',array('class'=>'span3','maxlength'=>2)); ?>
            <?php echo $form->textFieldRow($model,'warnanorm_i',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'warnanorm_ii',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'tgl_in_aktif',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'tglpemusnahan',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'dokrekammedis_id',array('class'=>'span3')); ?>
         
	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
