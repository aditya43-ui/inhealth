<tr no-row="0">
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]kriteriahasildet_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]kriteriahasil_id',array('readonly'=>true));?>
		<?php //echo CHtml::activeTextField($model, '[ii]kriteriahasildet_indikator',array('class'=>'span10'));
                    echo CHtml::activeHiddenField($model, '[ii]kriteriahasil_daftar_id',array('class'=>'kriteriahasil_daftar_id required'));
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => '[ii]kriteriahasildet_indikator',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/ActionAutoComplete/GetDaftarKriteriaHasil') . '",
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
                            'placeholder' => 'Daftar Hasil Kriteria',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'kriteriahasildet_indikator span10 required',
                            'onblur'=>'if(this.value==""){clearDaftarHasil(this);}'
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogDaftarHasil',
                            'jsFunction' => 'setRow(this);$("#dialogDaftarHasil").dialog("open");'
                        ),
                    ));
                
                ?>
	</td>
	<td style="text-align: center;">
                <?php 
                if($model->kriteriahasildet_aktif == 'aktif'){
                    $checked = "checked";
                }else{
                    $checked = '';
                }  ?>
		<?php echo CHtml::activeCheckBox($model,'[ii]kriteriahasildet_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);', 'checked' => $checked)); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
        </td>
	<td style="text-align: center;" class="rowbutton">	
            <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
