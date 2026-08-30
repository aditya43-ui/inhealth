<tr>
    <td>
        <?php $row = isset($row) ? $row : 0; ?>
        <?php echo CHtml::textField('noUrut', ($row+1), array('readonly'=>true, 'class'=>'span1 noUrut integer')); ?>
        <?php echo CHtml::hiddenField('row', $row, array('readonly'=>true, 'class'=>'span1 row')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'['.$row.']linen_id',array('readonly'=>true,'class'=>'span1')); ?>
	</td>
	<td>
		<?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDetail,
                    'attribute'=>'['.$row.']noregisterlinen',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteRegisterLinen').'",
                                       dataType: "json",
                                       data: {
                                           noregisterlinen: request.term,
                                        },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 3,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.noregisterlinen);
                            $(this).parents("tr").find("input[name$=\"[linen_id]\"]").val(ui.item.linen_id);
							$(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.namalinen);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogLinen','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
	</td>
    <td>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDetail,
                    'attribute'=>'['.$row.']barang_nama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteRegisterLinen').'",
                                       dataType: "json",
                                       data: {
                                           namalinen: request.term,
                                        },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 3,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.namalinen);
                            $(this).parents("tr").find("input[name$=\"[linen_id]\"]").val(ui.item.linen_id);
							$(this).parents("tr").find("input[name$=\"[noregisterlinen]\"]").val(ui.item.noregisterlinen);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogLinen','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
    </td>
    <td>
		<?php echo $form->textField($modDetail,'['.$row.']jumlah',array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 integer'));?>
	</td>
    <td>
		<?php // echo CHtml::activeDropDownList($modDetail, '['.$row.']jenisperawatanlinen', LookupM::getItems('jenisperawatan'), array('class'=>'span2')); ?>
		<?php echo $form->textField($modDetail,'['.$row.']jenisperawatanlinen',array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'readonly'=>'readonly'));?>
	</td>
	<td>
		<?php echo $form->textField($modDetail,'['.$row.']keterangan_penerimaanlinen',array());?>
	</td>
	<td>
        <?php 
        echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowLinen(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Linen')); 
        $removeButton=isset($removeButton)?$removeButton:false;
        if($removeButton){
            echo "<br><br>";
            echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalLinen(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan Linen'));
        }
        ?>
    </td>
</tr>
