<tr>
    <td>
        <?php echo CHtml::textField('no_urut','1',array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($model,'[0]nomorindukpegawai',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
	<td>
		<?php echo  CHtml::activeHiddenField($model, '[0]pegawai_id',array('readonly'=>true,'class'=>'pegawai_id')); ?>
		<?php
		$this->widget('MyJuiAutoComplete', array(
			'model'=>$model,
			'attribute' => '[0]pegawai_nama',
			'source' => 'js: function(request, response) {
							   $.ajax({
								   url: "' . $this->createUrl('AutocompletePegawai') . '",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
			'options' => array(
				'showAnim' => 'fold',
				'minLength' => 3,
				'focus' => 'js:function( event, ui ) {
					$(this).val(ui.item.label);
					return false;
				}',
				'select' => 'js:function( event, ui ) {
					setPegawai($(this), ui.item);
					return false;
				}',
			),
			'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
			'htmlOptions'=>array('class'=>'span2','onkeypress'=>"return $(this).focusNextInputField(event)"),
		));
		?>
	</td>
	<td>
		<?php
			echo CHtml::activeDropDownList($model, '[0]jenisdiklat_id', CHtml::listData(JenisdiklatM::model()->findAll(array('order'=>'jenisdiklat_nama')),'jenisdiklat_id','jenisdiklat_nama'),
				array(
					'empty'=>'-- Pilih --',
					'onkeypress'=>"return $(this).focusNextInputField(event)",
					'style'=>'float:left;margin-right:5px;',
					'class'=>'span2 jenisdiklat_id',
				)
			);
		?>		
	</td>
	<td>
		<?php echo CHtml::activeTextField($model,'[0]namadiklat',array('class'=>'span3 namadiklat','style'=>'width:150px;','onkeypress'=> 'return $(this).focusNextInputField(event);')); ?>
	</td>
	<td>
		<?php $model->rencanadiklat_periode = $format->formatDateTimeForUser($model->rencanadiklat_periode); ?>
        <?php 
            $this->widget('MyDateTimePicker', array(
                'model'=>$model,
                'attribute'=>'[0]rencanadiklat_periode',
                'value' => 'rencanadiklat_periode', 
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,'style'=>'width:80px;','class' => "rencanadiklat_periode",'onkeypress'=> 'return $(this).focusNextInputField(event);'),
            ));
        ?>    
		<?php $model->rencanadiklat_sampaidgn = $format->formatDateTimeForUser($model->rencanadiklat_sampaidgn); ?>
        <?php 
            $this->widget('MyDateTimePicker', array(
                'model'=>$model,
                'attribute'=>'[0]rencanadiklat_sampaidgn',
                'value' => 'rencanadiklat_sampaidgn', 
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,'style'=>'width:80px;','class' => "rencanadiklat_sampaidgn",'onkeypress'=> 'return $(this).focusNextInputField(event);'),
            ));
        ?>    
	</td>
	<td>
		<?php echo CHtml::activeTextField($model,'[0]lamadiklat',array('class'=>'integer satuan_lama','style'=>'width:40px;','onkeypress'=> 'return $(this).focusNextInputField(event);')); ?>
		<?php
			echo CHtml::activeDropDownList($model, '[0]satuan_lama', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'satuanumum'),array('order'=>'lookup_urutan')),'lookup_value','lookup_value'),
				array(
					'empty'=>'-- Pilih --',
					'onkeypress'=>"return $(this).focusNextInputField(event)",
					'style'=>'width:80px;',
					'class'=>'lamadiklat'
				)
			);
		?>		
	</td>
	<td>
		<?php echo  CHtml::activeTextArea($model,'[0]tempat_diklat',array('rows'=>2, 'cols'=>10, 'class'=>'span3 tempat_diklat', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:120px;')); ?>
	</td>
	<td>
		<?php echo  CHtml::activeTextArea($model,'[0]alamat_diklat',array('rows'=>2, 'cols'=>10, 'class'=>'span3 alamat_diklat', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:120px;')); ?>
	</td>
    <td>
		<div style="display:none;" class="tambahRow">
		<?php echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowPelatihan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambahkan rencana pelatihan')); ?>
		</div>
		<div style="display:none;" class="hapusRow">
		<?php echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusPelatihan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan rencana pelatihan')); ?>
		</div>
	</td>
</tr>
