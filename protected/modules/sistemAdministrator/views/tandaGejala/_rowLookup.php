<tr no-row="0">
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]tandagejala_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]tandagejaladet_id',array('readonly'=>true));?>
		<?php //echo CHtml::activeTextField($model, '[ii]tandagejala_indikator',array('placeholder' => 'Ketik Nama Indikator Tanda Gejala', 'class'=>'span10 required'));
                    echo CHtml::activeHiddenField($model, '[ii]tandagejala_daftar_id',array('class'=>'tandagejala_daftar_id required'));
                    $this->widget('MyJuiAutoComplete', array(
                        //'tipe_text'=>'textarea',
                        'model' => $model,
                        'attribute' => '[ii]tandagejala_indikator',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('/ActionAutoComplete/GetDaftarTandaGejala') . '",
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
                            'class' => 'tandagejala_indikator span10 required',
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
		<?php echo CHtml::activeCheckBox($model,'[ii]tandagejaladet_aktif', array('rel' => 'tooltip', 'title' => 'Klik untuk menonaktifkan status Tanda Gejala', 'onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>'checked')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Tambahkan Indikator', 'class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		
	</td>
        <td style="text-align: center;" class="rowbutton">
		
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', 'javascript:;', array('rel' => 'tooltip', 'title' => 'Hapus Indikator', 'class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
