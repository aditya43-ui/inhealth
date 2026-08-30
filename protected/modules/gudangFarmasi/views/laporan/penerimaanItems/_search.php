<?php
/**
 * digunakan untuk pencarian
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
?>
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
                    <?php echo CHtml::label('Tgl. Penerimaan Items','tgl_awal', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai Dengan','tgl_akhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                </div> 
        </td>
        <td>
              <?php echo $form->textFieldRow($model,'noterima',array('class'=>'numberOnly')); ?>
              <?php echo $form->dropDownListRow($model,'supplier_id',
                                                               CHtml::listData($model->SupplierItems, 'supplier_id', 'supplier_nama'),
                                                               array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                               'empty'=>'-- Pilih --',)); ?>
        </td>
    </tr>
</table>
	<div class="form-actions">
                    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
                    <?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
); ?>
	</div>

<?php $this->endWidget(); ?>
</div>