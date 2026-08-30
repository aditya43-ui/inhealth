<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'jenistarif_id',CHtml::listData(SATarifTindakanM ::model()->getJenisTarifItems(), 'jenistarif_id', 'jenistarif_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'kelaspelayanan_id',CHtml::listData(SATarifTindakanM ::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'kategoritindakan_id', CHtml::listData(SATarifTindakanM ::model()->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'span3', 'style'=>'width:230px;','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'daftartindakan_kode',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'komponentarif_id', CHtml::listData(SATarifTindakanM ::model()->KomponenTarifItems, 'komponentarif_id', 'komponentarif_nama'),array('class'=>'span3', 'style'=>'width:230px;','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'harga_tariftindakan',array('class'=>'span3')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'tariftindakan_id',array('class'=>'span5')); ?>

            
            

	<?php //echo $form->textFieldRow($model,'perdatarif_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'harga_tariftindakan',array('class'=>'span2')); ?>

	<?php //echo $form->textFieldRow($model,'persendiskon_tind',array('class'=>'span1')); ?>

	<?php //echo $form->textFieldRow($model,'hargadiskon_tind',array('class'=>'span1')); ?>

	<?php //echo $form->textFieldRow($model,'persencyto_tind',array('class'=>'span1')); ?>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
