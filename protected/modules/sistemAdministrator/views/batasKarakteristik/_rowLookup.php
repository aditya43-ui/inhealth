<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]bataskarakteristikdet_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]bataskarakteristik_id',array('readonly'=>true));?>
		<?php // echo CHtml::activeTextField($model, '[ii]bataskarakteristikdet_indikator',array('class'=>'span12 required'));?>
                <?php echo CHtml::activeHiddenField($model, '[ii]faktorpenyebab_daftar_id', array('readonly' => true,'class'=>'faktorpenyebab_daftar_id')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => '[ii]faktorpenyebab_daftar_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutocompleteDaftarPenyebab') . '",
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
                                        setFaktorPenyebab();
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Faktor Penyebab',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4 faktorpenyebab_daftar_nama'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDaftarPenyebab','jsFunction'=>"setDialog(this);"),
                ));
                ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeCheckBox($model,'[ii]bataskarakteristikdet_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>'checked')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		
	</td>
        <td style="text-align: center;" class="rowbutton">
		
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
