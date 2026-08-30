<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmjenis-infeksi-nosokomial-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenisin_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenisin_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            
            <div class="control-group">
        <?php echo CHtml::label("", 'jenisin_aktif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'jenisin_aktif', array('checked' => 'jenisin_aktif')) ?> <label>Aktif</label>
        </div>	
            </div>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'jenisin_id',array('class'=>'span3')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
