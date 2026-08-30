<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'permintaan-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nosuratpenawaran'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                        <?php echo CHtml::label('Tgl. Permintaan','tglPermintaanPenawaran', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )); 
                                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                                ?>
                            </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                                    )); 
                                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                ?>
                            </div>
                    </div> 
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'nosuratpenawaran',array('placeholder'=>'No. Permintaan Penawaran','class'=>'numberOnly')); ?>
                <div class="span5">
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'supplier_nama', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'supplier_id',CHtml::listData(SupplierM::getSupplierFarmasiItems(), 'supplier_id','supplier_nama'),array('empty'=>'-- Pilih --')); ?>
                            </div>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'ispenawaranmasuk',$model->getPenawaranMasukItems(),
                        array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); echo"&nbsp;"; ?>
        <?php
           $content = $this->renderPartial('../tips/informasi_gudangfarmasi',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>