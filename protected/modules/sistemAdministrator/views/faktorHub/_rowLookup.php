<tr no-row="0">
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]faktorhubdet_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]faktorhub_id',array('readonly'=>true));?>
		<?php 
                    //echo CHtml::activeTextField($model, '[ii]faktorhubdet_indikator',array('class'=>'span12 required'));
                    echo CHtml::activeHiddenField($model, '[ii]faktorhub_daftar_id',array('class'=>'faktorhub_daftar_id required'));
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => '[ii]faktorhubdet_indikator',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/ActionAutoComplete/GetDaftarKondisiKlinis') . '",
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
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.value);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) { 
                                setDaftar(ui.item, this);
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'saya',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'faktorhubdet_indikator span10 required',
                            'onblur'=>'if(this.value==""){clearDaftarHasil(this);}'
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogDaftarTanda',
                            'jsFunction' => 'setRow(this);$("#dialogDaftarTanda").dialog("open");'
                        ),
                    ));
                ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeCheckBox($model,'[ii]faktorhubdet_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>'checked')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		
	</td>
        <td style="text-align: center;" class="rowbutton">
		
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
