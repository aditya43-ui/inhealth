<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppbooking-kamar-t-search',
        'type'=>'horizontal',
)); ?>
 <legend class="rim"><i class="entypo-search"></i> Pencarian berdasarkan : </legend>
<table>
    <tr>
        <td>    
               	<div class="control-group">
                    <?php echo $form->labelEx($model,'tglAwal', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglAwal',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                       
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?> </div></div>
		<div class="control-group">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                    </label>
                    <div class="controls">
                            <?php  
        
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglAkhir',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div></div></div>
                </div>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3')); ?>
                <?php echo $form->dropDownListRow($model,'statusbooking', LookupM::getItems('statusbooking'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>           	
        </td>  
        <td>
                 <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --',
                                                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                    'ajax'=>array(
                                                                                        'type'=>'POST',
                                                                                        'url'=>Yii::app()->createUrl('ActionDynamic/GetKamarRuangan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                                        'update'=>'#PPBookingKamarT_kamarruangan_id',))); 
                                ?>
                <?php echo $form->dropDownListRow($model,'kamarruangan_id', array(),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                    'type'=>'POST',
                                                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetKelasPelayanan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                                    'update'=>'#PPBookingKamarT_kelaspelayanan_id',))); 
                            ?>   
                <?php echo $form->dropDownListRow($model,'kelaspelayanan_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model,'bookingkamar_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
             
        </td>
    </tr>
</table>

	<?php //echo $form->textFieldRow($model,'bookingkamar_id',array('class'=>'span3')); ?>




	<?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3')); ?>


	<?php //echo $form->textFieldRow($model,'pasienadmisi_id',array('class'=>'span3')); ?>




	<?php //echo $form->textAreaRow($model,'keteranganbooking',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

	<div class="form-actions">
		    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	 <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('bookingKamarT/index'), array('class'=>'btn btn-danger')); ?>
	 <?php if((!$model->isNewRecord) AND ((PPKonfigSystemK::model()->find()->printkartulsng==TRUE) OR (PPKonfigSystemK::model()->find()->printkartulsng==TRUE))) 
                        {  
                ?>
                            <script>
                                print(<?php echo $model->pendaftaran_id ?>);
                            </script>
                 <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->pendaftaran_id');return false",'disabled'=>FALSE  )); 
                       }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
                       } 
                ?> 
				<?php  
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
	
	</div>

<?php $this->endWidget(); ?>
