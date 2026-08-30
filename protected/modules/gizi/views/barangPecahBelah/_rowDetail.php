<tr>
    <td>
        <?php $row = isset($row) ? $row : 0; ?>
        <?php echo CHtml::textField('noUrut', ($row+1), array('readonly'=>true, 'class'=>'span1 noUrut integer')); ?>
        <?php echo CHtml::hiddenField('row', $row, array('readonly'=>true, 'class'=>'span1 row')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'['.$row.']barang_id',array('readonly'=>true,'class'=>'span1')); ?>
	</td>
    <td>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDetail,
                    'attribute'=>'['.$row.']barang_kode',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteKodeBarang').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
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
                            $(this).val(ui.item.barang_kode);
                            $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                            $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogBarang','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
    </td>
    <td>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDetail,
                    'attribute'=>'['.$row.']barang_nama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompleteBarang').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
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
                            $(this).val(ui.item.barang_nama);
                            $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                            $(this).parents("tr").find("input[name$=\"[barang_kode]\"]").val(ui.item.barang_kode);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogBarang','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
        )); ?>
    </td>
	<td>
		<?php echo $form->textField($modDetail,'['.$row.']jumlah',array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 integer'));?>
	</td>
	<td>
		<?php echo $form->textField($modDetail,'['.$row.']keterangan',array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
	</td>
	<td>
        <?php 
        echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Barang Pecah Belah')); 
        $removeButton=isset($removeButton)?$removeButton:false;
        if($removeButton){
            echo "<br><br>";
            echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan Barang Pecah Belah'));
        }
        ?>
    </td>
</tr>
