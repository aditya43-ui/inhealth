<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('retur-detail-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset>
<legend class="rim2">Informasi Retur Pembelian</legend><br>
<div>
    <legend class="rim">Tabel Retur Pembelian</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'retur-detail-t-grid',
	'dataProvider'=>$model->searchRetur(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Nama Obat Alkes',
                    'value'=>'$data->obatalkes->obatalkes_nama',
                ),
                array(
                    'header'=>'Tanggal Retur',
                    'value'=>'$data->retur->tglretur',
                ),
                array(
                    'header'=>'No. Faktur',
                    'value'=>'$data->fakturdetail->fakturpembelian->nofaktur',
                ),
		//'sumberdana_id',
		array(
                    'header'=>'Alasan Retur',
                    'value'=>'$data->retur->alasanretur',
                ),
                array(
                    'header'=>'No. Retur',
                    'value'=>'$data->retur->noretur',
                ),
                array(
                    'header'=>'Jumlah Retur',
                    'value'=>'$data->jmlretur',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>
</fieldset>

<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfretur-detail-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'namaObat'),
)); ?> 
<fieldset>
    <legend class="rim">Pencarian</legend>
    <table>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Retur','', array('class'=>'control-label'));?>
                    <div class="controls">
                        <?php
                            $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                            $this->widget(
                                    'MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_awal',
                                    'mode'=>'date',
                                    'options'=>array('dateFormat'=>  Params::DATE_FORMAT,),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onkeypress'=>"return $(this).focusNextInputField(event"),  
                                    )
                                );
                            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label'));?>
                    <div class="controls">
                        <?php
                            $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                            $this->widget(
                                    'MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_akhir',
                                    'mode'=>'date',
                                    'options'=>array('dateFormat'=>  Params::DATE_FORMAT,),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onkeypress'=>"return $(this).focusNextInputField(event"),  
                                    )
                                );
                            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                        ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'namaObat',array('placeholder'=>'Nama Obat')); ?>
                <?php echo $form->textFieldRow($model,'noRetur',array('placeholder'=>'No. Retur')); ?>
                <?php echo $form->textFieldRow($model,'noFaktur',array('placeholder'=>'No. Faktur')); ?>
            </td>
        </tr>
    </table>
    
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
         <?php echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
); ?><?php
            $content = $this->renderPartial('../tips/informasi_gudangfarmasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
         ?>
    </div>
</fieldset>
    <?php $this->endWidget(); ?>
</div>