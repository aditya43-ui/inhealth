<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kupembgajipeg-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nokaskeluar'),
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'nokaskeluar',array('class'=>'span3')); ?>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'Periode Gaji', array('class' => 'control-label')); ?>  
                    <div class="controls">
                       <?php   
                                $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'periodegaji',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                )); ?>
                            <?php $model->periodegaji = $format->formatDateTimeForDb($model->periodegaji); ?>
                    </div>
            </div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('InformasiPembayaranGaji/Index'), array('class'=>'btn btn-danger')); ?>
    <?php
        $content = $this->renderPartial('../tips/informasi_penggajianKaryawan',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
