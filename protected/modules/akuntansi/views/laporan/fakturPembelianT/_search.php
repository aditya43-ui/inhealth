<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search-laporan',
        'type'=>'horizontal',
)); ?>
                <legend class="rim">Pencarian</legend>
                <table>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo $form->label($model,'tglAwal',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::hiddenField('filter_tab', 'rekap', array('readonly'=>true)); ?>
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
                                            )); 
                                    ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model,'nofaktur',array('class'=>'numberOnly')); ?>
                        </td>
                        <td>
                            <div class="control-group">
                                <?php echo $form->label($model,'tglAkhir',array('class'=>'control-label')); ?>
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
                                </div>
                            </div>
                            <?php echo $form->dropDownListRow($model,'supplier_id',CHtml::listData($model->SupplierItems, 'supplier_id', 'supplier_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
                        </td>
                    </tr>
                </table>
	<div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                    array('class' => 'btn btn-default',
                                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>